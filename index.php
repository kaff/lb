<?php

use LoadBalancer\BalancingAlgorithm\NextInLoop;
use LoadBalancer\Host;
use LoadBalancer\Hosts;
use LoadBalancer\LoadBalancer;

$request = new Request();

$loadBalancer = new LoadBalancer(
    new Hosts(
        new Host('172.21.4.1'),
        new Host('172.21.4.2')
    ), new NextInLoop());

$loadBalancer->handleRequest($request);
