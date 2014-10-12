<?php

namespace PHPCR\Benchmark;

use PHPCR\RepositoryInterface;
use PHPCR\SessionInterface;

class Context
{
    protected $session;

    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getSession()
    {
        return $this->session;
    }
}
