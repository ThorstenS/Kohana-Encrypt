<?php defined('SYSPATH') or die('No direct script access.');

return array(
    
    'mcrypt' => array(
    	'default' => array(
    		/**
    		 * The following options must be set:
    		 *
    		 * string   key     secret passphrase
    		 * integer  mode    encryption mode, one of MCRYPT_MODE_*
    		 * integer  cipher  encryption cipher, one of the Mcrpyt cipher constants
    		 */
    		'cipher' => MCRYPT_RIJNDAEL_128,
    		'mode'   => MCRYPT_MODE_NOFB,
    		'key'    => '',
    	),
    ),
    
    'openssl'   => array(
        'default' => array(
            
            // Methods used for en-/decryption
            'encrypt_with'   => 'openssl_public_encrypt',
            'decrypt_with'   => 'openssl_private_decrypt',
            
            // If key based method chosen: provide keys or path to key
            // format file://relative/path/to/file.pem
            'public_key'  => 'file:///absolute/path/to/my_public_key.pem',
            'private_key' => 'file:///absolute/path/to/my_private_key.pem',
        ),
    ),
);
