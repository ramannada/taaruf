<?php
namespace App\Models;

class LatarBelakang extends BaseModel
{
    protected $table = 'latar_belakang';

    protected $column = [
        'id', 'id_user', 'pendidikan', 'penjelasan_pendidikan', 'agama', 'penjelasan_agama', 'muallaf',
        'baca_quran', 'hafalan', 'keluarga', 'penjelasan_keluarga', 'shalat', 'id_poligami', 'id_dipoligami',
        'created_at', 'updated_at',
    ];

    public function add (array $data)
    {
        $data = [
            'id_user'       =>  $data['id_user'],
            'pendidikan'    =>  $data['pendidikan'],
            'penjelasan_pendidikan' => $data['penjelasan_pendidikan'],
            'agama'         =>  $data['agama'],
            'penjelasan_agama'  =>  $data['penjelasan_agama'],
            'muallaf'       =>  $data['muallaf'],
            'baca_quran'   =>  $data['baca_quran'],
            'hafalan'      =>  $data['hafalan'],
            'keluarga'     =>  $data['keluarga'],
            'penjelasan_keluarga'   =>  $data['penjelasan_keluarga'],
            'shalat'        =>  $data['shalat'],
            'id_poligami'   =>  $data['id_poligami'],
            'id_dipoligami' =>  $data['id_dipoligami'],
            'updated_at'    => date("Y-m-d H:i:s"),
        ];

        $this->create($data);

		return $this->db->lastInsertId();
    }

    public function updateLatarBelakang(array $data)
    {
        $data = [
            'id_user'       =>  $data['id_user'],
            'pendidikan'    =>  $data['pendidikan'],
            'penjelasan_pendidikan' => $data['penjelasan_pendidikan'],
            'agama'         =>  $data['agama'],
            'penjelasan_agama'  =>  $data['penjelasan_agama'],
            'muallaf'       =>  $data['muallaf'],
            'baca_quran'   =>  $data['baca_quran'],
            'hafalan'      =>  $data['hafalan'],
            'keluarga'     =>  $data['keluarga'],
            'penjelasan_keluarga'   =>  $data['penjelasan_keluarga'],
            'shalat'        =>  $data['shalat'],
            'id_poligami'   =>  $data['id_poligami'],
            'id_dipoligami' =>  $data['id_dipoligami'],
            'updated_at'    => date("Y-m-d H:i:s"),
        ];


        $this->update($data, 'id_user', $data['id_user']);

        return $this->db->lastInsertId();
    }
}
