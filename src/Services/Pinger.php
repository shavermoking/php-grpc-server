<?php

namespace App\Services;

use GRPC\Pinger\PingerInterface;
use GRPC\Pinger\PingRequest;
use GRPC\Pinger\PingResponse;
use Spiral\RoadRunner\GRPC;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Pinger implements PingerInterface
{
    public function __construct(private HttpClientInterface $httpClient)
    {

    }

    /**
     * @inheritDoc
     */
    public function ping(GRPC\ContextInterface $ctx, PingRequest $in): PingResponse
    {
        try {
            $statusCode = $this->httpClient->request('GET', $in->getUrl())->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $statusCode = 0;
        }
        return (new PingResponse())->setStatusCode($statusCode);
    }
}