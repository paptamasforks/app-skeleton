// Set environment: development/production
var ENVIRONMENT = 'development';

// Set up the base url here if you don't want javascript to detect it automatically
var BASE_URL = '';
var localhostBase = 'http://localhost/workplace/';

if ( ! BASE_URL) {
    // Define window.location.origin
    if ( ! window.location.origin) {
        window.location.origin = window.location.protocol+"//"+window.location.host;
    }

    if (window.location.host == 'localhost') {
        // We are on localhost
        var url = document.location.href;
        BASE_URL = localhostBase + ((url.split('/')[4]) ? url.split('/')[4] : '') + '/';
    }
    else {
        // We are on a production server
        BASE_URL = window.location.origin + '/';
    }

    if (ENVIRONMENT == 'development') {
        try { console.log('BASE_URL: ' + BASE_URL); } catch(err) {};
    }
}