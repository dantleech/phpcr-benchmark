<?php

namespace PHPCR\Benchmark\Suites\Reading;

use PHPCR\Benchmark\AthleticEvent;

class TraversalEvent extends AthleticEvent
{
    public function setUp()
    {
        parent::setUp();

        $builder = $this->createNodeBuilder('cmf')
            ->node('article-[1-10]')
                ->property('title', 'Foobar')
                ->node('animals')
                    ->node('animal[1-100]')
                         ->property('name', 'Animal X')
                    ->end()
                ->end()
                ->node('category-[1-10]');

        $this->getConverter()->convert($builder);
        $this->session->save();
    }

    /**
     * @iterations 10
     */
    public function benchFullTree10()
    {
        $rootNode = $this->session->getRootNode();
        $this->iterateNode($rootNode);
    }

    /**
     * @iterations 100
     */
    public function benchFullTree100()
    {
        $rootNode = $this->session->getRootNode();
        $this->iterateNode($rootNode);
    }

    /**
     * @iterations 1000
     */
    public function benchFullTree1000()
    {
        $rootNode = $this->session->getRootNode();
        $this->iterateNode($rootNode);
    }


    private function iterateNode($node)
    {
        foreach ($node->getProperties() as $property) {
        }

        foreach ($node->getNodes() as $child) {
            $this->iterateNode($child);
        }
    }
}
