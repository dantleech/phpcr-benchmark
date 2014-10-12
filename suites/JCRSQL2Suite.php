<?php

namespace PHPCR\Benchmark\Suite;

use PHPCR\Benchmark\Suite;
use PHPCR\Benchmark\Benchmark\Repetition;
use PHPCR\Benchmark\Test\ClosureTest;
use PHPCR\Benchmark\Context;
use PHPCR\ImportUUIDBehaviorInterface;

class JCRSQL2Suite extends Suite
{
    public function getName()
    {
        return 'jcrsql2';
    }

    public function loadFixtures(Context $context)
    {
        $session = $context->getSession();
        $rootNode = $session->getRootNode();
        if ($rootNode->hasNode('benchmark')) {
            $rootNode->remove('benchmark');
            $session->save();
        }

        $rootNode->addNode('benchmark');
        $session->importXml('/benchmark', __DIR__ . '/fixtures/wikipedia.xml', ImportUUIDBehaviorInterface::IMPORT_UUID_CREATE_NEW);

    }

    public function getBenchmarks()
    {
        return array(
            new Repetition(
                'select',
                new ClosureTest(function (Context $context) {
                    $queryManager = $context->getSession()->getWorkspace()->getQueryManager();
                    $queryManager->createQuery('SELECT * FROM [nt:unstructured]');
                }),
                50
            )
        );
    }
}
