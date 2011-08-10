<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Encrypt_Crypt extends Encrypt {
    
    const SALT_CHARACTERS = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwyxz';
    
    protected $cipher = null;
    protected $cost   = null;
    protected $loop   = null;
    protected $rounds = null;
    
    /**
	 * Returns a singleton instance of Encrypt. An encryption key must be
	 * provided in your "encrypt" configuration file.
	 *
	 *     $encrypt = Encrypt::instance('crypt');
	 *
	 * @param   string  configuration group name
	 * @return  Encrypt
	 */
	public static function instance($driver = 'crypt', $name = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Encrypt::$default_name;
		}

		if ( ! isset(Encrypt::$instances['crypt'][$name]))
		{
			// Load the configuration data
			$config = Kohana::$config->load('encrypt')->crypt[$name];

			if ( ! isset($config['cipher']))
			{
				// No default encryption key is provided!
				throw new Encrypt_Exception('No encryption method is defined in the encryption configuration group: :group',
					array(':group' => $name));
			}
            
			// Create a new instance
			Encrypt::$instances['crypt'][$name] = new Encrypt_Crypt(
                Arr::get($config, 'cipher'), 
                Arr::get($config, 'cost', 0), 
                Arr::get($config, 'loop', 0), 
                Arr::get($config, 'rounds', 0));
		}

		return Encrypt::$instances['crypt'][$name];
	}
	
    /**
	 * Creates a new crypt wrapper.
	 *
	 * @param   string   mcrypt cipher
	 */
	public function __construct($cipher, $cost = 0, $loop = 0, $rounds = 0)
	{
		if ( method_exists(__CLASS__, '_random_salt_'.$cipher) )
        {
            $this->cipher = $cipher;
            $this->cost = $cost;
            $this->loop = $loop;
            $this->rounds = $rounds;
        }
        else
        {
            throw new Encrypt_Exception('No salt generation method found for :method',
				array(':method' => $cipher));
        }
	}

	/**
	 * Encrypts a string and returns an encrypted string that can be decoded.
	 *
	 *     $data = $encrypt->encode($data);
	 *
	 * The encrypted binary data is encoded using [base64](http://php.net/base64_encode)
	 * to convert it to a string. This string can be stored in a database,
	 * displayed, and passed using most other means without corruption.
	 *
	 * @param   string  data to be encrypted
	 * @return  string
	 */
	public function encode($data)
	{
        $salt = call_user_func(array(__CLASS__, '_random_salt_' . $this->cipher));
		return crypt($data, $salt);
	}

	/**
	 * Since hashing is one-way only, this method does not do anything
	 * rather than throwing an exception when called.
	 *
	 * See "check" method
	 *
	 * @param   string  encoded string
	 *
	 */
	public function decode($data)
	{
        throw new Encrypt_Exception(__('This is a one-way encryption'));
	}
	
	/** 
	 * Check if a plain text equals to its encrypted part
	 *
	 * @param  string  $plain_text plain text
	 * @param  string  $encrypted encrypted text with salt
	 * @return bool    true / false
	 *
	 */
	public function check($plain_text, $encrypted) 
	{
        if ( method_exists(__CLASS__, '_random_salt_'.$this->cipher) )
        {
            $salt = call_user_func(array(__CLASS__, '_extract_salt_' . $this->cipher), $encrypted);
        }
        else
        {
            throw new Encrypt_Exception('No salt extractin method found for :method',
				array(':method' => $cipher));
        }
        
        return $encrypted == crypt($plain_text, $salt);
        
	}
	
	/*
	 * Return the implemented methods (ciphers)
	 */
	public function get_cipher_methods()
    {
        return array(
            'CRYPT_STD_DES',
            'CRYPT_EXT_DES',
            'CRYPT_MD5',
            'CRYPT_BLOWFISH',
            'CRYPT_SHA256',
            'CRYPT_SHA512',
        );
    }
    
    protected function _random_salt_CRYPT_STD_DES()
    {
        $tmp_salt = $salt = '';
        for ( $i = 0; $i < rand(80, 200); $i++ ) 
        {
            $tmp_salt .= substr(str_shuffle(self::SALT_CHARACTERS), 0, 1);
        }
        for ( $i = 0; $i < 2; $i++ )
        {
            $salt .= $tmp_salt[ rand(0, strlen($tmp_salt) - 1) ];
        }
        
        return $salt;
    }
    
    protected function _extract_salt_CRYPT_STD_DES($encrypted)
    {
        return substr($encrypted, 0, 2);
    }
    
    protected function _random_salt_CRYPT_EXT_DES()
    {
        $tmp_salt = $salt = '';
        for ( $i = 0; $i < rand(80, 200); $i++ ) 
        {
            $tmp_salt .= substr(str_shuffle(self::SALT_CHARACTERS), 0, 1);
        }
        for ( $i = 0; $i < 8; $i++ ) 
        {
            $salt .= $tmp_salt[ rand(0, strlen($tmp_salt) - 1) ];
        }
        
        return '_' . $salt;
    }
    
    protected function _extract_salt_CRYPT_EXT_DES($encrypted)
    {
        return substr($encrypted, 0, 9);
    }
    
    protected function _random_salt_CRYPT_MD5()
    {
        $tmp_salt = $salt = '';
        for ( $i = 0; $i < rand(80, 200); $i++ ) 
        {
            $tmp_salt .= substr(str_shuffle(self::SALT_CHARACTERS), 0, 1);
        }
        for ( $i = 0; $i < 9; $i++ ) 
        {
            $salt .= $tmp_salt[ rand(0, strlen($tmp_salt) - 1) ];
        }
        
        return '$1$' . $salt;
    }
    
    protected function _extract_salt_CRYPT_MD5($encrypted)
    {
        return substr($encrypted, 0, 12);
    }
    
    protected function _random_salt_CRYPT_BLOWFISH()
    {
        $tmp_salt = $salt = '';
        for ( $i = 0; $i < rand(80, 200); $i++ ) 
        {
            $tmp_salt .= substr(str_shuffle(self::SALT_CHARACTERS), 0, 1);
        }
        for ( $i = 0; $i < 22; $i++ ) 
        {
            $salt .= $tmp_salt[ rand(0, strlen($tmp_salt) - 1) ];
        }
        
        return '$2a$' . $this->cost . '$' . $salt;
    }
    
    protected function _extract_salt_CRYPT_BLOWFISH($encrypted)
    {
        return substr($encrypted, 0, 29);
    }
    
    protected function _random_salt_CRYPT_SHA256()
    {
        $tmp_salt = $salt = '';
        for ( $i = 0; $i < rand(80, 200); $i++ ) 
        {
            $tmp_salt .= substr(str_shuffle(self::SALT_CHARACTERS), 0, 1);
        }
        for ( $i = 0; $i < 16; $i++ ) 
        {
            $salt .= $tmp_salt[ rand(0, strlen($tmp_salt) - 1) ];
        }
        
        return '$5$rounds='.$this->rounds.'$' . $salt;
    }
    
    protected function _extract_salt_CRYPT_SHA256($encrypted)
    {
        return substr($encrypted, 0, strpos($encrypted, '$', 3) + 1 + 16);
    }
    
    protected function _random_salt_CRYPT_SHA512()
    {
        $tmp_salt = $salt = '';
        for ( $i = 0; $i < rand(80, 200); $i++ ) 
        {
            $tmp_salt .= substr(str_shuffle(self::SALT_CHARACTERS), 0, 1);
        }
        for ( $i = 0; $i < 16; $i++ ) 
        {
            $salt .= $tmp_salt[ rand(0, strlen($tmp_salt) - 1) ];
        }
        
        return '$6$rounds='.$this->rounds.'$' . $salt;
    }
    
    protected function _extract_salt_CRYPT_SHA512($encrypted)
    {
        return substr($encrypted, 0, strpos($encrypted, '$', 3) + 1 + 16);
    }
}