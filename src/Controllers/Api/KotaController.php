<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class KotaController extends \App\Controllers\BaseController
{

    public function getAll(Request $request, Response $response)
    {
        $Kota = new \App\Models\Kota($this->db);
        $Kota = $Kota->getAll();

        if ($Kota) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $Kota;
        } else {
            $data['status'] = 404;
            $data['message'] = 'Tidak ada data';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function getById(Request $request, Response $response, $args)
    {
        $Kota = new \App\Models\Kota($this->db);
        $Kota = $Kota->findWithoutDelete('id', $args['id']);

        if ($Kota) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $Kota;
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
            $Kota = new \App\Models\Kota($this->db);

            $find = $Kota->findWithoutDelete('nama', $input['nama']);

            if ($find) {
                $data['status'] = 400;
                $data['message'] = 'Nama Kota sudah ada';
                $data['data'] = $find;
            } else {
                $Kota->addKota($input);

                $find = $Kota->findWithoutDelete('nama', $input['nama']);

                if ($find) {
                    $data['status'] = 200;
            		$data['message'] = 'Sukses menambah Kota';
            		$data['data'] = $find;
                } else {
                    $data['status'] = 500;
            		$data['message'] = 'Gagal menambahkan data';
            		$data['data'] = null;
                }
            }

        } else {
            $data['status'] = 400;
    		$data['message'] = 'Nama Kota harus diisi';
    		$data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $Kota = new \App\Models\Kota($this->db);

        $find = $Kota->findWithoutDelete('id', $args['id']);

        if ($find) {
            try {
                $Kota->updateKota($request->getParsedBody(), $args['id']);

                $find = $Kota->findWithoutDelete('id', $args['id']);

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
        $Kota = new \App\Models\Kota($this->db);

        $find = $Kota->findWithoutDelete('id', $args['id']);

        if ($find) {
            $Kota->hardDelete($args['id']);

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
