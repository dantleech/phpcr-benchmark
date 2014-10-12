<?php

namespace PHPCR\Benchmark\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PHPCR\Benchmark\Context;
use Symfony\Component\Console\Input\InputArgument;
use PHPCR\Benchmark\RepositoryFactory;
use PHPCR\SimpleCredentials;

class RunCommand extends Command
{
    private $suites;
    private $repositoryFactory;

    public function __construct(RepositoryFactory $repositoryFactory, array $suites)
    {
        parent::__construct();
        $this->suites = $suites;
        $this->repositoryFactory = $repositoryFactory;
    }

    public function configure()
    {
        $this->setName('phpcr:benchmark:run');
        $this->addArgument('implementation', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $implementation = $input->getArgument('implementation');
        $repository = $this->repositoryFactory->get($implementation);


        $credentials = new SimpleCredentials(
            'admin', 'admin'
        );
        $session = $repository->login($credentials);

        $context = new Context();
        $context->setSession($session);

        foreach ($this->suites as $suite) {
            $suite->run($context);
        }
    }
}
