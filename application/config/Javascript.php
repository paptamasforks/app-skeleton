<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(
    // Directories to scan for javascript files (relative to DOCROOT)
    'dirs' => array(
        'static/js/application'
    ),

    // Files to exclude
    'exclude' => array(

    ),

    // External resources
    'external' => array(
        // jQuery
        'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',

        // CanJS
        'https://s3-eu-west-1.amazonaws.com/cdn-development/canjs/v1.0.7/can.combined-1.0.7.min.js',

        // Js core
        'https://s3-eu-west-1.amazonaws.com/cdn-development/js-core/v1.0.0/js-core.min.js',

        // Foundation
        'https://s3-eu-west-1.amazonaws.com/cdn-development/foundation/v1.0.0/foundation.min.js',

        // jQuery++
        'https://s3-eu-west-1.amazonaws.com/cdn-development/jquerypp/v1.0.b/jquery.lang.json.js',
        'https://s3-eu-west-1.amazonaws.com/cdn-development/jquerypp/v1.0.b/jquery.form_params.js',

        // Less
        'https://s3-eu-west-1.amazonaws.com/cdn-development/lessjs/v1.3.0/less-1.3.0.min.js',

        // Utilities
        'https://s3-eu-west-1.amazonaws.com/cdn-development/plugins/purl/v2.2.1/purl.js'
    ),

    // Files listed here will be added before any directory scanning, immediately after external resources
    'priority' => array(
        // Init
        'static/js/init.js',
        'static/js/application/config/urls.js'
),

    /**
     * Dependencies
     * NOTE: In some cases you can handle dependencies simply by scanning
     * your js directories in the appropriate order.
     */

    'dependencies' => array(

    ),

    // Base url - used to create absolute path to js files
    'base_url' => Url::base(TRUE)
);