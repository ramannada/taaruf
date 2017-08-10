<?php
namespace App\Models;

class Kota extends BaseModel
{
    protected $table = 'kota';

    protected $column = [
        'id', 'id_provinsi', 'nama',
    ];

    public function addKota(array $data)
    {
        $data = [
            'id_provinsi'   => $data['id_provinsi'],
            'nama'  =>  $data['nama'],
        ];

        $this->create($data);
    }
    public function updateKota(array $data, $id)
    {
        $data = [
            'nama' => $data['nama'],
        ];
        $this->update($data, 'id', $id);
    }
}
