<?php

use Phinx\Migration\AbstractMigration;

class CreateCiriFisikTable extends AbstractMigration
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
         $user = $this->table('ciri_fisik');
         $user->addColumn('id_user', 'integer')
              ->addColumn('tinggi', 'integer')
              ->addColumn('berat', 'integer')
              ->addColumn('warna_kulit', 'enum', ['values' => ['sangat putih', 'putih', 'kuning langsat','kuning','sawo matang','coklat','gelap']])
              ->addColumn('jenggot', 'enum', ['values' => ['dicukur', 'tipis', 'sedang', 'panjang']])
              ->addColumn('hijab', 'enum', ['values' => ['sangat panjang', 'panjang', 'sedang', 'kecil', 'belum berhijab']])
              ->addColumn('cadar', 'enum', ['values' => ['ya', 'tidak', 'setelah menikah']])
              ->addColumn('kaca_mata', 'boolean')
              ->addColumn('status_kesehatan', 'enum', ['values' => ['sehat', 'masalah kesehatan serius', 'cacat fisik ringan', 'cacat fisik serius']])
              ->addColumn('ciri_fisik_lain', 'text')
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
