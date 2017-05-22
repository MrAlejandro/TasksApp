<?php
namespace App\Task\Interfaces;

interface TaskStorageInterface
{
    public function save(\App\Task\Interfaces\TaskInterface $task);

    public function saveCollection(Array $tasks);

    public function get($id);

    public function getCollection(Array $ids);
}
