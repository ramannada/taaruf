<?php

use Slim\Container;
use Slim\Views\Twig as View;
use Slim\Views\TwigExtension as ViewExt;
use RandomLib\Factory as Random;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Zend\Mail;


$container = $app->getContainer();

$container['db'] = function (Container $container) {
	$setting = $container->get('settings');

	$config = new \Doctrine\DBAL\Configuration();

	$connect = \Doctrine\DBAL\DriverManager::getConnection($setting['db'],
		$config);

	return $connect;
};

$container['view'] = function (Container $container) {
	$setting = $container->get('settings')['view'];

	$view = new View($setting['path'], $setting['twig']);
	$view->addExtension(new ViewExt($container->router, $container->request->getUri()));

	$view->getEnvironment()->addGlobal('flash', $container->flash);

	$view->getEnvironment()->addGlobal('baseUrl', 'http://localhost/taarufslim/public');

	if (isset($_SESSION['login'])) {
        $view->getEnvironment()->addGlobal('login', $_SESSION['login']);
    }

    if (isset($_SESSION['errors'])) {
        $view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

        unset($_SESSION['errors']);
    }

    if ($_SESSION['old']) {
		$view->getEnvironment()->addGlobal('old', $_SESSION['old']);

		unset($_SESSION['old']);
	}

	return $view;
};

$container['validator'] = function (Container $container) {
	$setting = $container->get('settings')['lang']['default'];
	$params = $container['request']->getParams();

	return new Valitron\Validator($params, [], $setting);
};

$container['flash'] = function (Container $container) {
	return new \Slim\Flash\Messages;
};

$container['csrf'] = function (Container $container) {
	return new \Slim\Csrf\Guard;
};

$container['mailer'] = function (Container $container) {
	$settings = $container->get('settings')['mailer'];

	$mailer = new \PHPMailer;
	$mailer->isSMTP();
	$mailer->Host = $settings['host'];
	$mailer->Port = $settings['port'];
	$mailer->SMTPSecure = $settings['smtp_secure'];
	$mailer->SMTPAuth = $settings['smtp_auth'];
	$mailer->Username = $settings['username'];
	$mailer->Password = $settings['password'];

	$mailer->setFrom($settings['username'], $settings['name']);

	return new \App\Extensions\Mailers\Mailer($container['view'], $mailer);
};

$container['random'] = function (Container $container) {
	$random = new Random;
	return $random->getMediumStrengthGenerator();
};

$container['client'] = function (Container $container) {
	$setting = $container->get('settings')['guzzle'];
	return new Client(['base_uri' => $setting['base_uri'], 'headers' => $setting['headers']]);
};

$container['storage'] = function (Container $container) {
    $setting   = __DIR__ . $container->get('settings')['filesystem'];
    return new \Upload\Storage\FileSystem($setting);
};
