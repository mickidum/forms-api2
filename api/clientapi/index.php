<?php

// CORS uncoment below if you need 'cors support'
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
// header('Content-Type: application/json; charset=utf-8');

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

session_start();

$app = new \Slim\App;

// $app->add(function ($request, $response, $next) {
// 	if (empty($_SESSION['logged'])) {
// 		$response = $response->withJson([
// 			'error' => 403,
// 			'message' => 'not authorized'
// 		]);
// 	} else {
// 		$response = $next($request, $response);
// 	}
// 	return $response;
// });

$app->get('/getlist', function (Request $request, Response $response, array $args) {
	if (file_exists('../settings/form-list.json')) {
		$data = file_get_contents('../settings/form-list.json');
		$data = json_decode($data, true);
		$response = $response->withJson($data, 201, JSON_UNESCAPED_UNICODE);
  }

  return $response;
});

$app->get('/getform/{form}', function (Request $request, Response $response, array $args) {
	$name = $args['form'];
	if (file_exists('../data/form_reg_' . $name . '.json')) {
    $data = file_get_contents('../data/form_reg_' . $name . '.json');
    $data = json_decode($data, true);
		$response = $response->withJson($data, 201, JSON_UNESCAPED_UNICODE);
  }

  return $response;
});

$app->run();