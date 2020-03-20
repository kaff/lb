<?php

declare(strict_types=1);

namespace LoadBalancer;

use Network\IPv4;
use Psr\Http\Message\RequestInterface as Request;

class Host {

    private IPv4 $IPv4;
    private ?float $microtimeOfHandlingLastRequest = null;

    public function __construct(IPv4 $IPv4)
    {
        $this->IPv4 = $IPv4;
    }

    public function getLoad(): float {
        // not implemented yet
    }

    public function handleRequest(Request $request): void {
        // not implemented yet
        // handle request
        $this->setMicrotimeOfHandlingLastRequest();
    }

    public function getMicrotimeOfHandlingLastRequest(): ?float {
        return $this->microtimeOfHandlingLastRequest;
    }

    private function setMicrotimeOfHandlingLastRequest(): void
    {
        $this->microtimeOfHandlingLastRequest = microtime(true);
    }
}

