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
}