<?php

declare(strict_types=1);

namespace LoadBalancer\BalancingAlgorithm;

use LoadBalancer\BalancingAlgorithm;
use LoadBalancer\Host;
use LoadBalancer\Hosts;

class LoadUnderFactor implements BalancingAlgorithm {

    private float $loadFactor;

    public function __construct(float $loadFactor)
    {
        $this->loadFactor = $loadFactor;
    }

    public function chooseHost(Hosts $hosts): Host {
        $hostBelowFactor = $this->getFirstHostWithLoadUnderFactor($hosts);

        if ($hostBelowFactor instanceof Host) {
            return $hostBelowFactor;
        }

        return $this->getHostWithTheLowestLoad($hosts);
    }

    private function getFirstHostWithLoadUnderFactor(Hosts $hosts): ?Host
    {
        foreach ($hosts->toArray() as $host) {
            if ($host->getLoad() < $this->loadFactor) {
                return $host;
            }
        }

        return null;
    }

    private function getHostWithTheLowestLoad(Hosts $hosts): Host
    {
        $hostsArray = $hosts->toArray();
        usort($hostsArray, function (Host $hostA, Host $hostB) {
            return $hostA->getLoad() <=> $hostB->getLoad();
        });

        return reset($hostsArray);
    }
}
