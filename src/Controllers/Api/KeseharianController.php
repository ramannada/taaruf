<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class KeseharianController extends \App\Controllers\BaseController
{
    public function show(Request $request, Response $response, $args)
    {
        $keseharian = new \App\Models\Keseharian($this->db);

        $keseharian = $keseharian->findWithoutDelete('id_user', $args['id']);

        if ($keseharian) {
            $data['status']       = 200;
			$data['message']      = 'Success get data';
            $data['data']         = $keseharian;
        } else {
            $data['status']       = 404;
			$data['message']      = 'Data not found';
            $data['data']         = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function add(Request $request, Response $response)
    {


        $rules = [
			'required'	=> [
				['pekerjaan'],
				['status_pekerjaan'],
				['penghasilan_per_bulan'],
                ['status'],
                ['status_tinggal'],
                ['bersedia_pindah_tinggal'],
            ],
		];

		$this->validator->rules($rules);

        if ($this->validator->validate()) {
            $user       = new \App\Models\User($this->db);
            $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

            $keseharian = new \App\Models\Keseharian($this->db);

            $find = $keseharian->findWithoutDelete('id_user', $user['id']);

            if (!$find) {
                $datainput  = $request->getParsedBody();
                $datainput['id_user'] = $user['id'];

                $add = $keseharian->add($datainput);

                if ($add) {
                    $find = $keseharian->findWithoutDelete('id_user', $datainput['id_user']);

                    if ($find) {
                        $data['status']       = 200;
            			$data['message']      = "Data telah tersimpan";
                        $data['data']         = $find;
                    } else {
                        $data['status']       = 500;
            			$data['message']      = "Gagal menambahkan data";
                        $data['data']         = null;
                    }
                }
            } else {
                $data['status']       = 400;
                $data['message']      = "Data sudah ada";
                $data['data']         = null;
            }

        } else {
            $data['status']       = 400;
			$data['message']      = $this->validator->errors;
            $data['data']         = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response)
    {
        $user       = new \App\Models\User($this->db);
        $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $keseharian = new \App\Models\Keseharian($this->db);

        $find       = $keseharian->findWithoutDelete('id_user', $user['id']);

        if ($find) {
            $datainput  = $request->getParsedBody();
            $datainput['id_user'] = $user['id'];

            // $update = $keseharian->updateKeseharian($datainput);

            try {
                $keseharian->updateKeseharian($datainput);
                $find       = $keseharian->findWithoutDelete('id_user', $user['id']);

                $data['status']       = 200;
                $data['message']      = "Data telah tersimpan";
                $data['data']         = $find;
            } catch (Exception $e) {
                $data['status']       = 500;
                $data['message']      = $e->getMessage();
                $data['data']         = null;
            }

            // if ($update) {
            //     $data['status']       = 200;
            //     $data['message']      = "Data telah tersimpan";
            //     $data['data']         = $find;
            // } else {
            //     $data['status']       = 500;
            //     $data['message']      = "Gagal memperbarui data";
            //     $data['data']         = null;
            // }
        } else {
            $data['status']       = 404;
			$data['message']      = "Updata gagal data keseharian tidak ditemukan";
            $data['data']         = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function delete(Request $request, Response $response)
    {
        $user       = new \App\Models\User($this->db);

        $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $keseharian = new \App\Models\Keseharian($this->db);

        $keseharian->deleteByColumn('id_user', $user['id']);

        $find = $keseharian->findWithoutDelete('id_user', $user['id']);

        if (!$find) {
            $data['status']       = 200;
			$data['message']      = "Sukses hapus profil";
            $data['data']         = null;
        } else {
            $data['status']       = 500;
			$data['message']      = "Hapus profil gagal";
            $data['data']         = $find;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }
}
