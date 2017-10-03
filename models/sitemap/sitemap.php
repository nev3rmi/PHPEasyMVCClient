<?php
namespace PHPEasy\Models;
use PHPEasy\Cores as Cores;

class Sitemap extends Cores\_Model{
    function __construct(){
		parent::__construct();
    }
    
    function CreateSitemap(){
        $render = null;
        $sitemap['xmlopen'] = 
        '<?xml version="1.0" encoding="UTF-8"?>' 
        . "\n"
        . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . 
        "\n";
        
        $sitemap['xmlclose'] = '</urlset>';
        
        $sitemap['collection'] = Cores\_Session::Get('sitemap') -> sitemapData;

        $sitemap['data'] = '';

        foreach ($sitemap['collection'] as $key => $value){
            $sitemap['data'] .= '<url>'."\n"
                                .'<loc>'.Cores\_Site::GetUrl().substr($value['PageUrl'], 1).'</loc>'."\n"
                                .'<lastmod>'.date("Y-m-d",strtotime($value['UpdatedTime'])).'</lastmod>'."\n"
                                .'<changefreq>weekly</changefreq>'."\n"
                                .'<priority>0.9</priority>'."\n"
                                .'</url>'."\n"

            ;
        }

        

        $render .=  $sitemap['xmlopen']. $sitemap['data'] . $sitemap['xmlclose'];




        return $render;
    }
}
