<?php

if (
    empty($config['db']['host'])
    || empty($config['db']['database'])
    || empty($config['db']['username'])
    || empty($config['db']['password'])
    || empty($config['db']['port'])
) {
    throw new RuntimeException('Invalid DB settings in config file');
}

return [
    Eden\Mysql\Index::class => DI\object()
        ->constructor(
            $config['db']['host'],
            $config['db']['database'],
            $config['db']['username'],
            $config['db']['password'],
            $config['db']['host']
        ),
];
