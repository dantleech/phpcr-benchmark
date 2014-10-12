<?php

namespace PHPCR\Benchmark;

use Jackalope\RepositoryFactoryJackrabbit;
use Doctrine\DBAL\DriverManager;
use Jackalope\RepositoryFactoryDoctrineDBAL;

class RepositoryFactory
{
    public function get($name)
    {
        $map = array(
            'jackrabbit' => 'createJackrabbit',
            'doctrine-dbal-sqlite' => 'createDoctrineDbalSqlite',
            'jackalope-fs' => 'createJackalopeFs',
        );

        if (!isset($map[$name])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown implementation definition "%s", known definitions: "%s"',
                $name, implode('", "', array_keys($map))
            ));
        }

        $repository = $this->{$map[$name]}();

        return $repository;
    }

    private function createJackrabbit()
    {
        $params = array(
            'jackalope.jackrabbit_uri'  => 'http://localhost:8080/server/'
        );
        $factory = new RepositoryFactoryJackrabbit();
        $repository = $factory->getRepository($params);

        return $repository;
    }

    private function createDoctrineDbalSqlite()
    {
        $config = require(__DIR__ . '/../config/implementation/doctrine-dbal-sqlite.php');
        $connection = DriverManager::getConnection($config);

        $factory = new RepositoryFactoryDoctrineDBAL();
        $repository = $factory->getRepository(array(
            'jackalope.doctrine_dbal_connection' => $connection
        ));

        return $repository;
    }
}
