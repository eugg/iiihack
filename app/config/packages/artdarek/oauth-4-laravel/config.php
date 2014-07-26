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
	    'client_id'     => '269995598337-m3efvom4asl7llgtpveu8gbtbp56ne7a.apps.googleusercontent.com',
	    'client_secret' => 'Wylxq2yRTVuS6B_4_0MpfiZp',
	    'scope'         => array('userinfo_email', 'userinfo_profile'),
		),  	

	)

);