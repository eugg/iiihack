<?php

class BlogAPIController extends BaseController {

	function getIndex()
	{
		echo 'welcome to blog-api';
	}

	function getID($id)
	{
		return BlogAPI::find($id)->toJson();
	}
    

}