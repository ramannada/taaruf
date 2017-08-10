<?php

return [
	//setting display error
	'displayErrorDetails'	=> true,

	'addContentLengthHeader' => false,

	//setting timezone
	'timezone'	=> 'Asia/Jakarta',

	//setting language
	'lang'	=> [
		'default'	=> 'en',
	],

	//setting db (with doctrine)
	'db'	=> [
		'url'	=> 'mysql://root:toor@127.0.0.1/taaruf',
	],

	'determineRouteBeforeAppMiddleware' => true,

	//setting language
	'lang'	=> [
		'default'	=> 'en',
	],

    'view'	=> [
		'path'	=> __DIR__. '/../views',
		'twig'	=> [
			'cache'	=> false,
			],
	],

	'mailer'	=> [
		'smtp_auth' 	=> true,
		'smtp_secure'	=> 'tls',
		'host'			=> 'smtp.gmail.com',
		'username'		=> 'mit3.labib@gmail.com',
		'password'		=> '37163145',
		'port'			=> 587,
		'html'			=> true,
		'name'			=> 'labib',
	],

	'guzzle'	=> [
		'base_uri' => 'http://127.0.0.1/taarufslim/public/',
		'headers'  => [
			'Authorization'	=> $_SESSION['login']['meta']['token']['token'],
		],
	],
    "filesystem" => "/../public/files/imgs",

];
