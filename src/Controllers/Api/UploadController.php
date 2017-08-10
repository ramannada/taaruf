<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UploadController extends \App\Controllers\BaseController
{
    protected function upload (Request $request, Response $response)
    {

        $img    = file_get_contents('php://input');
        $nama   = md5(date("Y-m-d H:i:s")) . ".jpg";
        $upload = $this->flysystem->write('imgs/'. $nama, $img);
        if ($upload) {
            $data['status'] = 200;
    		$data['message'] = 'Success uploaded';
    		$data['data'] = $request->getUri()->getBasePath() . '/files/imgs' . $nama;
        }

        return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
    }

    protected function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); 
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
