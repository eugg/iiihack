<?php

class DelicacyAPIController extends BaseController {

	function getIndex()
	{
		echo 'welcome to delicacy-api';
	}

	function getID($id)
	{
		return DelicacyAPI::find($id)->toJson();
	}
    

}