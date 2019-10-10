<?php

use think\migration\Migrator;

class Admin extends Migrator
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
        $table = $this->table('admin', array('engine' => 'InnoDB'));
        $table->addColumn('group_id', 'integer', array('limit' => 11, 'default' => 0))
            ->addColumn('nickname', 'string', array('limit' => 24))
            ->addColumn('password', 'string', array('limit' => 100))
            ->addColumn('email', 'string', array('limit' => 100))
            ->addColumn('avatar', 'string', array('limit' => 255))
            ->addColumn('is_super', 'integer', array('limit' => 1, 'default' => 0, 'comment' => '是否为超级管理员 ; 0 -> 否 | 1 -> 是'))
            ->addColumn('status', 'integer', array('limit' => 1, 'default' => 1, 'comment' => '状态 ; 1 -> 正常 | 2 -> 禁用'))
            ->addTimestamps('create_time', 'update_time')
            ->addSoftDelete()
            ->addIndex(array('nickname', 'email'))
            ->create();
    }
}
