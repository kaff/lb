<?php

namespace spec\Network;

use Network\IPv4;
use PhpSpec\ObjectBehavior;

class IPv4Spec extends ObjectBehavior
{
    function it_is_initializable_when_ip_is_given()
    {
        $this->beConstructedWith('192.168.1.1');
        $this->shouldNotThrow(\InvalidArgumentException::class)->duringInstantiation();

    }

    function it_throw_an_exception_when_given_ip_is_incorrect()
    {
        $this->beConstructedWith('999.999.999.999');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
