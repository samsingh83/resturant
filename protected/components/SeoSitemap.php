<?php
class SeoSitemap
{
	var $xml_data;	
	
	public function createSiteMap()
	{
		
	}
	
	private function xmlHeader()
	{
		$this->xml_data='<?xml version="1.0" encoding="UTF-8"?>';
		$this->xml_data.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
		
	}
	
	private function xmlFooter()
	{
		$this->xml_data.="</urlset>";
	}
	
} /*END SeoSitemap*/