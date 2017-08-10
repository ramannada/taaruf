<?php
namespace App\Models;

class Poligami extends BaseModel
{
    protected $table = 'poligami';

    protected $column = [
        'id', 'id_user', 'kesiapan', 'penjelasan', 'alasan_poligami', 'kondisi_istri', 'created_at',
        'updated_at',
    ];

    public function add (array $data)
    {
        $data = [
            'id_user'   => $data['id_user'],
            'kesiapan'  =>  $data['kesiapan'],
            'penjelasan'    =>  $data['penjelasan'],
            'alasan_poligami'   =>  $data['alasan'],
            'kondisi_istri'     =>  $data['kondisi_istri'],
            'updated_at'        => date("Y-m-d H:i:s"),
        ];

        $this->create($data);
    }

    public function updatePoligami (array $data)
    {
        $data = [
            'kesiapan'  =>  $data['kesiapan'],
            'penjelasan'    =>  $data['penjelasan'],
            'alasan_poligami'   =>  $data['alasan'],
            'kondisi_istri'     =>  $data['kondisi_istri'],
            'updated_at'        => date("Y-m-d H:i:s"),
        ];

        $this->update($data);
    }
}
