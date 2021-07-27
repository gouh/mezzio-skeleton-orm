<?php

/**
 * Local configuration.
 *
 * Copy this file to `local.php` and change its settings as required.
 * `local.php` is ignored by git and safe to use for local and sensitive data like usernames and passwords.
 */

declare(strict_types=1);

use Laminas\Cache\Storage\Adapter\Redis;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'entity_namespaces' => [
                    'geo' => 'App\Entity'
                ],
                'sql_logger' => new \Doctrine\DBAL\Logging\DebugStack()
            ]
        ],
        'connection' => [
            'orm_default' => [
                'params' => [
                    'dbname' => getenv('VAR_DB_NAME'),
                    'user' => getenv('VAR_DB_USER'),
                    'password' => getenv('VAR_DB_PASSWORD'),
                    'host' => getenv('VAR_DB_HOST'),
                    'port' => getenv('VAR_DB_PORT'),
                    'driver' => 'pdo_mysql',
                    'charset' => 'utf8mb4',
                    'driverOptions' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'my_entity'
                ],
            ],
            'my_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../../src/App/src/Entity',
            ],
        ],
        'entity_manager' => [
            'orm_default' => [
                'connection' => 'orm_default', // Actually defaults to the entity manager config key, not hard-coded
                'configuration' => 'orm_default', // Actually defaults to the entity manager config key, not hard-coded
            ],
        ],
    ],
    # Config Cache Db
    'caches' => [
        Redis::class => [
            'adapter' => [
                'name' => Redis::class,
                'options' => [
                    'namespace' => 'mezzioskeleton',
                    'ttl' => 3600,
                    'server' => [
                        'host' => getenv('VAR_REDIS_HOST'),
                        'port' => getenv('VAR_REDIS_PORT')
                    ],
                    'password' => getenv('VAR_REDIS_PASSWORD')
                ]
            ]
        ]
    ],
];