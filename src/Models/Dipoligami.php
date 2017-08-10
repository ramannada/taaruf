<?php
namespace App\Models;

class Dipoligami extends BaseModel
{
    protected $table = 'dipoligami';

    protected $column = [
        'id', 'id_user', 'kesiapan', 'penjelasan', 'created_at',
        'updated_at',
    ];

    public function add (array $data)
    {
        $data = [
            'id_user'   => $data['id_user'],
            'kesiapan'  =>  $data['kesiapan'],
            'penjelasan'    =>  $data['penjelasan'],
            'updated_at'        => date("Y-m-d H:i:s"),
        ];

        $this->create($data);
    }
}
