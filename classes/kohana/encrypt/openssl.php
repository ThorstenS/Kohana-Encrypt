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
	public static function instance($driver = 'openssl', $name = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Encrypt::$default_name;
		}

		if ( ! isset(Encrypt::$instances['openssl'][$name]))
		{
			// Load the configuration data
			$config = Kohana::$config->load('encrypt')->openssl[$name];

			if ( empty($config['encrypt_method']) )
			{
				// No default encryption key is provided!
				throw new Encrypt_Exception('No encryption method is defined in the encryption configuration group: :group',
					array(':group' => $name));
			}

			// Create a new instance
			Encrypt::$instances['openssl'][$name] = new Encrypt_Openssl($config);
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
	 * @param   string  clear text password for private key if needed
	 * @return  string
	 */
	public function encode($data, $password = NULL)
	{
		switch ($this->encrypt_method) 
		{
            // Encrypt with openssl_public_encrypt
		    case 'openssl_public_encrypt':
		        $data = $this->_openssl_public_encrypt($data);
		        break;
		      
            // Encrypt with openssl_private_encrypt
		    case 'openssl_private_encrypt':
		        $data = $this->_openssl_private_encrypt($data, $password);
		        break;
            
            case 'openssl_encrypt':
                $data = $this->_openssl_encrypt($data);
                break;
                
            // There is no default method, throw exception
            default:
                throw new Encrypt_Exception('Encryption method not implemented');
                break;
		}
		
		return base64_encode($data);
	}
    
    protected function _openssl_public_encrypt($data)
    {
        $result = openssl_public_encrypt($data, $return, openssl_pkey_get_public($this->public_key));
        
        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Encryption failed');
    }
    
    protected function _openssl_private_encrypt($data, $password = NULL)
    {
        $result = openssl_private_encrypt($data, $return, openssl_pkey_get_private($this->private_key, $password));

        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Encryption failed');
    }
    
    protected function _openssl_encrypt($data)
    {
        $result = openssl_encrypt($data, $this->method, $this->password, true, $this->iv);
        
        if ( $result )
        {
            return $result;
        }
        
        throw new Encrypt_Exception('Encryption failed');
    }
    
	/**
	 * Decrypts an encoded string back to its original value.
	 *
	 *     $data = $encrypt->decode($data);
	 *
	 * @param   string  encoded string to be decrypted
	 * @param   string  clear text password for private key if needed
	 * @return  FALSE   if decryption fails
	 * @return  string
	 */
	public function decode($data, $password = NULL)
	{
        $data = base64_decode($data, true);
        
		switch ($this->encrypt_method) 
		{
            // decrypt with openssl_private_decrypt
		    case 'openssl_public_encrypt':
		        return $this->_openssl_private_decrypt($data, $password);
		        break;
            
            // decrypt with openssl_public_decrypt
            case 'openssl_private_encrypt':
                return $this->_openssl_public_decrypt($data);
		        break;
		  
            case 'openssl_encrypt':
                return $this->_openssl_decrypt($data);
                break;
		}
		
		throw new Encrypt_Exception('Decryption method not implemented');
	}
	
	protected function _openssl_private_decrypt($data, $password = NULL)
	{
        $result = openssl_private_decrypt($data, $return, openssl_pkey_get_private($this->private_key, $password));

        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Decryption failed');
	}
	
	protected function _openssl_public_decrypt($data, $password = NULL)
	{
        $result = openssl_public_decrypt($data, $return, openssl_pkey_get_public($this->public_key));
        
        if ( $result )
        {
            return $return;
        }
        
        throw new Encrypt_Exception('Decryption failed');
	}
	
	protected function _openssl_decrypt($data)
    {
        $result = openssl_decrypt($data, $this->method, $this->password, true, $this->iv);

        if ( $result )
        {
            return $result;
        }
        
        throw new Encrypt_Exception('Decryption failed');
    }
    
    /*
	 * Return the implemented methods (ciphers)
	 */
    public function get_cipher_methods()
    {
        return openssl_get_cipher_methods();
    }
}