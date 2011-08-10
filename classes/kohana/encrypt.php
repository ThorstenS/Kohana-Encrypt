<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This is a hack of the original kohana encrypt class
 * to support mycrypt and openssl
 *
 * @package    Encrypt
 */
abstract class Kohana_Encrypt {
    
	/**
	 * @var  string  default instance name
	 */
	public static $default_name = 'default';

	/**
	 * @var  array  Encrypt class instances
	 */
	public static $instances = array();

	/**
	 * @var  string  OS-dependent RAND type to use
	 */
	protected static $_rand;

	/**
	 * Returns a singleton instance of Encrypt. An encryption key must be
	 * provided in your "encrypt" configuration file.
	 *
	 *     $encrypt = Encrypt::instance();
	 *
	 * @param   string  configuration group name
	 * @return  Encrypt
	 */
	public static function instance($driver = 'mcrypt', $name = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Encrypt::$default_name;
		}
        
        if ( ! isset(Encrypt::$instances[$driver][$name]))
		{
			$class = 'Encrypt_' . ucfirst($driver);

			Encrypt::$instances[$driver][$name] = $class::instance($driver, $name);
		}

		return Encrypt::$instances[$driver][$name];
	}
    
} // End Encrypt
