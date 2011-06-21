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
    	
    	'unittest' => array(
    		/**
    		 * The following options must be set:
    		 *
    		 * string   key     secret passphrase
    		 * integer  mode    encryption mode, one of MCRYPT_MODE_*
    		 * integer  cipher  encryption cipher, one of the Mcrpyt cipher constants
    		 */
    		'cipher' => MCRYPT_RIJNDAEL_128,
    		'mode'   => MCRYPT_MODE_NOFB,
    		'key'    => 'unittestkey',
        ),
    ),
    
    'openssl'   => array(
        'default' => array(
            
            // Method used for encryption, either 
            // openssl_encrypt 
            // openssl_public_encrypt or 
            // openssl_private_encrypt
            'encrypt_method'   => '',
            
            // If key based method chosen: provide keys or path to key
            // format file://relative/path/to/file.pem
            'public_key'  => '',
            'private_key' => '',
            
            // 
            // For method: openssl_encrypt
            //
            // Cipher
            'method'    => '',
            // Password
            'password'  => '',
            // Initialization vector
            'iv'        => '',
        ),
        
        'unittest_encrypt_decrypt' => array(
            'encrypt_method'   => 'openssl_encrypt',
            'method'    => 'AES-128-CBC',
            'password'  => 'unittestpassword',
            'iv'        => 'strangestring123',
        ),
        
        'unittest_public_encrypt_private_decrypt' => array(
            'encrypt_method'   => 'openssl_public_encrypt',
            'public_key'  => 'file://' . MODPATH . '/encrypt/tests/data/publickey.pem',
            'private_key' => 'file://' . MODPATH . '/encrypt/tests/data/privatekey.pem',
        ),
        
        'unittest_private_encrypt_public_decrypt' => array(
            'encrypt_method'   => 'openssl_private_encrypt',
            'public_key'  => 'file://' . MODPATH . '/encrypt/tests/data/publickey.pem',
            'private_key' => 'file://' . MODPATH . '/encrypt/tests/data/privatekey.pem',
        ),
    ),
);
