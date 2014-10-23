PHPCR Benchmarking Suite
========================

This benchmarking suite uses a fork of the
[Athletic](https://github.com/polyfractal/athletic) benchmarking library.

It also has scripts to output data generated from the benchmarks into statsd
so that the data can be visualized in Graphite.

Install the Docker Containers
-----------------------------

````
# Rabbit MQ
$ sudo docker pull dockerfile/rabbitmq
$ sudo docker run -d -p 5672:5672 -p 15672:15672 dockerfile/rabbitmq

# Graphite + Statsd
$ sudo docker pull hopsoft/graphite-statsdsudo docker run -d \
  --name graphite \
  -p 8082:80 \
  -p 2003:2003 \
  -p 8125:8125/udp \
  hopsoft/graphite-statsd
````

Install
-------

````
$ composer install
````

Bootstrap doctrine-dbal:

```
$ ./bin/doctrine-dbal-sqlite/init.sh
```

If you want to run Jackrabbit benchmarks, install the jackrabbit standalong
server and run it.

Create some benchmarks
----------------------

Run the consumer:

````
$ php bin/consumer.php
````

Queue a benchmark or two:

````
$ php bin/send.php doctrine-dbal-sqlite
$ php bin/send.php jackrabbit
````

Look at graphs
--------------

http://localhost:8082/
