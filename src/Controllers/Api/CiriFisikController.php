<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CiriFisikController extends \App\Controllers\BaseController
{

    public function show (Request $request, Response $response, $args)
    {
        $fisik  =   new \App\Models\CiriFisik($this->db);
        $user   =   new \App\Models\User($this->db);

        $fisik   =   $fisik->findWithoutDelete('id_user', $args['id']);

        if ($fisik) {
            $data['status']       = 200;
			$data['message']      = 'Success get data';
            $data['data']         = $fisik;
        } else {
            $data['status']       = 404;
			$data['message']      = 'Data not found';
            $data['data']         = NULL;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function add (Request $request, Response $response)
    {
        $rules = [
			'required'	=> [
				['suku'],
				['warna_kulit'],
				['kaca_mata'],
                ['status_kesehatan'],
            ],
		];

		$this->validator->rules($rules);

        if ($this->validator->validate()) {
            $ciriFisik  = new \App\Models\CiriFisik($this->db);
            $user       = new \App\Models\User($this->db);


            $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

            if ($user) {
                $find       = $ciriFisik->find('id_user', $user['id']);

                if (!$find) {
                    $fisik       = $request->getParsedBody();

                    $fisik['id_user'] = $user['id'];

                    $add        = $ciriFisik->add($fisik);


                    $find       = $ciriFisik->find('id_user', $user['id']);

                    if ($find) {
                        $data['status'] = 200;
            			$data['message'] = 'Sukses menambah ciri fisik';
            			$data['data'] = $find;
                    } else {
                        $data['status'] = 400;
            			$data['message'] = 'Error';
            			$data['data'] = $this->validator->errors();
                    }
                } else {
                    $data['status'] = 400;
                    $data['message'] = 'Data sudah ada';
                    $data['data'] = null;    
                }

            } else {
                $data['status'] = 404;
                $data['message'] = 'User not found';
                $data['data'] = null;
            }

        } else {
            $data['status'] = 400;
			$data['message'] = 'Error';
			$data['data'] = $this->validator->errors();
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $fisik  = new \App\Models\CiriFisik($this->db);
        $user   = new \App\Models\User($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $find = $fisik->findWithoutDelete('id_user', $user['id']);

        if ($find) {
            $rules = [
                'required'	=> [
    				['suku'],
    				['warna_kulit'],
    				['kaca_mata'],
                    ['status_kesehatan'],
                ],
            ];

            $this->validator->rules($rules);

            if ($this->validator->validate()) {
                $update = $fisik->update($request->getParsedBody(), 'id_user', $user['id']);

                if ($update) {
                    $fisik = $fisik->findWithoutDelete('id_user', $user['id']);

                    $data['status'] = 200;
            		$data['message'] = 'Data Has Been Updated';
            		$data['data'] = $fisik;
                } else {
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
        $fisik = new \App\Models\CiriFisik($this->db);
        $user  = new \App\Models\User($this->db);

        $user       = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $fisik->deleteByColumn('id_user', $user['id']); // $_SESSION['login']['id']

        if (!$fisik->findWithoutDelete('id_user', $user['id'])) {
            $data['status'] = 200;
            $data['message'] = 'Data Has Been Deleted';
            $data['data'] = null;
        } else {
            $data['status'] = 400;
            $data['message'] = 'Error';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);

    }
}
