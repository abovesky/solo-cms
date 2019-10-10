<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AdminGroup extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('admin_group', array('engine' => 'InnoDB'));
        $table->addColumn('name', 'string', array('limit' => 60))
            ->addColumn('info', 'string', array('limit' => 255, 'null' => 'null'))
            ->create();
    }
}