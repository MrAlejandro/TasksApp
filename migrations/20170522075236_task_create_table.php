<?php

use Phinx\Migration\AbstractMigration;

class TaskCreateTable extends AbstractMigration
{
    public function up()
    {
        $task = $this->table('task');
        $task->addColumn('uuid', 'uuid')
            ->addColumn('name', 'string', array('limit' => 255))
            ->addColumn('status', 'integer')
            ->addColumn('priority', 'integer')
            ->addColumn('tags', 'text')
            ->addColumn('created_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'timestamp', array('default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'))
            ->save();
        }
}
