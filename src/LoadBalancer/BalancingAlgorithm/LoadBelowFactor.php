<?php

declare(strict_types=1);

namespace LoadBalancer\BalancingAlgorithm;

use LoadBalancer\{
    BalancingAlgorithm,
    Hosts,
    Host
};

class LoadBelowFactor implements BalancingAlgorithm {

    private Hosts $hosts;

    public function __construct(Hosts $hosts)
    {
        $this->hosts = $hosts;
    }

    public function getHost(): Host {

    }
}
