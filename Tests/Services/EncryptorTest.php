<?php

namespace Ambta\DoctrineEncryptBundle\Tests\Services;

use Ambta\DoctrineEncryptBundle\Services\Encryptor;

class EncryptorTest extends \PHPUnit_Framework_TestCase
{
    const ENCRYPT_CLASS = '\Ambta\DoctrineEncryptBundle\Encryptors\Rijndael256Encryptor';
    const KEY = 'F2DAFE0FCE9F5C4F13F8A400B325A753DC4300FFFF3809BE3B078346C99B7DBE';
    const TEXT = 'testowy tekst';
    const ENCRYPTED_TEXT = 'Co5kxICKqnzIyMsdSk2eQj6pH5GNhI4M29qkYzyUD/E=<ENC>';

    public function testEncrypt()
    {
        $encryptor = new Encryptor(self::ENCRYPT_CLASS, self::KEY);
        $encryptedText = $encryptor->encrypt(self::TEXT);

        $this->assertEquals(self::ENCRYPTED_TEXT, $encryptedText);
    }

    public function testDecrypt()
    {
        $encryptor = new Encryptor(self::ENCRYPT_CLASS, self::KEY);
        $test = $encryptor->decrypt(self::ENCRYPTED_TEXT);

        $this->assertEquals(self::TEXT, $test);
    }
}
