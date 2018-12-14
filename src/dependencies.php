<?php

$container = $app->getContainer();

$container['logger'] = function ($c) {
	$settings = $c->get('settings')['logger'];
	$logger = new Monolog\Logger($settings['name']);
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	return $logger;
};
$container['sakura'] = function ($c) {
	$db = $c->get('settings')['sakura'];
	$pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'] . ";charset=" . $db['charset'] . ";port=" . $db['port'],$db['user'], $db['pass'],[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};
$container['view'] = function ($c) {
	$settings = $c->get('settings')['renderer'];
	$view = new \Slim\Views\Twig($settings['template_path']);
	$router = $c->get('router');
	$uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
	$view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
	return $view;
};
$container['errorHandler'] = function ($c) {
	return function ($request, $response, $exception) use ($c) {
		return $response->withStatus(500)
			->withHeader('Content-Type', 'application/json')
			->write(json_encode(['message'=>'no autorizado','error'=>'n_n'],JSON_PRETTY_PRINT));
	};
};
