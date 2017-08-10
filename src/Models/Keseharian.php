<?php
namespace App\Models;

class Keseharian extends BaseModel
{
    protected $table = 'keseharian';

    protected $column = [
        'id', 'id_user', 'pekerjaan', 'status_pekerjaan', 'penghasilan_per_bulan', 'status', 'jumlah_anak',
        'anak_tertua', 'anak_termuda', 'status_tinggal', 'memiliki_cicilan', 'bersedia_pindah_tinggal',
        'created_at','updated_at',
    ];

    public function add (array $data)
    {
        $data = [
            'id_user'       =>  $data['id_user'],
            'pekerjaan'     =>  $data['pekerjaan'],
            'status_pekerjaan'  =>  $data['status_pekerjaan'],
            'penghasilan_per_bulan' =>  $data['penghasilan'],
            'status'        =>  $data['status'],
            'jumlah_anak'   =>  $data['jumlah_anak'],
            'anak_tertua'   =>  $data['anak_tertua'],
            'anak_termuda'  =>  $data['anak_termuda'],
            'status_tinggal'    =>  $data['status_tinggal'],
            'memiliki_cicilan'  =>  $data['memiliki_cicilan'],
            'bersedia_pindah_tinggal'   =>  $data['bersedia_pindah_tinggal'],
            'updated_at'   =>  date("Y-m-d H:i:s"),
        ];

        $this->create($data);

        return $this->db->lastInsertId();
    }

    public function updateKeseharian(array $data)
    {
        $data = [
            'id_user'       =>  $data['id_user'],
            'pekerjaan'     =>  $data['pekerjaan'],
            'status_pekerjaan'  =>  $data['status_pekerjaan'],
            'penghasilan_per_bulan' =>  $data['penghasilan'],
            'status'        =>  $data['status'],
            'jumlah_anak'   =>  $data['jumlah_anak'],
            'anak_tertua'   =>  $data['anak_tertua'],
            'anak_termuda'  =>  $data['anak_termuda'],
            'status_tinggal'    =>  $data['status_tinggal'],
            'memiliki_cicilan'  =>  $data['memiliki_cicilan'],
            'bersedia_pindah_tinggal'   =>  $data['bersedia_pindah_tinggal'],
            'updated_at'   =>  date("Y-m-d H:i:s"),
        ];


        $this->update($data, 'id_user', $data['id_user']);

        return $this->db->lastInsertId();
    }
    
}
