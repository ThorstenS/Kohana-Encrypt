Kohana-Encrypt
============

Kohana-Encrypt is a simple hack for Kohana Frameworks original encrypt class to support
OpenSSL and its en-/decrypting methods with public / private keys.

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

To use OpenSSL you need to provide a public / private key in the config file.

This can either be the key itself, including "-----BEGIN PUBLIC KEY-----", 
or a path to the keyfile formated "file://path/to/key.pem"

Usage
-----

$encrypt = Encrypt::instance('openssl');
$text = $encrypt->encode('Hallo Welt!');
echo $text;
echo $encrypt->decode($text);