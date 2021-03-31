<?php

/**
* Plugin providing basic search functionality
*
* @author c4cat
* @link https://github.com/c2315147
* @license http://opensource.org/licenses/MIT
*/
class PicoSearch extends AbstractPicoPlugin
{
    const API_VERSION = 3;
    
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

    public function onSinglePageLoaded (array &$pageData )
    {
        $pageData['search_term'] = '';
        $pageData['search_results'] = array();
        $pageData['search_num_results'] = 0;
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
    
    public function onPageRendering(string &$templateName, array &$twigVariables)
    {
        $q=" ";
        if ($templateName == "search.twig") {
            $q = trim($_GET['q']);
        };
        
        while (strstr($q, "  ")) $q = str_replace("  ", " ", $q);
        $qs = explode(" ", $q);

        foreach($this->pages as $k => $page)
        {
            if (isset($this->baseDir) && strpos($page['id'], $this->baseDir) !== 0) {
                continue;
            }
            $this->pages[$k]["score"] = 0;
            $title = $page["title"];
            $content = $page["raw_content"];

            if (stripos($title, $q) === false) { } else {$this->pages[$k]["score"]+= 10;}
            if (stripos($content, $q) === false ) {} else {$this->pages[$k]["score"]+= 10;}
            
            foreach($qs as $query)
            {
                if (stripos($title, $query) === false) {} else {$this->pages[$k]["score"]+= 3;}
                if (stripos($content, $query) === false) {} else {$this->pages[$k]["score"]+= 3;}
            }
        }

        $counts = array();
        foreach($this->pages as $page) $counts[] = $page["score"];
        array_multisort($counts, $this->pages);
        
        foreach(array_reverse($this->pages) as $page)
        {
            if ($page["score"] > 0) $twigVariables['search_results'][] = $page;
        }

        if (empty($twigVariables['search_results'])) {
            $twigVariables['search_num_results'] = 0;
        } else {
            $twigVariables['search_num_results'] = count($twigVariables['search_results']);
        }
        
    }
}
?>
