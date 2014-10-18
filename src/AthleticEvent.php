<?php

namespace PHPCR\Benchmark;

use DTL\PHPCR\Generator\NodeBuilder;
use DTL\PHPCR\Generator\NodeConverter;
use Athletic\AthleticEvent as BaseAthleticEvent;
use PHPCR\SimpleCredentials;
use PHPCR\Util\NodeHelper;

abstract class AthleticEvent extends BaseAthleticEvent
{
    protected $repository;
    protected $session;

    public function classSetUp()
    {
    }

    public function setUp()
    {
        $factory = new RepositoryFactory();
        $this->repository = $factory->get(IMPLEMENTATION);
        NodeHelper::purgeWorkspace($this->getSession());
    }

    public function getSession()
    {
        if ($this->session) {
            return $this->session;
        }

        $credentials = new SimpleCredentials('admin', 'admin');
        $this->session = $this->repository->login($credentials);
        return $this->session;
    }

    public function createNodeBuilder($name, $nodeType = 'nt:unstructured')
    {
        return new NodeBuilder($name, $nodeType);
    }

    public function getConverter()
    {
        return new NodeConverter($this->getSession());
    }
}
