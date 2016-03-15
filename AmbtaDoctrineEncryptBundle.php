<?php

namespace Ambta\DoctrineEncryptBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Ambta\DoctrineEncryptBundle\DependencyInjection\DoctrineEncryptExtension;
use Ambta\DoctrineEncryptBundle\DependencyInjection\Compiler\RegisterServiceCompilerPass;
use Ambta\DoctrineEncryptBundle\DBAL\Types\EncryptedStringType;
use Ambta\DoctrineEncryptBundle\DBAL\Types\EncryptedTextType;
use Doctrine\DBAL\Types\Type;

class AmbtaDoctrineEncryptBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterServiceCompilerPass(), PassConfig::TYPE_AFTER_REMOVING);
    }

    public function getContainerExtension()
    {
        return new DoctrineEncryptExtension();
    }

    public function boot()
    {
        if (Type::hasType(EncryptedStringType::NAME) === false) {
            Type::addType(EncryptedStringType::NAME, 'Ambta\DoctrineEncryptBundle\DBAL\Types\EncryptedStringType');
        }

        if (Type::hasType(EncryptedTextType::NAME) === false) {
            Type::addType(EncryptedTextType::NAME, 'Ambta\DoctrineEncryptBundle\DBAL\Types\EncryptedTextType');
        }
        
        $encryptor = $this->container->get('ambta_doctrine_encrypt.encryptor');

        $ecryptedString = Type::getType(EncryptedStringType::NAME);
        $ecryptedString->setEncryptor($encryptor);

        $ecryptedText = Type::getType(EncryptedTextType::NAME);
        $ecryptedText->setEncryptor($encryptor);
    }
}
