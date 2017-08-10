<?php
namespace App\Models;

class Negara extends BaseModel
{
    protected $table = 'negara';

    protected $column = [
        'id', 'nama',
    ];


    public function addNegara (array $data)
    {
        $data = [
            'nama'  =>  $data['nama'],
        ];

        $this->create($data);
    }
    public function updateNegara(array $data, $id)
    {
        $data = [
            'nama' => $data['nama'],
        ];
        $this->update($data, 'id', $id);
    }
}
