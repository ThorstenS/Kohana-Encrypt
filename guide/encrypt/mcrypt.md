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