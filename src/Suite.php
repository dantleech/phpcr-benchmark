<?php

namespace PHPCR\Benchmark;

use PHPCR\Benchmark\RunableInterface;

abstract class Suite implements RunableInterface
{
    private $benchmarks;

    abstract public function getName();

    public function run(Context $context)
    {
        foreach ($this->getBenchmarks() as $benchmark) {
            $this->loadFixtures($context);
        }
    }
}
