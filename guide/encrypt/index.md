Encrypt
============

Encrypt is a simple hack for Kohana Frameworks original encrypt class to support
OpenSSL and its en-/decrypting methods with public / private keys and password encryption.

Other OpenSSL methods have not been implemented yet.

The module still supports mcrypt by default, so no changes are required to replace 
Kohanas standard encryption class.

Additionally the crypt() function is supported to hash strings.


Installation
-----

Copy this module to your modules directory and initialize it in your bootstrap.php

bootstrap.php

	Kohana::modules(array(
        'kohana-encrypt'           => MODPATH . 'kohana-encrypt',
    ));
    
Configuration
-----

Copy the encrypt.php config file from this module to your applications config file.

Please check the pages specific to the encryption method you want to use for more configuration advice.

Usage
-----
Please check the pages specific to the encryption method you want to use for usage examples.