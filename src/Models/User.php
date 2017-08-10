<?php

namespace App\Models;

class User extends BaseModel
{
	protected $table = 'user';
	protected $column = [
        'id','username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'foto',
        'foto_ktp', 'last_online', 'accepted_by', 'rule', 'status', 'created_at', 'updated_at',
    ];

	public function register(array $data)
	{
		$data = [
			'username'	=> $data['username'],
			'password_hash'	=> password_hash($data['password'], PASSWORD_BCRYPT),
			'email'		=> $data['email'],
            'foto' => $data['foto'],
            'foto_ktp' => $data['foto_ktp'],
            'rule' => 0,
            'status' => 0,
			];
		$this->create($data);

		return $this->db->lastInsertId();
	}

	public function updateUser(array $data, $id)
	{
		$data = [
            'username'	=> $data['username'],
			'password_hash'	=> password_hash($data['password'], PASSWORD_BCRYPT),
			'email'		=> $data['email'],
            'foto' => $data['foto'],
            'foto_ktp' => $data['foto_ktp'],
            'rule' => 0,
            'status' => 0,
            'updated_at' => date("Y-m-d H:i:s"),
		];

		$this->update($data, 'id', $id);

        $data   = $this->findWithoutDelete('id_user', $id);

        return $data;
	}

    public function login($data)
    {

        $user = $this->find('username', $data['username']);



        if ($user) {
            if (password_verify($data['password'], $user['password_hash'])) {
                $auth = md5(uniqid(date("Y-m-d H:i:s")));

                $data = [
                    'auth_key' => $auth,
                ];

                $this->update($data,'id' ,$user['id']);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getWithProfile($id)
    {
        // $kelamin = $this->joinOneId('profile', 'id_user', $id);
        $param = ':id';
        $this->qb->select('*')
            ->from($this->table, 'u')
            ->join('u', 'profile', 'p', 'u.id = p.id_user')
            ->where('u.id = '. $param)
            ->setParameter($param, $id);

        $result = $this->qb->execute();
        return $result->fetch();
    }

    public function getKelamin($id)
    {
        $user = $this->find('id', $id);

        if ($user) {
            $param = ':id';

            $this->qb->select('u.id, p.jenis_kelamin')
            ->from($this->table, 'u')
            ->join('u', 'profile', 'p', 'u.id = p.id_user')
            ->where('u.id = '. $param)
            ->setParameter($param, $id);

            $result = $this->qb->execute();
            return $result->fetch();
        } else {
            return false;
        }
    }
}
