<?php

namespace App\Task;

class TaskId
{
    const UUID_LENGTH = 36;

    protected $uuid;

    public function set($uuid = '')
    {
        $result = false;

        if (null === $this->uuid) {
            $result = true;

            if (!empty($uuid) && $this->validate($uuid)) {
                $this->uuid = $uuid;
            } else {
                $this->uuid = $this->generate();
            }
        }

        return $result;
    }

    public function get()
    {
        return $this->id;
    }

    protected function validate($uuid = '')
    {
        return strlen($uuid) == self::UUID_LENGTH
            && preg_match(
                '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',
                $uuid
            );
    }

    protected function generate()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }
}

