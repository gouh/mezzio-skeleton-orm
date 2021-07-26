<?php

declare(strict_types=1);

namespace App\Handler;

use Hangouh\LaminasHealth\Service\RedisConnectionService;
use Hangouh\LaminasHealth\Service\SqlConnectionService;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HealthHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $sqlConnectionService = $container->get(SqlConnectionService::class);
        $redisConnectionService = $container->get(RedisConnectionService::class);

        return new HealthHandler($sqlConnectionService, $redisConnectionService);
    }
}
