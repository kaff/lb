<?php

declare(strict_types=1);

namespace LoadBalancer;

interface BalancingAlgorithm {
    public function chooseHost(Hosts $hosts): Host;
}
