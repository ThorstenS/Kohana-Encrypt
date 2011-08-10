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