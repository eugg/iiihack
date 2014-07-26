<?php

class PageController extends BaseController {

	function index()
	{
		return View::make('site.pages.index');
	}

	function getStart()
	{
		return View::make('site.pages.start');	
	}

	function getGeo()
	{
		return View::make('site.pages.geo');
	}

    

}