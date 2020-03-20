<?php

namespace spec\LoadBalancer\BalancingAlgorithm;

use LoadBalancer\Host;
use LoadBalancer\Hosts;
use PhpSpec\ObjectBehavior;

class LoadUnderFactorSpec extends ObjectBehavior
{
    const FACTOR = 0.75;
    const FIRST_LOAD_UNDER_FACTOR = 0.6;
    const SECOND_LOAD_UNDER_FACTOR = 0.6;
    const LOAD_ABOVE_FACTOR = 0.81;
    const HIGHEST_LOAD_ABOVE_FACTOR = 0.92;
    const LOWEST_LOAD_ABOVE_FACTOR = 0.79;

    function let()
    {
        $this->beConstructedWith(self::FACTOR);
    }

    function it_returns_first_host_with_load_under_given_factor(
        Host $host1,
        Host $host2,
        Host $host3
    ) {
        $host1->getLoad()->willReturn(self::LOAD_ABOVE_FACTOR);
        $host1->getLoad()->willReturn(self::FIRST_LOAD_UNDER_FACTOR);
        $host1->getLoad()->willReturn(self::SECOND_LOAD_UNDER_FACTOR);

        $hosts = new Hosts(
            $host1->getWrappedObject(),
            $host2->getWrappedObject(),
            $host3->getWrappedObject()
        );

        $host = $this->chooseHost($hosts);
        $host->getLoad()->shouldBe(self::FIRST_LOAD_UNDER_FACTOR);
    }

    function it_returns_host_with_the_lowest_load_when_all_hosts_are_above_given_factor(
        Host $host1,
        Host $host2,
        Host $host3
    ) {
        $host1->getLoad()->willReturn(self::LOAD_ABOVE_FACTOR);
        $host2->getLoad()->willReturn(self::LOWEST_LOAD_ABOVE_FACTOR);
        $host3->getLoad()->willReturn(self::HIGHEST_LOAD_ABOVE_FACTOR);

        $hosts = new Hosts(
            $host1->getWrappedObject(),
            $host2->getWrappedObject(),
            $host3->getWrappedObject()
        );

        $host = $this->chooseHost($hosts);
        $host->getLoad()->shouldBe(self::LOWEST_LOAD_ABOVE_FACTOR);
    }
}
