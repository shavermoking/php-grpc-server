<?php

use App\Services\Pinger;
use GRPC\Pinger\PingerInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';

$server = new Server();

$server->registerService(PingerInterface::class, new Pinger(Symfony\Component\HttpClient\HttpClient::create()));

$server->serve(Worker::create());