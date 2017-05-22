<?php

if (
    empty($config['db']['host'])
    || empty($config['db']['database'])
    || empty($config['db']['username'])
    || !isset($config['db']['password'])
) {
    throw new RuntimeException('Invalid DB settings in config file');
}

return [
    Simplon\Mysql\Mysql::class => DI\object()
        ->constructor((new  Simplon\Mysql\PDOConnector(
            $config['db']['host'],
            $config['db']['username'],
            $config['db']['password'],
            $config['db']['database']
            ))->connect('utf8mb4')),
];
