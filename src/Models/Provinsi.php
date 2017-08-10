<?php
namespace App\Models;

class Provinsi extends BaseModel
{
    protected $table = 'provinsi';

    protected $column = [
        'id', 'id_negara', 'nama',
    ];

    public function addProvinsi (array $data)
    {
        $data = [
            'id_negara'   => $data['id_negara'],
            'nama'  =>  $data['nama'],
        ];

        $this->create($data);
    }
    public function updateProvinsi(array $data, $id)
    {
        $data = [
            'nama' => $data['nama'],
        ];
        $this->update($data, 'id', $id);
    }
}
