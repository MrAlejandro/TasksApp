<?php
namespace App\Task\TaskRepository;

use App\Model;

class TaskRepository
{
    protected $storageDriver;

    public function __construct()
    {
        $config = Model::getDIContainer()->get('config');

        if (!empty($config['storage'])) {
            $className = 'task_' . strtolower($config['storage']) . '_storage';
            $this->storageDriver = Model::instance($className);
        } else {
            throw new \RuntimeException('Storage is undefined in the config');
        }
    }

    public function getStorageDriver()
    {
        return $this->storageDriver;
    }
}
