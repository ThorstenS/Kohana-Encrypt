<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Encrypt_Openssl extends Encrypt {
    
    /**
	 * Returns a singleton instance of Encrypt. An encryption method must be
	 * provided in your "encrypt" configuration file.
	 *
	 *     $encrypt = Encrypt::instance('openssl');
	 *
	 * @param   string  configuration group name
	 * @return  Encrypt
	 */
	public static function instance($name = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Encrypt::$default_name;
		}

		if ( ! isset(Encrypt::$instances['openssl'][$name]))
		{
			// Load the configuration data
			$config = Kohana::config('encrypt')->openssl[$name];

			if ( empty($config['encrypt_with']) OR empty($config['decrypt_with']) )
			{
				// No default encryption key is provided!
				throw new Kohana_Exception('No en-/decryption method is defined in the encryption configuration group: :group',
					array(':group' => $name));
			}

			// Create a new instance
			Encrypt::$instances['openssl'][$name] = new Kohana_Encrypt_Openssl($config);
		}

		return Encrypt::$instances['openssl'][$name];
	}
	
    /**
	 * Creates a new object.
	 *
	 * @param   array   config array
	 *
	 */
	public function __construct(array $config)
	{
		foreach ( $config AS $key => $value )
		{
            $this->$key = $value;
		}
		
		if ( ! empty($this->public_key) AND substr($this->public_key, 0, 4) == 'file' )
		{
            $this->public_key = openssl_pkey_get_public($this->public_key);
		}
		
		if ( ! empty($this->private_key) AND substr($this->private_key, 0, 4) == 'file' )
		{
            $this->private_key = openssl_pkey_get_private($this->private_key);
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
		switch ($this->encrypt_with) 
		{
            // Encrypt with openssl_public_encrypt
		    case 'openssl_public_encrypt':
		        $data = $this->_openssl_public_encrypt($data);
		        break;
		      
            // Encrypt with openssl_private_encrypt
		    case 'openssl_private_encrypt':
		        $data = $this->_openssl_private_encrypt($data);
		        break;
            
            // There is no default method, throw exception
            default:
                throw new Encryption_Exception('Encryption method not implemented');
                break;
		}
		
		return base64_encode($data);
	}
    
    private function _openssl_public_encrypt($data)
    {
        $result = openssl_public_encrypt($data, $return, $this->public_key);
        
        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Encryption failed');
    }
    
    private function _openssl_private_encrypt($data)
    {
        $result = openssl_private_encrypt($data, $return, $this->private_key);
        
        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Encryption failed');
    }
    
	/**
	 * Decrypts an encoded string back to its original value.
	 *
	 *     $data = $encrypt->decode($data);
	 *
	 * @param   string  encoded string to be decrypted
	 * @return  FALSE   if decryption fails
	 * @return  string
	 */
	public function decode($data)
	{
        $data = base64_decode($data, true);
        
		switch ($this->decrypt_with) 
		{
            // decrypt with openssl_public_encrypt
		    case 'openssl_private_decrypt':
		        return $this->_openssl_private_decrypt($data);
		        break;
            
            // decrypt with openssl_public_decrypt
            case 'openssl_public_decrypt':
                return $this->_openssl_public_decrypt($data);
		        break;
		}
		
		throw new Encryption_Exception('Decryption method not implemented');
	}
	
	private function _openssl_private_decrypt($data)
	{
        $result = openssl_private_decrypt($data, $return, $this->private_key);
        
        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Decryption failed');
	}
	
	private function _openssl_public_decrypt($data)
	{
        $result = openssl_public_decrypt($data, $return, $this->public_key);
        
        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Decryption failed');
	}
}