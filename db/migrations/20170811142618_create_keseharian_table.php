<?php

use Phinx\Migration\AbstractMigration;

class CreateKeseharianTable extends AbstractMigration
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
        $user = $this->table('keseharian');
        $user->addColumn('id_user', 'integer')
             ->addColumn('pekerjaan', 'string')
             ->addColumn('status_pekerjaan', 'enum', ['values' => ['full-time', 'part-time', 'rumah tangga', 'pensiun', ' tidak bekerja', 'pelajar/mahasiswa', 'lainnya']])
             ->addColumn('penghasilan_per_bulan', 'enum',['values' => ['tidak bekerja', 'di bawah Rp 1 juta', 'Rp 1 juta - Rp 2,5 juta', 'Rp 2,5 juta - Rp 5 juta', 'Rp 5 juta - Rp 10 juta', 'Rp 10 juta - Rp 30 juta', 'di atas Rp 30 juta']])
             ->addColumn('status', 'enum', ['values' => ['belum menikah', 'menikah 1 istri', 'menikah 2 istri', 'menikah 3 istri', 'menikah 4 istri', 'janda bercerai', 'janda karena meninggal', 'duda bercerai', 'duda karena meninggal']])
             ->addColumn('jumlah_anak', 'integer')
             ->addColumn('anak_tertua', 'integer')
             ->addColumn('anak_termuda', 'integer')
             ->addColumn('status_tinggal', 'enum', ['values' => ['rumah sendiri','rumah sewa', 'bersama orang tua', 'bersama teman']])
             ->addColumn('memilili_cicilan', 'enum', ['values' => ['ya, syari', 'ya, riba', 'tidak']])
             ->addColumn('bersedia_pindah_tinggal', 'enum', ['values' => ['ya','mungkin','tidak']])
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
