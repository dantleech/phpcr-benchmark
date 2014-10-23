<?php

namespace PHPCR\Benchmark;

use PhpAmqpLib\Connection\AMQPConnection;
use Symfony\Component\Process\Process;
use Domnikl\Statsd\Connection\Socket;
use Domnikl\Statsd\Client;

class Consumer
{
    private $host;
    private $port;
    private $user;
    private $pass;

    private $statsdHost;
    private $statsdPort;

    public function __construct($host, $port, $user, $pass, $statsdHost, $statsdPort)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->statsdHost = $statsdHost;
        $this->statsdPort = $statsdPort;
    }

    public function consume()
    {
        $connection = new AMQPConnection($this->host, $this->port, $this->user, $this->pass);
        $channel = $connection->channel();

        $channel->queue_declare('phpcr_benchmark', false, false, false, false);
        $channel->basic_consume('phpcr_benchmark', '', false, true, false, false, array($this, 'process'));

        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    public function process($msg)
    {
        $msg = json_decode($msg->body);
        $implementation = $msg->implementation;
        echo "Running benchmark for: ".$implementation . "\n";
        putenv('PHPCR_IMPLEMENTATION='. $implementation);

        $process = new Process('php bin/phpcrbench -p suites/ -b vendor/autoload.php -f JsonFormatter');
        $process->run();

        $out = $process->getOutput();
        echo $out;
        $res = json_decode($out, true);
        if (false === $res) {
            throw new \Exception($out);
        }

        $connection = new Socket($this->statsdHost, $this->statsdPort);
        $statsd = new Client($connection, 'phpcr');

        foreach ($res as $test) {
            foreach ($test as $testName => $stats) {
                foreach ($stats as $key => $value) {
                    if (null === $value) {
                        continue;
                    }
                    if (!is_numeric($value)) {
                        continue;
                    }
                    $value = $value * 1000;
                    $statsd->gauge($index = sprintf(
                        '%s.%s.%s',
                        $implementation,
                        $testName,
                        $key
                    ), $value);
                    var_dump($index . '=' . $value);
                }
            }
        }
    }
}
