<?php

namespace App\Task;

class TaskName
{
    protected $name;

    public function set($name = '')
    {
        $result = false;

        if (null === $this->name
            && !empty($name)
            && $this->validate($name)
        ) {
            $name = $this->sanitize($name);
            $this->name = $name;
            $result = true;
        }

        return $result;
    }

    public function get()
    {
        return $this->name;
    }

    protected function validate()
    {
        // TODO: implement validation logic, string lentgh for example
        return true;
    }

    protected function sanitize($name = '')
    {
        return filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
    }
}

