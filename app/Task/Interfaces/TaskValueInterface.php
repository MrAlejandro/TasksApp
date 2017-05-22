<?php
namespace App\Task\Interfaces;

interface TaskValueInterface
{
    public function get();

    public function set($value);
}