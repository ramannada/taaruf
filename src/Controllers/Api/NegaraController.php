<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class NegaraController extends \App\Controllers\BaseController
{

    public function getAll(Request $request, Response $response)
    {
        $negara = new \App\Models\Negara($this->db);
        $negara = $negara->getAll();

        if ($negara) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $negara;
        } else {
            $data['status'] = 404;
            $data['message'] = 'Tidak ada data';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function getById(Request $request, Response $response, $args)
    {
        $negara = new \App\Models\Negara($this->db);
        $negara = $negara->findWithoutDelete('id', $args['id']);

        if ($negara) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $negara;
        } else {
            $data['status'] = 404;
            $data['message'] = 'Tidak ada data';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function add(Request $request, Response $response)
    {
        $input  = $request->getParsedBody();


        if ($input['nama']) {
            $negara = new \App\Models\Negara($this->db);

            $find = $negara->findWithoutDelete('nama', $input['nama']);

            if ($find) {
                $data['status'] = 400;
                $data['message'] = 'Nama negara sudah ada';
                $data['data'] = $find;
            } else {
                $negara->addNegara($input);

                $find = $negara->findWithoutDelete('nama', $input['nama']);

                if ($find) {
                    $data['status'] = 200;
            		$data['message'] = 'Sukses menambah negara';
            		$data['data'] = $find;
                } else {
                    $data['status'] = 500;
            		$data['message'] = 'Gagal menambahkan data';
            		$data['data'] = null;
                }
            }

        } else {
            $data['status'] = 400;
    		$data['message'] = 'Nama negara harus diisi';
    		$data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $negara = new \App\Models\Negara($this->db);

        $find = $negara->findWithoutDelete('id', $args['id']);

        if ($find) {
            try {
                $negara->updateNegara($request->getParsedBody(), $args['id']);

                $find = $negara->findWithoutDelete('id', $args['id']);

                $data['status'] = 200;
        		$data['message'] = 'Sukses update';
        		$data['data'] = $find;
            } catch (Exception $e) {
                $data['status'] = 500;
        		$data['message'] = $e->getMessage();
        		$data['data'] = null;
            }

        } else {
            $data['status'] = 404;
            $data['message'] = "Data tidak ditemukan";
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);

    }

    public function delete (Request $request, Response $response, $args)
    {
        $negara = new \App\Models\Negara($this->db);

        $find = $negara->findWithoutDelete('id', $args['id']);

        if ($find) {
            $negara->hardDelete($args['id']);

            $data['status'] = 200;
            $data['message'] = "Sukses hapus data";
            $data['data'] = null;
        } else {
            $data['status'] = 404;
            $data['message'] = "Data tidak ditemukan";
            $data['data'] = null;
        }
        return $response->withHeader('Content-type','application/json')->withJson($data, $data['status']);
    }
}
