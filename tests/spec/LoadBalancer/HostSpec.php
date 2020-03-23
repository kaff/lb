<?php

namespace spec\LoadBalancer;

use Network\IPv4;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class HostSpec extends ObjectBehavior
{
    function let()
    {
        $ip = new IPv4('192.168.1.1');

        $this->beConstructedWith($ip);
    }

    function it_returns_current_load()
    {
        throw new PendingException();
    }

    function it_handles_request()
    {
        throw new PendingException();
    }

    function it_returns_nullable_microtime_of_handling_last_request_when_there_was_not_any_request_handled_yet()
    {
        $this->getMicrotimeOfHandlingLastRequest()->shouldBe(null);
    }    
    
    function it_returns_microtime_of_handling_last_request_when_was_some_request_handled(RequestInterface $request)
    {
        $this->handleRequest($request);

        $this->getMicrotimeOfHandlingLastRequest()->shouldBeFloat();
    }

    function it_update_microtime_of_handling_last_request_after_handling_each_request(RequestInterface $request)
    {
        $this->handleRequest($request);
        $microtimeOfSendingFirstRequest =  $this->getMicrotimeOfHandlingLastRequest();

        $this->handleRequest($request);
        $this->getMicrotimeOfHandlingLastRequest()->shouldGreaterThan($microtimeOfSendingFirstRequest);
    }

    public function getMatchers(): array
    {
        return [
            'greaterThan' => function ($subject, $key) {
                if ($subject < $key) {
                    throw new FailureException(sprintf(
                        '"%s" is not greater than "%s".',
                        $subject, $key
                    ));
                }
                return true;
            }
        ];
    }
}
