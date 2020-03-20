<?php

declare(strict_types=1);

namespace LoadBalancer;

use Psr\Http\Message\RequestInterface as Request;

class LoadBalancer
{
    private BalancingAlgorithm $balancingAlgorithm;
    private Hosts $hosts;

    public function __construct(Hosts $hosts, BalancingAlgorithm $balancingAlgorithm)
    {
        $this->hosts = $hosts;
        $this->balancingAlgorithm = $balancingAlgorithm;
    }

    public function handleRequest(Request $request): void {
        $host = $this->balancingAlgorithm->chooseHost($this->hosts);
        $host->handleRequest($request);
    }
}
