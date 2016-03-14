<?php

namespace Ambta\DoctrineEncryptBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Ambta\DoctrineEncryptBundle\DependencyInjection\DoctrineEncryptExtension;
use Ambta\DoctrineEncryptBundle\DependencyInjection\Compiler\RegisterServiceCompilerPass;
use Ambta\DoctrineEncryptBundle\DBAL\Types\EncryptedType;
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
        if (Type::hasType(EncryptedType::ENCRYPTED) === false) {
            Type::addType(EncryptedType::ENCRYPTED, 'Ambta\DoctrineEncryptBundle\DBAL\Types\EncryptedType');
        }
        
        $encryptor = $this->container->get('ambta_doctrine_encrypt.encryptor');
        $encryptedType = Type::getType(EncryptedType::ENCRYPTED);
        $encryptedType->setEncryptor($encryptor);
    }
}
