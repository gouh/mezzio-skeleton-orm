<?php

declare(strict_types=1);

namespace App\Handler;

use Fig\Http\Message\StatusCodeInterface;
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

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @see https://sawtooth.hyperledger.org/docs/core/nightly/0-8/architecture/rest_api.html
     * @see
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'data' => [
                'sql_connection' => $this->sqlConnectionService->checkConnection(),
                'redis_connection' => $this->redisConnectionService->checkConnection()
            ]
        ], StatusCodeInterface::STATUS_OK);
    }
}
