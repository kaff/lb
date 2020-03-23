<?php

declare(strict_types=1);

namespace integration;

use LoadBalancer\BalancingAlgorithm;
use LoadBalancer\Host;
use LoadBalancer\Hosts;
use LoadBalancer\LoadBalancer;
use Psr\Http\Message\RequestInterface;
use PHPUnit\Framework\TestCase;

class LoadBalancer_LoadUnderFactorTest extends TestCase
{
    const LOAD_FACTOR = 0.75;
    const LOAD_ABOVE_FACTOR = 0.8;
    const LOAD_UNDER_FACTOR = 0.6;

    private Host $host1;
    private Host $host2;
    private Host $host3;
    private RequestInterface $request;

    public function setUp(): void
    {
        $this->host1 = $this->getMockBuilder(Host::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->host2 = $this->getMockBuilder(Host::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->host3 = $this->getMockBuilder(Host::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->request = $this->getMockBuilder(RequestInterface::class)
            ->getMock();
    }

    public function test_that_request_is_handled_by_host_with_load_under_factor()
    {
        $this->host1->method('getLoad')->willReturn(self::LOAD_ABOVE_FACTOR);
        $this->host2->method('getLoad')->willReturn(self::LOAD_FACTOR);
        $this->host3->method('getLoad')->willReturn(self::LOAD_UNDER_FACTOR);
        $this->host3
            ->expects($this->once())
            ->method('handleRequest')
            ->with($this->request);

        $hosts = new Hosts(
            $this->host1,
            $this->host2,
            $this->host3,
        );
        $algorithm = new BalancingAlgorithm\LoadUnderFactor(self::LOAD_FACTOR);
        $loadBalancer = new LoadBalancer($hosts, $algorithm);
        
        $loadBalancer->handleRequest($this->request);
    }
}
