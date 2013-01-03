<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(
    'static'                => 'static/{1}',

    'auth.signup'           => 'auth/signup',
    'auth.after_signup'     => '',
    'auth.edit'             => 'auth/edit',
    'auth.after_edit'       => '',
    'auth.login'            => 'auth/login',
    'auth.after_login'      => '',
    'auth.after_logout'     => 'auth/login/',
    'auth.recover'          => 'auth/recover/',
    'auth.after_recover'    => 'auth/message/recovered',
    'auth.reset'            => 'auth/reset/',
    'auth.reset_expired'    => 'auth/message/expired_link',
    'auth.message'          => 'auth/message/',

    'service.auth.login'    => 'service/auth/login'
);