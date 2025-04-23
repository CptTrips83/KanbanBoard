<?php

namespace App\Tools;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabasePrimer
{
    /**
     * Primes the database schema for the test environment.
     *
     * @param KernelInterface $kernel The kernel object.
     *
     * @return void
     * @throws LogicException If the method is not executed in the test environment.
     *
     */
    public static function prime(KernelInterface $kernel) : void
    {
        // Make sure we are in the test environment
        if ('test' !== $kernel->getEnvironment()) {
            throw new LogicException('Primer must be executed in the test environment');
        }

        // Get the entity manager from the service container
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        // Run the schema update tool using our entity metadata
        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadatas);

        // If you are using the Doctrine Fixtures Bundle you could load these here
    }
}