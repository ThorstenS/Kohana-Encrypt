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
    
    'crypt' => array(
    	'default' => array(
    		/**
    		 * The following options must be set:
    		 *
    		 * string  cipher  encryption cipher, one of the crpyt cipher constants as string
    		 * integer  cost   For BLOWFISH ONLY: The two digit cost parameter is the base-2 logarithm of the iteration count for the underlying Blowfish-based hashing algorithmeter and must be in range 04-31
    		 * integer loop   For SHAxxx ONLY: The numeric value is used to indicate how many times the hashing loop should be executed, much like the cost parameter on Blowfish
    		 * integer rounds For SHAxxx ONLY: Minimum of 1000 and a maximum of 999,999,999.
    		 */
    		'cipher'  => 'CRYPT_BLOWFISH',
    		'cost'    => 13,
    	),
    	
    	'unittest_CRYPT_STD_DES' => array(
    		'cipher' => 'CRYPT_STD_DES',
        ),
        'unittest_CRYPT_CRYPT_EXT_DES' => array(
    		'cipher' => 'CRYPT_EXT_DES',
        ),
        'unittest_CRYPT_CRYPT_MD5' => array(
    		'cipher' => 'CRYPT_MD5',
        ),
        'unittest_CRYPT_BLOWFISH' => array(
    		'cipher' => 'CRYPT_BLOWFISH',
    		'cost'    => 13,
        ),
        'unittest_CRYPT_CRYPT_SHA256' => array(
    		'cipher' => 'CRYPT_SHA256',
    		'loop'    => 13,
    		'rounds'  => 13000,
        ),
        'unittest_CRYPT_CRYPT_SHA512' => array(
    		'cipher' => 'CRYPT_SHA512',
    		'loop'    => 13,
    		'rounds'  => 13000,
        ),
    ),
);
