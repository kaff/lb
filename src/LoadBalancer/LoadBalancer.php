<?php

declare(strict_types=1);

namespace LoadBalancer;

use Psr\Http\Message\RequestInterface as Request;

class LoadBalancer
{
    private BalancingAlgorithm $balancingAlgorithm;

    public function __construct(Hosts $hosts, BalancingAlgorithm $balancingAlgorithm)
    {
        $this->balancingAlgorithm = $balancingAlgorithm;
        $this->balancingAlgorithm->addHosts($hosts);
    }

    public function handleRequest(Request $request): void {
        $host = $this->balancingAlgorithm->getHost();
        $host->handleRequest($request);
    }
}
