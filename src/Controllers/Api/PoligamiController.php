<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Poligami;
use \App\Models\User;

class PoligamiController extends \App\Controllers\BaseController
{
    public function add(Request $request, Response $response)
    {
        $user       = new User($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $kelamin = $user->getKelamin($id['id']));
        if ($kelamin == 'laki-laki') {
            $input              = $request->getParsedBody();
            $input['id_user']   = $user['id'];
            $poligami           = new Poligami($this->db);

            $poligami->add($input);

            $find = $poligami->findWithoutDelete('id_user', $user['id']);

            if ($find) {
                $data['status'] = 200;
                $data['message'] = 'Sukses menambah keterangan';
                $data['data'] = $find;
            } else {
                $data['status'] = 500;
                $data['message'] = 'Gagal menambah keterangan';
                $data['data'] = null;
            }
        } else {
            $data['status'] = 400;
            $data['message'] = 'Failed data tidak valid';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function get(Request $request, Response $response, $args)
    {
        $poligami   = new Poligami($this->db);

        $find       = $poligami->findWithoutDelete('id_user', $args['id']);

        if ($find) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $find;
        } else {
            $data['status'] = 404;
            $data['message'] = 'Failed data not found';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response)
    {
        $user       = new User($this->db);
        $poligami   = new Poligami($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);
        $find = $poligami->findWithoutDelete('id_user', $user['id']);

        if ($find) {
            $input              = $request->getParsedBody();

            try {
                $poligami->update($input, 'id_user', $user['id']);

                $find = $poligami->findWithoutDelete('id_user', $user['id']);

                $data['status'] = 200;
                $data['message'] = 'Sukses memperbarui keterangan';
                $data['data'] = $find;
            } catch (Exception $e) {
                $data['status'] = 500;
                $data['message'] = 'Gagal menambah keterangan';
                $data['data'] = null;
            }

        } else {
            $data['status'] = 404;
            $data['message'] = 'Failed data not found';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function delete(Request $request, Response $response)
    {
        $user       = new User($this->db);
        $poligami   = new Poligami($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);
        $find = $poligami->findWithoutDelete('id_user', $user['id']);

        if ($find) {
            $poligami->deleteByColumn('id_user', $user['id']);

            $find = $poligami->findWithoutDelete('id_user', $user['id']);

            if (!$find) {
                $data['status'] = 200;
                $data['message'] = 'Sukses hapus data';
                $data['data'] = null;
            } else {
                $data['status'] = 500;
                $data['message'] = 'Terjadi kesalahan pada penghapusan';
                $data['data'] = null;
            }

        } else {
            $data['status'] = 404;
            $data['message'] = 'Failed data not found';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }
}
