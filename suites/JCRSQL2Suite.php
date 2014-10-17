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

    public function setUp(Context $context)
    {
    }

    /**
     * @description JCR SQL2 Select from 10, 100, 1,000, 10,000 nodes
     */
    public function benchmarkSelect()
    {
        return new Sequence(array(

            new Task('Loading data', function (Context $c) {

                $c->getGenerator()
                    ->createBuilder()
                        ->node('test-node-[1-:max]', 'nt:unstructured')
                            ->property('title', 'This is a node')
                        ->end()
                    ->end()
                    ->purge()
                    ->persist(array('max' => $this->getParent(2)->getIndex()));

            }),

            new Scaling(

                array(10, 100, 100, 1000),

                new Repetition(

                    50,

                    new ClosureTest(function (Context $context) {
                        $this->getParent()->getIndex(); // 1 - 50
                        $this->getParent()->getParent()->getIndex(); // 10, 100, 1000

                        $queryManager = $context->getSession()->getWorkspace()->getQueryManager();
                        $queryManager->createQuery('SELECT * FROM [nt:unstructured]');
                    })
                )
            ))
        );
    }

    /**
     * @description Creating nodes
     */
    public function benchmarkInsert()
    {
        return new Scaling(

            array(10, 100, 100, 1000),

            new Sequence(array(

                new Repetition(

                    10,

                    new ClosureTest(function (Context $context) {
                        $c->getGenerator()->createBuilder()
                            ->node('test-[1-:max]')
                        ->end()
                        ->purge()->persist(array('max' => $this->getParent(2)->getIndex()));
                    })

                )
            ))
        );
    }
}
