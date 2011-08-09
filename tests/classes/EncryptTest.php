<?php defined('SYSPATH') or die('No direct access allowed!'); 
 
class EncryptTest extends Kohana_UnitTest_TestCase 
{
    function providerMcrypt()
	{
        $encrypt = Encrypt::instance('mcrypt', 'unittest');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerMcrypt
	 */
	function testMcrypt($original, $encrypted)
	{
        $encrypt = Encrypt::instance('mcrypt', 'unittest');
        
		$this->assertSame(
			$encrypt->decode($encrypted),
			$original
		);
	}
	
	function providerOpenSSLencryptOpenSSLdecrypt()
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_encrypt_decrypt');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}

	/**
	 * @dataProvider providerOpenSSLencryptOpenSSLdecrypt
	 */
	function testOpenSSLencode($original, $encrypted)
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_encrypt_decrypt');
        
		$this->assertSame(
			$encrypt->encode($original),
			$encrypted
		);
	}
	
	/**
	 * @dataProvider providerOpenSSLencryptOpenSSLdecrypt
	 */
	function testOpenSSLdecode($original, $encrypted)
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_encrypt_decrypt');
        
		$this->assertSame(
			$encrypt->decode($encrypted),
			$original
		);
	}
	
	
	function providerPublicEncryptPrivateDecrypt()
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_public_encrypt_private_decrypt');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerPublicEncryptPrivateDecrypt
	 */
	function testOpenSSLPublicEncodePrivateDecode($original, $encrypted)
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_public_encrypt_private_decrypt');
        
		$this->assertSame(
			$encrypt->decode($encrypted),
			$original
		);
	}
	
	function providerPrivateEncryptPublicDecrypt()
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_private_encrypt_public_decrypt');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerPrivateEncryptPublicDecrypt
	 */
	function testOpenSSLPrivateEncodePublicDecode($original, $encrypted)
	{
        $encrypt = Encrypt::instance('openssl', 'unittest_private_encrypt_public_decrypt');
        
		$this->assertSame(
			$encrypt->decode($encrypted),
			$original
		);
	}
	
	function providerCryptStdDes()
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_STD_DES');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerCryptStdDes
	 */
	function testCryptStdDes($original, $encrypted)
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_STD_DES');
        
		$this->assertTrue(
			$encrypt->check($original, $encrypted)
		);
	}
	
	function providerCryptExtDes()
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_EXT_DES');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerCryptExtDes
	 */
	function testCryptExtDes($original, $encrypted)
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_EXT_DES');
        
		$this->assertTrue(
			$encrypt->check($original, $encrypted)
		);
	}
	
	function providerCryptMD5()
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_MD5');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerCryptMD5
	 */
	function testCryptMD5($original, $encrypted)
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_MD5');
        
		$this->assertTrue(
			$encrypt->check($original, $encrypted)
		);
	}
	
	function providerCryptBlowfish()
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_BLOWFISH');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerCryptBlowfish
	 */
	function testCryptBlowfish($original, $encrypted)
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_BLOWFISH');
        
		$this->assertTrue(
			$encrypt->check($original, $encrypted)
		);
	}
	
	function providerCryptSha256()
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_SHA256');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerCryptSha256
	 */
	function testCryptSha256($original, $encrypted)
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_SHA256');
        
		$this->assertTrue(
			$encrypt->check($original, $encrypted)
		);
	}
	
	function providerCryptSha512()
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_SHA512');
        
		return array(
			array('One set of testcase data', $encrypt->encode('One set of testcase data')),
			array('This is a different one', $encrypt->encode('This is a different one')),
		);
	}
	
	/**
	 * @dataProvider providerCryptSha256
	 */
	function testCryptSha512($original, $encrypted)
	{
        $encrypt = Encrypt::instance('crypt', 'unittest_CRYPT_CRYPT_SHA512');
        
		$this->assertTrue(
			$encrypt->check($original, $encrypted)
		);
	}
}