<?php

declare(strict_types=1);

namespace LoadBalancer;

interface BalancingAlgorithm {
    public function getHost(): Host;
}
