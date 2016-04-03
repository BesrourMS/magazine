<?php

/**
* Categories Page for PicoCMS
*
* @author Renhard Julindra (http://renhard.net)
* @link https://github.com/julindra/pico_categories_page
*/

class Pico_Categories_Page
{
    private $cat = array();
    
    public function before_read_file_meta(&$headers)
    {
        $headers['purpose'] = 'Purpose';
        $headers['category'] = 'Category';
    }

    public function get_page_data(&$data, $page_meta)
    {
        $data['category'] = $page_meta['category'];
    }

    public function get_pages(&$pages, &$current_page, &$prev_page, &$next_page)
    {
        foreach($pages as $key => $page) {
            if($page['category']) {
                $this->cat[$page['category']][$page['title']] = $page['url'];
            }
        }
        ksort($this->cat);
        foreach($this->cat as $key => $value) {
            ksort($this->cat[$key]);
        }
    }

    public function before_render(&$twig_vars, &$twig)
    {
        $twig_vars['pico_categories_page'] = $this->cat;
    }
}
?>