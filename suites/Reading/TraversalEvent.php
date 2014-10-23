<?php

namespace PHPCR\Benchmark\Suites\Reading;

use PHPCR\Benchmark\AthleticEvent;
use PHPCR\Util\NodeHelper;

class TraversalEvent extends AthleticEvent
{
    public function provideFullTreeTraversal()
    {
       return array(
            array(10),
            array(1),
        //    array(100),
        );
    }

    public function generateNodes($nbNodes)
    {
        NodeHelper::purgeWorkspace($this->getSession());
        $this->session->save();

        $builder = $this->createNodeBuilder('cmf');
        $builder
            ->node('article-[1-100]')
                ->property('title', 'Foobar')
                ->node('animals')
                    ->node('animal-[1-100]')
                         ->property('name', 'Animal X')
                        ->node('sheep')
                        ->node('cow')
                        ->node('pig')
                    ->end()
                ->end()
                ->node('pets')
                    ->node('cat')
                    ->node('dog')
                    ->node('rabbit')
                ->end();

        $converter = $this->getConverter();
        $converter->setLimit($nbNodes);
        $converter->convert($builder);
        $this->session->save();
    }

    /**
     * @beforeMethod generateNodes
     * @dataProvider provideFullTreeTraversal
     * @iterations 1
     * @iterations 2
     */
    public function performFullTreeTraversal($nbNodes)
    {
        $rootNode = $this->getSession()->getRootNode();
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

    /**
     * @beforeMethod generateNodes
     * @dataProvider provideFullTreeTraversal
     * @iterations 1
     * @iterations 10
     */
    public function performSelectAllFromNtUnstructured($nbNodes)
    {
        $qm = $this->getSession()->getWorkspace()->getQueryManager();
        $sql2 = 'SELECT * FROM [nt:unstructured]';
        $query = $qm->createQuery($sql2, \PHPCR\Query\QueryInterface::JCR_SQL2);
        $query->execute();
    }
}
