<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Dipoligami;
use \App\Models\User;

class DipoligamiController extends \App\Controllers\BaseController
{
    public function add(Request $request, Response $response)
    {
        $user       = new User($this->db);

        $id = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        $kelamin = $user->getKelamin($id['id']);


        if ($kelamin['jenis_kelamin'] == 'perempuan') {
            $dipoligami = new Dipoligami($this->db);

            $find = $dipoligami->findWithoutDelete('id_user', $id['id']);

            // var_dump($find);
            // die();

            if (!$find) {
                $input = $request->getParsedBody();
                $input['id_user'] = $id['id'];

                $dipoligami->add($input);

                //biar gak error diinisiasi lagi
                $dipoligami = new Dipoligami($this->db);
                $find = $dipoligami->findWithoutDelete('id_user', $id['id']);


                if ($find) {
                    $data['status'] = 200;
                    $data['message'] = 'Sukses menambahkan data';
                    $data['data'] = $find;
                } else {
                    $data['status'] = 500;
                    $data['message'] = 'Gagal memasukkan data';
                    $data['data'] = null;
                }
            } else {
                $data['status'] = 400;
                $data['message'] = 'Failed data sudah ada';
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
        $dipoligami = new Dipoligami($this->db);

        $find = $dipoligami->findWithoutDelete('id_user', $args['id']);

        if ($find) {
            $data['status'] = 200;
            $data['message'] = 'Sukses menambahkan data';
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
        $user = new User($this->db);

        $id = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        if ($id) {
            $dipoligami = new Dipoligami($this->db);

            $find = $dipoligami->findWithoutDelete('id_user', $id['id']);

            if ($find) {
                try {
                    $input = $request->getParsedBody();
                    $dipoligami->update($input, 'id_user', $id['id']);

                    // biar ga error
                    $dipoligami = new Dipoligami($this->db);
                    $find = $dipoligami->findWithoutDelete('id_user', $id['id']);

                    $data['status'] = 200;
                    $data['message'] = 'data berhasil diupdate';
                    $data['data'] = $find;
                } catch (Exception $e) {
                    $data['status'] = 500;
                    $data['message'] = 'Gagal memperbarui data';
                    $data['data'] = null;
                }

            } else {
                $data['status'] = 404;
                $data['message'] = 'Failed data not found';
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
        $user = new User($this->db);

        $user = $user->find('auth_key', $request->getHeaders()['HTTP_AUTHORIZATION'][0]);

        if ($user) {
            $dipoligami = new Dipoligami($this->db);

            $find = $dipoligami->findWithoutDelete('id_user', $user['id']);

            if ($find) {
                $dipoligami->deleteByColumn('id_user', $user['id']);

                $dipoligami = new Dipoligami($this->db);
                $find = $dipoligami->findWithoutDelete('id_user', $user['id']);

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
                $data['message'] = 'Failed data not found';
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
