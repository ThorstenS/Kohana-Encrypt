Kohana-Encrypt
============

Kohana-Encrypt is a simple hack for Kohana Frameworks original encrypt class to support
OpenSSL and its en-/decrypting methods with public / private keys and password encryption.

Other OpenSSL methods have not been implemented yet.

The module still supports mcrypt by default, so no changes are required to replace 
Kohanas standard encryption class.


Installation
-----

Copy this module to your modules directory and initialize it in your bootstrap.php

bootstrap.php

	Kohana::modules(array(
        'kohana-encrypt'           => MODPATH . 'kohana-encrypt',
    ));


Configuration
-----

To use OpenSSL and keyfile based encryption you need to provide a public / private key in the config file.

This can either be the key itself, including "-----BEGIN PUBLIC KEY-----", 
or a path to the keyfile formated "file://path/to/key.pem"

Please note: This type of encryption is only safe if you do not store both keys on your server at the same time!

Usage
-----

    $encrypt = Encrypt::instance('openssl');
    $text = $encrypt->encode('Hello World!');
    echo $text;
    echo $encrypt->decode($text);
