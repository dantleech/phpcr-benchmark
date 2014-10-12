<?php

namespace PHPCR\Benchmark\Test;

use PHPCR\Benchmark\Context;
use PHPCR\Benchmark\Test;

class ClosureTest extends Test
{
    protected $closure;

    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    public function run(Context $context)
    {
        $closure = $this->closure;
        $closure($context);
    }
}
