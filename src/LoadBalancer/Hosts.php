<?php

declare(strict_types=1);

namespace LoadBalancer;

class Hosts
{
    private array $hosts;

    public function __construct(Host ...$hosts)
    {
        if (empty($hosts)) {
            throw new \InvalidArgumentException('Hosts list cannot be empty.');
        }

        $this->hosts = $hosts;
    }

    /**
     * @return Host[]
     */
    public function toArray(): array
    {
        return array_values($this->hosts);
    }
}
