<?php
namespace App\Task\Interfaces;

interface TaskStorageInterface
{
    public function create(\App\Task\Interfaces\TaskInterface $task);

    public function update(\App\Task\Interfaces\TaskInterface $task);

    public function saveCollection(Array $tasks);

    public function get($id);

    public function getCollection($page, $limit, $sort);
}
