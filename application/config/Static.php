<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(
    'css'           => '<link rel="stylesheet/less" type="text/css" href="'.Url::map('static', 'less/bootstrap.less').'">',
    'javascript'    => Javascript::instance('javascript')->scan()->render()
);