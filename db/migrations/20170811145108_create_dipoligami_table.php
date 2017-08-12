<?php

use Phinx\Migration\AbstractMigration;

class CreateDipoligamiTable extends AbstractMigration
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
         $user = $this->table('dipoligami');
         $user->addColumn('id_user', 'integer')
              ->addColumn('kesiapan', 'enum', ['values' => ['bersedia', 'kurang yakin', 'tidak bersedia']])
              ->addColumn('penjelasan_kesiapan', 'text')
              ->addColumn('update_at', 'datetime')
              ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addIndex('id_user', ['unique' => true])
              ->addForeignKey('id_user', 'user', 'id')
              ->create();
     }

     public function down()
     {

     }
}
