<?php

declare(strict_types=1);

namespace App\Handler;

use Hangouh\LaminasHealth\Service\RedisConnectionService;
use Hangouh\LaminasHealth\Service\SqlConnectionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

class HealthHandler implements RequestHandlerInterface
{
    /**
     * @var SqlConnectionService
     */
    private $sqlConnectionService;

    /**
     * @var RedisConnectionService
     */
    private $redisConnectionService;

    public function __construct(
        SqlConnectionService $sqlConnectionService,
        RedisConnectionService $redisConnectionService
    ) {
        $this->sqlConnectionService = $sqlConnectionService;
        $this->redisConnectionService = $redisConnectionService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'sql' => $this->sqlConnectionService->checkConnection(),
            'redis' => $this->redisConnectionService->checkConnection()
        ]);
    }
}
