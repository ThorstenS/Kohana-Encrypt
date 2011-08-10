# Encrypt
Encrypt is a simple hack for Kohana Frameworks original encrypt class to support
OpenSSL and its en-/decrypting methods with public / private keys and password encryption.

Other OpenSSL methods have not been implemented yet.

The module still supports mcrypt by default, so no changes are required to replace 
Kohanas standard encryption class.

Additionally the crypt() function is supported to hash strings.

# Installation
Copy this module to your modules directory and initialize it in your bootstrap.php

bootstrap.php

	Kohana::modules(array(
        'kohana-encrypt'           => MODPATH . 'kohana-encrypt',
    ));
    
# Configuration
Copy the encrypt.php config file from this module to your applications config file.

Please check the pages specific to the encryption method you want to use for more configuration advice.

# Usage
Please check the pages specific to the encryption method you want to use for usage examples.

# mCrypt

## Configuration

To configure mCrypt, go to the configuration group called 'mcrypt'.
You'll probably want to edit the "default" section.

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

You need to provide a passphrase for encryption in the "key" parameter.

Additionally, you'll need to choose a cipher method and a mode.

Check PHPs [Mcrypt documentation](http://pl2.php.net/manual/en/book.mcrypt.php) for further details.

## Usage

    $encrypt = Encrypt::instance();
    $text = $encrypt->encode('Hello World!');
    echo $text;
    echo $encrypt->decode($text);
    
# OpenSSL

## Configuration

To configure openssl, go to the configuration group called 'openssl'.
You'll probably want to edit the "default" section.

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
    ),

First, you need to decide which encryption method you want to use.

### OpenSSL_Encrypt

Standard encryption through a password sting can be done via "openssl_encrypt".

You need to decide which method is used to encrypt. Check [PHPs OpenSSL documentation](http://pl2.php.net/manual/en/function.openssl-get-cipher-methods.php) for a list of valid entries.

You'll also need a password, that, of course, you'll never share with anybody.

And you'll need an initialization vector, the length of it depends on the method you've chosen.

### Openssl_Public_Encrypt / Openssl_Private_Encrypt

To use OpenSSL and keyfile based encryption you need to provide a public / private key in the config file.

This can either be the key itself, including "-----BEGIN PUBLIC KEY-----", 
or a path to the keyfile formated "file://path/to/key.pem"

Please note: To get the maximum of security out of this method, you should not, if somehow possible, store the corresponding opposite key, that you'll need for decryption, on the same server.

## Usage

    $encrypt = Encrypt::instance('openssl');
    $text = $encrypt->encode('Hello World!');
    echo $text;
    echo $encrypt->decode($text);

If your private key is password protected, submit the password to the encode() / decode() methods:

    echo $encrypt->decode($text, $password);

# Crypt

## Configuration

To configure crypt, go to the configuration group called 'crypt'.
You'll probably want to edit the "default" section.

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
    		'rounds'    => 13000,
    	),
    ),

First, you need to decide which encryption method you want to use.

### CRYPT_STD_DES
No further settings are required.

### CRYPT_EXT_DES
No further settings are required.

### CRYPT_MD5
No further settings are required.

### CRYPT_BLOWFISH
The two digit "cost" parameter must be specified. It is the base-2 logarithm of the iteration count for the algorithm and must be in range 04-31.

### CRYPT_SHA256 / CRYPT_SHA512
The parameter 'rounds' must be specified. It indicates how many times the hashing loop should be executed, much like the cost parameter on Blowfish. It must be in range 1000-999,999,999.

## Usage

Beware that crypt() produces a hash, it is not reversible, means you can't get back the original string you encrypted.

    $encrypt = Encrypt::instance('crypt');
    $text = $encrypt->encode('Hello World!');
    echo $text;
    var_dump($encrypt->check('Hello World!', $text));