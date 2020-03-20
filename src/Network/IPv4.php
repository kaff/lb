<?php

declare(strict_types=1);

namespace Network;

class IPv4
{
    private string $IPv4address;

    public function __construct(string $IPv4address)
    {
        $this->guardIPv4Address($IPv4address);
        $this->IPv4address = $IPv4address;
    }

    private function guardIPv4Address(string $IPv4address): void
    {
        if (!filter_var($IPv4address, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException("${IPv4address} is invalid IP address");
        }
    }
}
