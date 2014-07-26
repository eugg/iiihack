<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array('email'),
        ),
        /**
		 * Google
		 */	
        'Google' => array(
	    'client_id'     => '',
	    'client_secret' => '',
	    'scope'         => array('userinfo_email', 'userinfo_profile','calendar'),
		),  	

	)

);