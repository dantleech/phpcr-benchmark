<?php

namespace PHPCR\Benchmark;

class Runner
{
    private $suites;

    public function addSuite(Suite $suite)
    {
        $this->suites = $suite;
    }

    public function run(Context $context)
    {
        foreach ($this->suites as $suite) {
            $suite->run($context);
        }
    }
}
