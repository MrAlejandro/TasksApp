<?php

if (
    empty($config['db']['host'])
    || empty($config['db']['database'])
    || empty($config['db']['username'])
    || !isset($config['db']['password'])
    || empty($config['db']['port'])
) {
    throw new RuntimeException('Invalid DB settings in config file');
}

return [
    Workerman\MySQL\Connection::class => DI\object()
        ->constructor(
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['username'],
            $config['db']['password'],
            $config['db']['database']
        ),
];
