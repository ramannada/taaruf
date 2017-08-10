<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController extends \App\Controllers\BaseController
{
    public function add (Request $request, Response $response)
    {
        $rules = [
			'required'	=> [
				['nama_lengkap'],
				['jenis_kelamin'],
				['tanggal_lahir'],
                ['tempat_lahir'],
                ['alamat'],
                ['kota'],
                ['provinsi'],
                ['kewarganegaraan'],
                ['target_menikah'],
                ['tentang_saya'],
                ['pasangan_harapan'],
            ],
		];

        $this->validator->rules($rules);

        if ($this->validator->validate()) {
            $profile = new \App\Models\Profile($this->db);
            $user = new \App\Models\User($this->db);

            $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

            $find   = $profile->find('id_user', $user['id']);


            if (!$find) {
                $input = $request->getParsedBody();
                $input['id_user'] = $user['id'];

                $profile->add($input);

                $find   = $profile->find('id_user', $user['id']);

                if ($find) {
                    $data['status'] = 201;
        			$data['message'] = 'Sukses menambah data';
        			$data['data'] = $find;
                } else {
                    $data['status'] = 404;
        			$data['message'] = 'Failed data not found';
        			$data['data'] = null;
                }
            } else {
                $data['status'] = 400;
                $data['message'] = 'Failed data was created';
                $data['data'] = null;
            }
        } else {
            $data['status'] = 400;
            $data['message'] = 'Error';
            $data['data'] = $this->validator->errors();
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);


    }
    public function index ()
    {
        $profile = new \App\Models\Profile($this->db);
        $profile = $profile->getAll();

        if ($profile) {
            $data['status'] = 200;
    		$data['message'] = 'Data Available';
    		$data['data'] = $profile;
        } else {
            $data['status'] = 200;
    		$data['message'] = 'Data is empty';
    		$data['data'] = null;
        }

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }
    public function detail (Request $request, Response $response, $args)
    {

        $profile = new \App\Models\Profile($this->db);
        $profile = $profile->findWithoutDelete('id_user', $args['id']);

        if ($profile) {
            $data['status'] = 200;
    		$data['message'] = 'Data Available';
    		$data['data'] = $profile;
        } else {
            $data['status'] = 200;
    		$data['message'] = 'Data is empty';
    		$data['data'] = $profile;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }
    public function update(Request $request, Response $response)
    {
        $profile    = new \App\Models\Profile($this->db);
        $user       = new \App\Models\User($this->db);

        $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $find = $profile->findWithoutDelete('id_user', $user['id']);

        if ($find) {
            $rules = [
                'required'	=> [
    				['nama_lengkap'],
    				['jenis_kelamin'],
    				['tanggal_lahir'],
                    ['tempat_lahir'],
                    ['alamat'],
                    ['kota'],
                    ['provinsi'],
                    ['kewarganegaraan'],
                    ['target_menikah'],
                    ['tentang_saya'],
                    ['pasangan_harapan'],
                ],
            ];
            $this->validator->rules($rules);

            if ($this->validator->validate()) {

                try {
                    $profile->update($request->getParsedBody(), 'id_user', $user['id']);

                    $find = $profile->findWithoutDelete('id_user', $user['id']);

                    $data['status'] = 200;
            		$data['message'] = 'Data Has Been Updated';
            		$data['data'] = $find;
                } catch (Exception $e) {
                    $data['status'] = 404;
            		$data['message'] = 'Update Failed';
            		$data['data'] = null;
                }


            } else {
                $data['status'] = 400;
                $data['message'] = 'Error';
                $data['data'] = $this->validator->errors();
            }
        } else {
            $data['status'] = 404;
            $data['message'] = 'Data not found';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }
    public function delete(Request $request, Response $response)
    {
        $profile    = new \App\Models\Profile($this->db);
        $user       = new \App\Models\User($this->db);

        $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        if ($user) {
            $profile->deleteByColumn('id_user', $user['id']);

            if (!$profile->findWithoutDelete('id_user', $args['id'])) {
                $data['status'] = 200;
                $data['message'] = 'Data Has Been Deleted';
                $data['data'] = null;
            } else {
                $data['status'] = 400;
                $data['message'] = 'Error';
                $data['data'] = null;
            }
        } else {
            $data['status'] = 404;
            $data['message'] = 'Data tidak ditemukan';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);

    }
}
