<?php

declare(strict_types=1);

namespace LoadBalancer\BalancingAlgorithm;

use LoadBalancer\BalancingAlgorithm;
use LoadBalancer\Host;
use LoadBalancer\Hosts;

class NextInLoop implements BalancingAlgorithm {

    public function chooseHost(Hosts $hosts): Host {
        $hostsArray = $hosts->toArray();

        $host = $this->getFirstUnusedHost($hostsArray);
        if ($host instanceof Host) {
            return $host;
        }

        $sortedArray = $this->sortByMicrotimeOfSendingLastRequest($hostsArray);

        return $sortedArray[0];
    }

    private function sortByMicrotimeOfSendingLastRequest(array $hosts): array
    {
        usort($hosts, function (Host $hostA, Host $hostB) {
            return $hostA->getMicrotimeOfHandlingLastRequest() <=> $hostB->getMicrotimeOfHandlingLastRequest();
        });

        return $hosts;
    }

    private function getFirstUnusedHost(array $hosts): ?Host
    {
        foreach ($hosts as $host) {
            /** @var Host $host */
            if (is_null($host->getMicrotimeOfHandlingLastRequest())) {
                return $host;
            }
        }

        return null;
    }
}
