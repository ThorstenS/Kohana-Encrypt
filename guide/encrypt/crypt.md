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

### CRYPT_SHA256 
### CRYPT_SHA512
The parameter 'rounds' must be specified. It indicates how many times the hashing loop should be executed, much like the cost parameter on Blowfish. It must be in range 1000-999,999,999.

## Usage

Beware that crypt() produces a hash, it is not reversible, means you can't get back the original string you encrypted.

    $encrypt = Encrypt::instance('crypt');
    $text = $encrypt->encode('Hello World!');
    echo $text;
    var_dump($encrypt->check('Hello World!', $text));