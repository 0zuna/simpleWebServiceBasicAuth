<?php
	return [
		'settings'=>[
			'displayErrorDetails' => false,
			'addContentLengthHeader' => false,
			/*'logger' => [
				'name' => 'slim-app',
				'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
				'level' => \Monolog\Logger::DEBUG,
			],*/
			//db
			'sakura'=>[
				'host'=> "192.168.3.154",
				'user'=> "root",
				'pass'=> "toor",
				'dbname'=> "monitoreoGa",
				'charset'=> "utf8",
				'port'=> "3306"
			],
			'renderer' => [
				'template_path' => __DIR__ . '/../templates/',
			],

		],
	];
