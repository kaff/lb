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
        $hostsArray = $hosts->toArray();

        $hostBelowFactor = $this->getFirstHostWithLoadUnderFactor($hostsArray);

        if ($hostBelowFactor instanceof Host) {
            return $hostBelowFactor;
        }

        return $this->getHostWithTheLowestLoad($hostsArray);
    }

    private function getFirstHostWithLoadUnderFactor(array $hosts): ?Host
    {
        foreach ($hosts as $host) {
            /** @var Host $host  */
            if ($host->getLoad() < $this->loadFactor) {
                return $host;
            }
        }

        return null;
    }

    private function getHostWithTheLowestLoad(array $hosts): Host
    {
        usort($hosts, function (Host $hostA, Host $hostB) {
            return $hostA->getLoad() <=> $hostB->getLoad();
        });

        return reset($hosts);
    }
}
