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

    public function addHosts(Hosts $hosts): void
    {
        if (is_null($this->hosts)) {
            throw new \Exception('Hosts can be added only once. Create new object if you need to change hosts list.');
        }

        $this->hosts = $hosts;

    }

    public function getHost(): Host {

    }
}
