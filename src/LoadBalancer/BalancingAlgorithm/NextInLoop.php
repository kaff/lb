<?php

declare(strict_types=1);

namespace LoadBalancer\BalancingAlgorithm;

use LoadBalancer\{
    BalancingAlgorithm,
    Hosts,
    Host
};

class NextInLoop implements BalancingAlgorithm {

    /**
     * @var Host[]
     */
    private array $hosts;

    public function addHosts(Hosts $hosts): void
    {
        if (is_null($this->hosts)) {
            throw new \Exception('Hosts can be added only once. Create new object if you need to change hosts list.');
        }

        $this->hosts = $hosts->toArray();

    }

    public function getHost(): Host {
        $nextHost = array_shift($this->hosts);
        array_push($this->hosts);

        return $nextHost;
    }
}
