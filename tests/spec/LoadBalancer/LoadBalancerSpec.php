<?php

namespace spec\LoadBalancer;

use LoadBalancer\BalancingAlgorithm;
use LoadBalancer\Host;
use LoadBalancer\Hosts;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class LoadBalancerSpec extends ObjectBehavior
{
    function let(Hosts $hosts, BalancingAlgorithm $balancingAlgorithm)
    {
        $this->beConstructedWith($hosts, $balancingAlgorithm);
    }
    
    function it_handle_request(
        Host $host,
        Hosts $hosts, 
        BalancingAlgorithm $balancingAlgorithm,
        RequestInterface $request
    ) {
        $balancingAlgorithm->chooseHost($hosts)->willReturn($host);
        
        $this->handleRequest($request);

        $host->handleRequest($request)->shouldHaveBeenCalled();
    }
}
