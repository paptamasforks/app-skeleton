<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	// Go to your facebook apps (https://developers.facebook.com/apps) to get these
    'appId'			    => '125797320912886',
	'secret'		    => '585953e5990c9f0c485c4ce055205799',
	'next'			    => 'http://localhost/workplace/app-skeleton/oauth/facebook',
	'cancel_url'	    => 'http://localhost/workplace/app-skeleton',
	'req_perms'		    => 'email', 

	// Full list of permission you can request is available here: https://developers.facebook.com/docs/reference/api/permissions/    
);