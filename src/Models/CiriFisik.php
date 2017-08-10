<?php

namespace App\Models;

class CiriFisik extends BaseModel
{
    protected $table = 'ciri_fisik';

    protected $column = [
        'id', 'id_user', 'tinggi', 'berat', 'suku', 'warna_kulit', 'kaca_mata',
        'jenggot', 'hijab', 'cadar', 'status_kesehatan', 'ciri_fisik_lain',
        'created_at', 'updated_at',
    ];

    public function add (array $data)
    {
        $data   =   [
            'id_user'   =>  $data['id_user'],
            'tinggi'    =>  $data['tinggi'],
            'berat'     =>  $data['berat'],
            'suku'      =>  $data['suku'],
            'warna_kulit'   =>  $data['warna_kulit'],
            'kaca_mata'    =>  $data['kaca_mata'],
            'jenggot'       =>  $data['jenggot'],
            'hijab'         =>  $data['hijab'],
            'cadar'         =>  $data['cadar'],
            'status_kesehatan'  =>  $data['status_kesehatan'],
            'ciri_fisik_lain'    =>  $data['ciri_kesehatan'],
            'updated_at'        => date("Y-m-d H:i:s"),
        ];

        $this->create($data);
    }

}
