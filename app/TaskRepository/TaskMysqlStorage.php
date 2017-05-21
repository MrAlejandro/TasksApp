<?php
namespace App\TaskRepository;

use App\Model;

class TaskMysqlStorage implements TaskStorageInterface
{
    protected $connection;

    public function __construct(\Eden\Mysql\Index $connection)
    {
        $this->connection = $connection;
        $query  = 'SELECT * FROM cscart_users WHERE user_type = :admin';
        $bind = [':admin' => 'A'];
        var_dump($this->connection->query($query, $bind));
    }
}
