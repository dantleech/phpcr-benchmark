<?php

namespace PHPCR\Benchmark\Benchmark;

use PHPCR\Benchmark\Test;
use PHPCR\Benchmark\Benchmark;
use PHPCR\Benchmark\RunableInterface;
use PHPCR\Benchmark\Context;

class Repetition extends Benchmark implements RunableInterface
{
    protected $name;
    protected $test;
    protected $repititions;

    public function __construct($name, Test $test, $repititions = 10)
    {
        $this->name = $name;
        $this->test = $test;
        $this->repititions = $repititions;
    }

    public function run(Context $context)
    {
        $this->test->run($context);
    }
}
