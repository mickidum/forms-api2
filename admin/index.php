<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create('../');
$dotenv->load();

$app = new Slim\App;

// CORS
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app->add(new Tuupola\Middleware\JwtAuthentication([
    "secure" => getenv('SECURE'),
    "secret" => getenv('JWT_SECRET'),
    "ignore" => ["/token"],
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response->withJson($data, 401);
    }
]));

$app->post('/token', function (Request $request, Response $response, array $args) {

		$body = $request->getParsedBody();

		$login = $body['username'];
		$password = hash('sha256', $body['password']);

		if (!empty($login) and !empty($password)) {

			if ($login === getenv('LOGIN') and $password === getenv('PASSWORD')) {

				$now = new DateTime();
		    $future = new DateTime("now +2 hours");
		    // $future = new DateTime("now +10 seconds");
		    $server = $request->getServerParams();

		    $payload = [
		        "iat" => $now->getTimeStamp(),
		        "exp" => $future->getTimeStamp(),
		        "login" => $login,
		        "password" => $password
		    ];

		    $secret = getenv("JWT_SECRET");

		    $token = JWT::encode($payload, $secret, "HS256");
		    $data["user"] = ["name" => $login];
		    $data["token"] = $token;
		    // $data["auth"] = ["token" => $token, "expires" => $future->getTimeStamp()];
		    $data["expires"] = $future->getTimeStamp();

		  	$response = $response->withJson($data, 201);
			} else {
				$response = $response->withJson(["status" => "error", "message" => "Authorization required..."], 401);
			}

  	}
  	return $response;
});

$app->get('/ping', function (Request $request, Response $response, array $args) {
	return $response->withJson(['status' => 'pong'], 200);
});

$app->get('/getlist', function (Request $request, Response $response, array $args) {
	if (file_exists('../api/settings/form-list.json')) {
		$data = file_get_contents('../api/settings/form-list.json');
		$data = json_decode($data, true);
		$response = $response->withJson($data, 200, JSON_UNESCAPED_UNICODE);
  }

  return $response;
});

$app->get('/getform/{form}', function (Request $request, Response $response, array $args) {
	$name = $args['form'];
	if (file_exists('../api/data/form_reg_' . $name . '.json')) {
    $data = file_get_contents('../api/data/form_reg_' . $name . '.json');
    $data = json_decode($data, true);
		$response = $response->withJson($data, 200, JSON_UNESCAPED_UNICODE);
  }

  return $response;
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

$app->run();