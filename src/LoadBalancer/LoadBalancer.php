<?php

declare(strict_types=1);

namespace LoadBalancer;

use Psr\Http\Message\RequestInterface as Request;

class LoadBalancer
{
    private BalancingAlgorithm $balancingAlgorithm;

    public function __construct(Hosts $hosts, string $balancingAlgorithm)
    {
        if (class_implements($balancingAlgorithm) === BalancingAlgorithm::class) {
            throw new \Exception('Balancing Algorithm must implement BalancingAlgorithm interface');
        }

        $this->balancingAlgorithm = new $balancingAlgorithm($hosts);
    }

    public function handleRequest(Request $request): void {
        $host = $this->balancingAlgorithm->getHost();
        $host->handleRequest($request);
    }
}
