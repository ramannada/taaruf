<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LatarBelakangController extends \App\Controllers\BaseController
{
    public function add(Request $request, Response $response)
    {
        $user           =  new \App\Models\User($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        if ($user) {
            $latarBelakang      = new \App\Models\LatarBelakang($this->db);

            $find = $latarBelakang->findWithoutDelete('id_user', $user['id']);

            if (!$find) {
                $input               = $request->getParsedBody();
                $input['id_user']    = $user['id'];

                $latarBelakang->create($input);

                $find = $latarBelakang->findWithoutDelete('id_user', $user['id']);

                if ($find) {
                    $data['status']     = 200;
                    $data['message']    = 'Berhasil menyimpan data';
                    $data['data']       = $find;
                } else {
                    $data['status']     = 500;
                    $data['message']    = 'Kesalahan dalam penyimpanan';
                    $data['data']       = $find;
                }
            } else {
                $data['status']     = 400;
                $data['message']    = 'Data sudah ada';
                $data['data']       = null;
            }
        } else {
            $data['status'] = 400;
            $data['message'] = 'Terjadi kesalahan';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function get(Request $request, Response $response, $args)
    {
        $latarBelakang = new \App\Models\LatarBelakang($this->db);

        $find = $latarBelakang->findWithoutDelete('id_user', $args['id']);

        if ($find) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $find;
        } else {
            $data['status'] = 404;
            $data['message'] = 'Data tidak ditemukan';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response)
    {
        $user           =  new \App\Models\User($this->db);

        $find = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        if ($find) {
            $latarBelakang = new \App\Models\LatarBelakang($this->db);

            $input = $request->getParsedBody();
            $input['id_user'] = $find['id'];

            try {
                $latarBelakang->updateLatarBelakang($input);

                $find = $latarBelakang->findWithoutDelete('id_user', $find['id']);

                $data['status'] = 200;
                $data['message'] = 'Sukses update data';
                $data['data'] = $find;
            } catch (Exception $e) {
                $data['status'] = 500;
                $data['message'] = 'Gagal melakukan update';
                $data['data'] = null;
            }


        } else {
            $data['status'] = 404;
            $data['message'] = 'User tidak ditemukan';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function delete(Request $request, Response $response)
    {
        $user = new \App\Models\User($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        if ($user) {
            $latarBelakang = new \App\Models\LatarBelakang($this->db);

            $latarBelakang->deleteByColumn('id_user', $user['id']);

            $find = $latarBelakang->findWithoutDelete('id_user', $user['id']);

            if (!$find) {
                $data['status'] = 200;
                $data['message'] = 'Sukses hapus data';
                $data['data'] = null;
            } else {
                $data['status'] = 500;
                $data['message'] = 'Gagal menghapus data';
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
