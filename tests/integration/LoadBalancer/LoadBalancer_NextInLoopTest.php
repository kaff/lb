<?php

declare(strict_types=1);

namespace integration;

use LoadBalancer\BalancingAlgorithm;
use LoadBalancer\Host;
use LoadBalancer\Hosts;
use LoadBalancer\LoadBalancer;
use Network\IPv4;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class LoadBalancer_NextInLoopTest extends TestCase
{
    private RequestInterface $request;

    public function setUp(): void
    {
        $this->request = $this->getMockBuilder(RequestInterface::class)
            ->getMock();
    }

    public function test_that_request_is_handled_by_next_host_in_loop_sequentially()
    {
        $host1 = new Host(new IPv4('192.168.1.1'));
        $host2 = new Host(new IPv4('192.168.1.2'));
        $host3 = new Host(new IPv4('192.168.1.3'));

        $hosts = new Hosts(
            $host1,
            $host2,
            $host3
        );
        $algorithm = new BalancingAlgorithm\NextInLoop();
        $loadBalancer = new LoadBalancer($hosts, $algorithm);

        $loadBalancer->handleRequest($this->request);
        $loadBalancer->handleRequest($this->request);
        $loadBalancer->handleRequest($this->request);

        $hostsInExpectedOrder = [$host1, $host2, $host3];
        $this->assertHostsHaveBeenUsedInExpectedOrder($hostsInExpectedOrder, $hosts);
    }
    
    private function assertHostsHaveBeenUsedInExpectedOrder(array $hostsInExpectedOrder, Hosts $hosts): void
    {
        $hostsArray = $hosts->toArray();
        $hostsInOrderOfUsage = $this->sortHostsByMicrotimeOfHandlingLastRequest($hostsArray);

        $this->assertEquals(
            $hostsInExpectedOrder,
            $hostsInOrderOfUsage,
            "Host order usage is different than expected."
        );
    }
    
    private function sortHostsByMicrotimeOfHandlingLastRequest(array $hostsArray): array
    {
        usort($hostsArray, function (Host $hostA, Host $hostB) {
            return $hostA->getMicrotimeOfHandlingLastRequest() <=> $hostB->getMicrotimeOfHandlingLastRequest();
        });

        return $hostsArray;
    }
}
