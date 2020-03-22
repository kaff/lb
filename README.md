LoadBalancer
============================

# System requirements

* PHP 7.4

### First run

Clone the app repository

```bash
git clone https://github.com/kaff/lb.git
```

## with Docker & docker-compose 
(all command should be run in project root directory) 

Run in bash
```
docker-compose build
docker-compose up -d
docker-compose exec php bash -c "composer install"
```

to run all test
```
docker-compose exec php bash -c "vendor/bin/phpunit && vendor/bin/phpspec run"
```
# Usage example

```php
use LoadBalancer\Host;
use LoadBalancer\Hosts;
use LoadBalancer\LoadBalancer;
use Network\IPv4;

$loadBalancer = new LoadBalancer(
    new Hosts(
        new Host(new IPv4('192.168.1.1')),
        new Host(new IPv4('192.168.1.2')),
        new Host(new IPv4('192.168.1.3'))
), new BalancingAlgorithm\NextInLoop());

$loadBalancer->handleRequest($request);
```
