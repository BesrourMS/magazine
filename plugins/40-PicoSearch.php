<?php

/**
* Plugin providing basic search functionality
*
* @author mwgg
* @link https://github.com/mwgg/Pico-Search
* @license http://opensource.org/licenses/MIT
*/
class PicoSearch extends AbstractPicoPlugin
{
    protected $enabled = true;
    protected $dependsOn = array();
    private $pages = array();
    private $baseDir = null;

    public function onConfigLoaded(&$settings)
    {
        if (isset($settings['search_base_dir']) && strlen($settings['search_base_dir']) > 0) {
            $this->baseDir = $settings['search_base_dir'];
        }
    }

    public function onMetaHeaders(array &$headers)
    {
        $headers['purpose'] = 'Purpose';
    }

    public function onPagesLoaded(
        array &$pages,
        array &$currentPage = null,
        array &$previousPage = null,
        array &$nextPage = null
    )
    {
        $this->pages = $pages;
    }

    public function onPageRendering(Twig_Environment &$twig, array &$twigVariables, &$templateName)
    {
        $q = strtoupper(trim($_GET["q"]));
        while (strstr($q, "  ")) $q = str_replace("  ", " ", $q);
        $qs = explode(" ", $q);

        foreach($this->pages as $k => $page)
        {
            if (isset($this->baseDir) && strpos($page['id'], $this->baseDir) !== 0) {
                continue;
            }
            $this->pages[$k]["score"] = 0;
            $title = strtoupper($page["title"]);
            $content = strtoupper($page["content"]);

            if (strstr($title, $q)) $this->pages[$k]["score"]+= 10;
            if (strstr($content, $q)) $this->pages[$k]["score"]+= 10;

            foreach($qs as $query)
            {
                if (strstr($title, $query)) $this->pages[$k]["score"]+= 3;
                if (strstr($content, $query)) $this->pages[$k]["score"]+= 3;
            }
        }

        $counts = array();
        foreach($this->pages as $page) $counts[] = $page["score"];
        array_multisort($counts, $this->pages);
        
        foreach(array_reverse($this->pages) as $page)
        {
            if ($page["score"] > 0) $twigVariables['search_results'][] = $page;
        }

        $twigVariables['search_num_results'] = count($twigVariables['search_results']);
        $twigVariables['search_term'] = trim($_GET["q"]);
    }
}
?>
