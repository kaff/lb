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

    public function __construct(Hosts $hosts)
    {
        $this->hosts = $hosts->toArray();
    }

    public function getHost(): Host {
        $nextHost = array_shift($this->hosts);
        array_push($this->hosts);

        return $nextHost;
    }
}
