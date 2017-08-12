<?php

use Phinx\Migration\AbstractMigration;

class CreateProfilTable extends AbstractMigration
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
         $user = $this->table('profil');
         $user->addColumn('id_user', 'integer')
              ->addColumn('nama_lengkap', 'string')
              ->addColumn('jenis_kelamin', 'enum', ['values' => ['laki-laki', 'perempuan']])
              ->addColumn('tanggal_lahir', 'date')
              ->addColumn('tempat_lahir', 'string')
              ->addColumn('alamat', 'text')
              ->addColumn('kota', 'integer')
              ->addColumn('provinsi', 'integer')
              ->addColumn('kewarganegaraan', 'integer')
              ->addColumn('target_menikah', 'date')
              ->addColumn('tentang_saya', 'text')
              ->addColumn('pasangan_harapan', 'text')
              ->addColumn('update_at', 'datetime')
              ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addIndex('id_user', ['unique' => true])
              ->addForeignKey('id_user', 'user', 'id')
              ->addForeignKey('kota', 'kota', 'id')
              ->addForeignKey('provinsi', 'provinsi', 'id')
              ->addForeignKey('kewarganegaraan', 'negara', 'id')
              ->create();
     }

     public function down()
     {

     }
}
