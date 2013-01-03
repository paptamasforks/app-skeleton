<?php defined('SYSPATH') or die('No direct access allowed.');

return array(	
	'app_name'          => 'YOUR-APP-NAME', // ex. Sample app

	// Go to api console (https://code.google.com/apis/console#access) to get these
    'client_id'  	    => '840209404964.apps.googleusercontent.com',
	'client_secret'	    => 'kVpdkSjjz-sEZQnRuwHeZiag',

    // If you can't find your developer key: http://goo.gl/qWF1m
    'developer_key'	    => 'AIzaSyA8LLgHKkO2ajCqNldI_N1AhFzuc2xpPZM', // also known as API key
    
	'redirect_uri'	    => 'http://localhost/workplace/app-skeleton/oauth/google',
    'approval_prompt'   => 'auto' // force or auto
);
