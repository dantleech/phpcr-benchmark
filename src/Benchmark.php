<?php

namespace PHPCR\Benchmark;

use PHPCR\Benchmark\RunableInterface;

abstract class Benchmark implements RunableInterface
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    abstract public function run(Context $context);
}
