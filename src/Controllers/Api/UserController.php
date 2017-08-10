<?php

namespace App\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
Use \App\Models\User;


class UserController extends \App\Controllers\BaseController
{
	public function index(Request $request, Response $response)
	{
		$user =new User($this->db);
		$User = $user->getAll();

		$data['status'] = 200;
		$data['message'] = 'Data Available';
		$data['data'] = $User;

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

	public function register(Request $request, Response $response)
	{
// var_dump($request->getUploadedFiles());
// die();
		$rules = [
			'required'	=> [
				['username'],
				['email'],
				['password'],
                // ['foto'],
                // ['foto_ktp'],
            ],
			'alphaNum'	=> [
				['username'],
			],
			'email'	=> [
				['email'],
			],
			'lengthMin'	=> [
				['username', 6],
				['password', 6],
			],
		];

		$this->validator->rules($rules);

		if (!$this->validator->validate()) {
            $uploadedFiles = $request->getUploadedFiles();

            foreach ($uploadedFiles as $key => $val) {
                // if ($val->getError() === UPLOAD_ERR_OK) {
                    $img = new \Upload\File($key, $this->storage );
                    $name = $key . uniqid();
                    $img->setName($name);

                    $img->addValidations([
                        new \Upload\Validation\Mimetype(['image/png', 'image/jpeg',]),
                        new \Upload\Validation\Size('200K')
                    ]);

                    try {
                        $img->upload();
                        $foto[$key] =   $request->getUri()->getBaseUrl() .'/files/imgs/'. $img->getNameWithExtension();
                    } catch (\Exception $e) {
                        $foto[$key] =   $img->getErrors();
                    }







        			// $user =new User($this->db);
                    //
        			// $register = $user->register($data);
                    //
        			// $findUserAfterRegister = $user->findNotDelete('id', $register);
                    //
        			// $data['status'] = 201;
        			// $data['message'] = 'Register Success';
        			// $data['data'] = $findUserAfterRegister;
                // }

            }
            var_dump($foto);die;
		} else {
			$data['status'] = 400;
			$data['message'] = 'Error';
			$data['data'] = $this->validator->errors();
		}

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

	public function update(Request $request, Response $response, $args)
	{
		$user =new User($this->db);
		$findUser = $user->find('id', $args['id']);

		if ($findUser) {
            $rules = [
    			'required'	=> [
    				['username'],
    				['email'],
    				['password'],
                    ['foto'],
                    ['foto_ktp'],
                ],
    			'alphaNum'	=> [
    				['username'],
    			],
    			'email'	=> [
    				['email'],
    			],
    			'lengthMin'	=> [
    				['username', 6],
    				['password', 6],
    			],
    		];

			$this->validator->rules($rules);

			$this->validator->labels([
				'username'			=> 'Username',
				'email'				=> 'Email',
				'password'			=> 'Password',
			]);

			if ($this->validator->validate()) {
				$user->updateUser($request->getParsedBody(), $args['id']);
// $par = var_dump($request->getParsedBody());
				$data['status'] = 201;
				$data['message'] = 'Success Update Data';
				$data['data'] = $findUser;
			} else {
				$data['status'] = 400;
				$data['message'] = 'Error';
				$data['data'] = $this->validator->errors();
			}

		} else {
			$data['status'] = 404;
			$data['message'] = 'Data Not Found';
		}

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

	public function softDelete(Request $request, Response $response, $args)
	{
		$user =new User($this->db);

		$findUser = $user->findNotDelete('id', $args['id']);

		if ($findUser) {
			$user->softDelete($args['id']);

			$data['status'] = 200;
			$data['message'] = 'Delete Success';
		} else {
			$data['status'] = 404;
			$data['message'] = 'Data Not Found';
		}

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

    public function restoreSoftDelete(Request $request, Response $response, $args)
	{
		$user =new User($this->db);

		$findUser = $user->findDeleted('id', $args['id']);

		if ($findUser) {
			$user->restoreSoftDelete($args['id']);

			$data['status'] = 200;
			$data['message'] = 'Restore Success';
		} else {
			$data['status'] = 404;
			$data['message'] = 'Data Not Found';
		}

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

	public function findUser(Request $request, Response $response, $args)
	{
		$User =new User($this->db);
		$findUser = $User->findNotDelete('id', $args['id']);

		if ($findUser) {
			$data['status'] = 200;
			$data['message'] = 'Data Available';
			$data['data'] = $findUser;
		} else {
			$data['status'] = 404;
			$data['message'] = 'Data Not Found';
		}

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

	public function hardDelete(Request $request, Response $response, $args)
	{
		$user =new User($this->db);

		$findUser = $user->find('id', $args['id']);

		if ($findUser) {
			$user->hardDelete($args['id']);

			$data['status'] = 200;
			$data['message'] = 'Data has been delete permanently';
		} else {
			$data['status'] = 404;
			$data['message'] = 'Data Not Found';
		}

		return $response->withHeader('Content-type', 'application/json')->withJson($data, $data['status']);
	}

    public function login (Request $request, Response $response)
    {
        $input = $request->getParsedBody();



        $user =new User($this->db);

        $find = $user->find('username', $input['username']);
        if ($find) {
            if ($user->login($input)) {
                $find = $user->find('username', $input['username']);

                $data['status'] = 200;
                $data['message'] = "sukses login";
                $data['data']   = $find;
            } else {
                $data['status'] = 404;
    			$data['message'] = 'Username atau Sandi Salah';
            }
        } else {
            $data['status'] = 404;
			$data['message'] = 'User tidak terdaftar';
        }
        return $response->withHeader('Content-type','application/json')->withJson($data, $data['status']);
    }

    public function getUserProfile(Request $request, Response $response, $args)
    {
        $user = new User($this->db);

        try {
            $user = $user->getWithProfile($args['id']);

            $data['status'] = 200;
            $data['message'] = 'Berhasil mengambil data';
            $data['data'] = $user;
        } catch (Exception $e) {
            $data['status'] = 404;
            $data['message'] = 'Username atau Sandi Salah';
            $data['data'] = null;
        }
        return $response->withHeader('Content-type','application/json')->withJson($data, $data['status']);
    }

    public function getKelamin(Request $request, Response $response)
    {
        $user = new User ($this->db);


    }
}
