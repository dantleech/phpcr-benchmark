<?php

namespace PHPCR\Benchmark\Console;

use Symfony\Component\Console\Application as BaseApplication;
use PHPCR\Benchmark\Console\RunCommand;
use PHPCR\Benchmark\RepositoryFactory;

class Application extends BaseApplication
{
    const APP_NAME = 'phpcr-benchmark';
    const APP_VERSION = '1.0.0';

    public function __construct(array $suites)
    {
        parent::__construct(self::APP_NAME, self::APP_VERSION);

        $repositoryFactory = new RepositoryFactory();
        $this->add(new RunCommand($repositoryFactory, $suites));
    }
}
