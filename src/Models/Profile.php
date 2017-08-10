<?php

namespace App\Models;

class Profile extends BaseModel
{
	protected $table = 'profile';
	protected $column = [
        'id','id_user', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir', 'alamat',
        'kota', 'provinsi', 'kewarganegaraan', 'target_menikah', 'tentang_saya', 'pasangan_harapan', 'created_at', 'updated_at',
    ];

    public function add(array $data)
    {
        $data = [
            'id_user'       => $data['id_user'],
            'nama_lengkap'  => $data['nama_lengkap'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => $data['tempat_lahir'],
            'alamat'        => $data['alamat'],
            'kota'          => $data['kota'],
            'provinsi'      => $data['provinsi'],
            'kewarganegaraan'   => $data['kewarganegaraan'],
            'target_menikah'    => $data['target_menikah'],
            'tentang_saya'  => $data['tentang_saya'],
            'pasangan_harapan'  => $data['pasangan_harapan'],
            'updated_at'    => date("Y-m-d H:i:s"),
        ];
        $this->create($data);

		return $this->db->lastInsertId();
    }

    public function updateProfile(array $data, $id)
	{
		$data = [
            'id_user'       => $id,//$_SESSION['login']['id'],
            'nama_lengkap'  => $data['nama_lengkap'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tempat_lahir'  => $data['tempat_lahir'],
            'alamat'        => $data['alamat'],
            'kota'          => $data['kota'],
            'provinsi'      => $data['provinsi'],
            'kewarganegaraan'   => $data['kewarganegaraan'],
            'target_menikah'    => $data['target_menikah'],
            'tentang_saya'  => $data['tentang_saya'],
            'pasangan_harapan'  => $data['pasangan_harapan'],
            'updated_at'    => date("Y-m-d H:i:s"),
		];

		$this->update($data, 'id', $id);

	}
}
