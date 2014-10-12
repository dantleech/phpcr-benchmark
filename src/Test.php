<?php

namespace PHPCR\Benchmark;

use PHPCR\Benchmark\Context;
use PHPCR\Benchmark\RunableInterface;

abstract class Test implements RunableInterface
{
    abstract public function run(Context $context);
}
