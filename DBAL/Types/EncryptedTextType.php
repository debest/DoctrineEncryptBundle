<?php

namespace Ambta\DoctrineEncryptBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ambta\DoctrineEncryptBundle\Services\Encryptor;
use Doctrine\DBAL\Types\TextType;

class EncryptedTextType extends TextType
{
    const NAME = 'encrypted_text';

    private $encryptor;

    public function setEncryptor(Encryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToDatabaseValue($value, $platform);
        return $this->encryptor->encrypt($value);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        return $this->encryptor->decrypt($value);
    }
}
