<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';

$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . '/src/dependencies.php';
require __DIR__ . '/src/middleware.php';

$app->post('/xml/{name}', function (Request $request, Response $response, array $args) {
	$clienta = $args['name'];
	/*return $response->withStatus(200)
	->withHeader('Content-Type', 'application/xml')
	->write("");*/
	$sakura=$this->sakura->prepare("select text,menu_items.id from boards
			inner join menus on boards.id=menus.board_id
			inner join menu_items on menus.id=menu_items.menu_id
			where menu_items.type='sql' and alias='$clienta' and menu_items.enabled=1 and menus.position='left'");
	$sakura->execute();
	$buttons=$sakura->fetchAll();
	
	
	$response = $this->response->withHeader( 'Content-type', 'application/xml');
	return $this->view->render($response, 'index.xml', ['buttons'=>$buttons,'clienta'=>$clienta]);

});
$app->post('/data', function (Request $request, Response $response, array $args){
	$sk=Hanni::love($request->getParsedBody(),$this->sakura);
	$response = $this->response->withHeader( 'Content-type', 'application/json');
	$response->getBody()->write(json_encode($sk,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
	return $response;

});
$app->post('/list', function (Request $request, Response $response, array $args){
	$sakura=$this->sakura->prepare("select alias from boards inner join rol_board on boards.id=rol_board.board_id where rol_id=8");
	$sakura->execute();
	$boards=$sakura->fetchAll();
	$response = $this->response->withHeader( 'Content-type', 'application/json');
	$response->getBody()->write(json_encode($boards,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
	return $response;

});
$app->run();
