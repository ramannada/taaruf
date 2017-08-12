<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
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
    public function up()
    {
        $user = $this->table('user');
        $user->addColumn('username', 'string')
             ->addColumn('auth','string')
             ->addColumn('email', 'string')
             ->addColumn('password', 'string')
             ->addColumn('password_reset_token', 'string')
             ->addColumn('photo', 'string')
             ->addColumn('ktp', 'string')
             ->addColumn('role', 'integer', ['limit' => 3, 'default' => 0])
             ->addColumn('status', 'integer')
             ->addColumn('accepted_by', 'integer')
             ->addColumn('last_online', 'datetime')
             ->addColumn('update_at', 'datetime')
             ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
             ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0])
             ->addIndex(['username', 'email'], ['unique' => true])
             ->create();

    }


}
