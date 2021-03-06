<?php

declare(strict_types=1);

namespace App\Factory\Delegator;

use Psr\Container\ContainerInterface;
use Mezzio\Application;

/**
 * @see https://docs.mezzio.dev/mezzio/v3/features/container/delegator-factories/
 */
class RouteDelegatorFactory
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback): Application
    {
        $app = $callback();

        // Health page
        $app->get('/health', \App\Handler\HealthHandler::class, 'mezzioskeleton.health');

        return $app;
    }
}