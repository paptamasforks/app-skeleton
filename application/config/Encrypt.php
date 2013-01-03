<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(
	/**
     * Default config group
     */
    'default' => array(
        /**
         * Security key to use for encryption/decryption
         */
        'key' => '8db4837a02b6ab07aeca2165638e73df',

        /**
         * Cipher to use
         * Check out: http://php.net/manual/en/mcrypt.ciphers.php for the complete list
         */
        'cipher' => MCRYPT_RIJNDAEL_128,

        /**
         * Mode to use
         * Check out: http://www.php.net/manual/en/mcrypt.constants.php for the complete list
         */
        'mode' => MCRYPT_MODE_NOFB
    )
);