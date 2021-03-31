<?php

/**
* Categories Page for PicoCMS
*
* @author c4cat
* @link https://github.com/c2315147
*/



class pico_categories_page extends AbstractPicoPlugin
{
	const API_VERSION = 3;
	private $cat = array();

	public function onSinglePageLoaded (array &$pageData )
	{
	    $pageData['category'] = $pageData['meta']['category'];
	    $pageData['purpose'] = $pageData['meta']['purpose'];
	}


    	public function onPagesLoaded(
	    array &$pages,
	    array &$currentPage = null,
	    array &$previousPage = null,
	    array &$nextPage = null 
    	)
   	{   
	   
	    $this->pages = $pages;

	    foreach($this->pages as $k => $page)
	    {
	    	if($page['category']) {   
		    $this->cat[$page['category']][$page['title']] = $page['url'];
		}
	    }

	    ksort($this->cat);
	
	    foreach($this->cat as $key => $value) {
	            ksort($this->cat[$key]);
	    }  

	}


	public function onPageRendering(string &$templateName, array &$twigVariables)
    	{
	     $twigVariables['pico_categories_page'] = $this->cat;
	}

}
?>
