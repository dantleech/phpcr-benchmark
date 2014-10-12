<?php

namespace PHPCR\Benchmark;

use PHPCR\Benchmark\Context;

interface RunableInterface
{
    public function run(Context $context);
}
