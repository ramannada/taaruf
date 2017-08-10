<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class ProvinsiController extends \App\Controllers\BaseController
{

    public function getAll(Request $request, Response $response)
    {
        $Provinsi = new \App\Models\Provinsi($this->db);
        $Provinsi = $Provinsi->getAll();

        if ($Provinsi) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $Provinsi;
        } else {
            $data['status'] = 404;
            $data['message'] = 'Tidak ada data';
            $data['data'] = null;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function getById(Request $request, Response $response, $args)
    {
        $Provinsi = new \App\Models\Provinsi($this->db);
        $Provinsi = $Provinsi->findWithoutDelete('id', $args['id']);

        if ($Provinsi) {
            $data['status'] = 200;
            $data['message'] = 'Sukses mengambil data';
            $data['data'] = $Provinsi;
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
            $Provinsi = new \App\Models\Provinsi($this->db);

            $find = $Provinsi->findWithoutDelete('nama', $input['nama']);

            if ($find) {
                $data['status'] = 400;
                $data['message'] = 'Nama Provinsi sudah ada';
                $data['data'] = $find;
            } else {
                $Provinsi->addProvinsi($input);

                $find = $Provinsi->findWithoutDelete('nama', $input['nama']);

                if ($find) {
                    $data['status'] = 200;
            		$data['message'] = 'Sukses menambah Provinsi';
            		$data['data'] = $find;
                } else {
                    $data['status'] = 500;
            		$data['message'] = 'Gagal menambahkan data';
            		$data['data'] = null;
                }
            }

        } else {
            $data['status'] = 400;
    		$data['message'] = 'Nama Provinsi harus diisi';
    		$data['data'] = null;
        }
        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $Provinsi = new \App\Models\Provinsi($this->db);

        $find = $Provinsi->findWithoutDelete('id', $args['id']);

        if ($find) {
            try {
                $Provinsi->updateProvinsi($request->getParsedBody(), $args['id']);

                $find = $Provinsi->findWithoutDelete('id', $args['id']);

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
        $Provinsi = new \App\Models\Provinsi($this->db);

        $find = $Provinsi->findWithoutDelete('id', $args['id']);

        if ($find) {
            $Provinsi->hardDelete($args['id']);

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
