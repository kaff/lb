<?php

namespace spec\LoadBalancer\BalancingAlgorithm;

use LoadBalancer\Host;
use LoadBalancer\Hosts;
use PhpSpec\ObjectBehavior;

class NextInLoopSpec extends ObjectBehavior
{
    function let()
    {
        ini_set("precision", 20);
    }

    function it_returns_first_host_from_list_when_there_are_only_unused_hosts(
        Host $host1,
        Host $host2,
        Host $host3
    ) {
        $host1->getMicrotimeOfHandlingLastRequest()->willReturn(null);
        $host2->getMicrotimeOfHandlingLastRequest()->willReturn(null);
        $host3->getMicrotimeOfHandlingLastRequest()->willReturn(null);

        $hosts = new Hosts(
            $host1->getWrappedObject(),
            $host2->getWrappedObject(),
            $host3->getWrappedObject()
        );

        $this->chooseHost($hosts)->shouldBe($host1);
    }

    function it_returns_first_in_order_unused_host_from_list_when_there_are_some_hosts_which_have_already_handled_some_request(
        Host $currentHost,
        Host $nextHost,
        Host $host3
    ) {
        $currentHost->getMicrotimeOfHandlingLastRequest()->willReturn(1584815240.17130014);
        $nextHost->getMicrotimeOfHandlingLastRequest()->willReturn(null);
        $host3->getMicrotimeOfHandlingLastRequest()->willReturn(null);

        $hosts = new Hosts(
            $currentHost->getWrappedObject(),
            $nextHost->getWrappedObject(),
            $host3->getWrappedObject()
        );

        $this->chooseHost($hosts)->shouldBe($nextHost);
    }

    function it_returns_next_in_order_host_when_there_are_only_hosts_which_have_already_handled_some_request(
        Host $previousHost,
        Host $currentHost,
        Host $nextHost
    ) {
        $previousHost->getMicrotimeOfHandlingLastRequest()->willReturn(1584815240.2462420464);
        $currentHost->getMicrotimeOfHandlingLastRequest()->willReturn(1584815240.2462460995);
        $nextHost->getMicrotimeOfHandlingLastRequest()->willReturn(1584815240.2462229729);

        $hosts = new Hosts(
            $previousHost->getWrappedObject(),
            $currentHost->getWrappedObject(),
            $nextHost->getWrappedObject()
        );

        $this->chooseHost($hosts)->shouldBe($nextHost);
    }
}
