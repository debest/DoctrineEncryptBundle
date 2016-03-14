<?php

/*
 * Copyright 2015 Soeezy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ambta\DoctrineEncryptBundle\Services;

class Encryptor
{
    /** @var \Ambta\DoctrineEncryptBundle\Encryptors\EncryptorInterface */
    protected $encryptor;

    public function __construct($encryptName, $key)
    {
        $reflectionClass = new \ReflectionClass($encryptName);
        $this->encryptor = $reflectionClass->newInstanceArgs(array(
            $key,
        ));
    }

    public function getEncryptor()
    {
        return $this->encryptor;
    }

    public function decrypt($string)
    {
        if ($string !== null && substr($string, -5) === '<ENC>') {
            return $this->encryptor->decrypt(substr($string, 0, -5));
        }

        return $string;
    }

    public function encrypt($string)
    {
        if ($string !== null && substr($string, -5) !== '<ENC>') {
            return $this->encryptor->encrypt($string);
        }

        return $string;
    }
}
