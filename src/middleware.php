<?php

$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
	"secure" => true,
	"users" => [
		"root" => "toor"
	],
	"error" => function ($request, $response, $arguments) {
		$data = [];
		$data["status"] = "error";
		$data["message"] = $arguments["message"];
		return $response->write(json_encode(['message'=>'no autorizado','error'=>'n_n'],JSON_PRETTY_PRINT));
		return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
	}
]));
