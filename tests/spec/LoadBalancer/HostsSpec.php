<?php

namespace spec\LoadBalancer;

use LoadBalancer\Host;
use Network\IPv4;
use PhpSpec\ObjectBehavior;

class HostsSpec extends ObjectBehavior
{
    function it_is_initializable_with_hosts()
    {
        $host1 = new Host(new IPv4('192.168.1.1'));
        $host2 = new Host(new IPv4('192.168.1.2'));
        $host3 = new Host(new IPv4('192.168.1.3'));

        $this->beConstructedWith($host1, $host2, $host3);
    }

    function it_throws_exception_when_host_list_is_empty()
    {
        $this->beConstructedWith();
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_returns_hosts_as_array()
    {
        $host1 = new Host(new IPv4('192.168.1.1'));
        $host2 = new Host(new IPv4('192.168.1.2'));
        $host3 = new Host(new IPv4('192.168.1.3'));

        $this->beConstructedWith($host1, $host2, $host3);

        $this->toArray()->shouldEqual([
            $host1,
            $host2,
            $host3
        ]);
    }

    function it_ensures_that_operation_on_returned_array_does_not_affect_state()
    {
        $host1 = new Host(new IPv4('192.168.1.1'));
        $host2 = new Host(new IPv4('192.168.1.2'));
        $host3 = new Host(new IPv4('192.168.1.3'));

        $this->beConstructedWith($host1, $host2, $host3);
        
        $hostsArray = ($this->toArray())->getWrappedObject();
        unset($hostsArray[0]);

        $this->toArray()->shouldNotBeLike($hostsArray);
    }
}
