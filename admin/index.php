<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create('../');
$dotenv->load();

$app = new Slim\App;

$container = $app->getContainer();

$container["jwt"] = function ($container) {
    return new StdClass;
};

$app->add(new Tuupola\Middleware\JwtAuthentication([
		"attribute" => "jwt",
    "secure" => getenv('SECURE'),
    "secret" => getenv('JWT_SECRET'),
    "ignore" => ["/token", "/"],
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response->withJson($data, 401);
    }
]));

$app->post('/token', function (Request $request, Response $response, array $args) {

		$body = $request->getParsedBody();

		$login = $body['login'];
		$password = hash('sha256', $body['password']);

		if (!empty($login) and !empty($password)) {

			if ($login === getenv('LOGIN') and $password === getenv('PASSWORD')) {

				$now = new DateTime();
		    $future = new DateTime("now +2 hours");
		    $server = $request->getServerParams();

		    $payload = [
		        "iat" => $now->getTimeStamp(),
		        "exp" => $future->getTimeStamp(),
		        "login" => $login,
		        "password" => $password
		    ];

		    $secret = getenv("JWT_SECRET");

		    $token = JWT::encode($payload, $secret, "HS256");
		    $data["token"] = $token;
		    $data["expires"] = $future->getTimeStamp();

		  	$response = $response->withJson($data, 201);
			} else {
				$response = $response->withJson(["status" => "error", "message" => "Authorization required..."], 401);
			}

  	}
  	return $response;
});

$app->get('/mic', function (Request $request, Response $response, array $args) {
	return $response->withJson(['test' => 'ok'], 201);
});

$app->run();