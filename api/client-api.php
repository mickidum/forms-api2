<?php

// CORS uncoment below if you need 'cors support'
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, content-type, Authorization, Content-Type');
header('Content-Type: application/json; charset=utf-8');


header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
$htmlfiles = array_diff(scandir('data', 1), array('.', '..', 'index.html')); 
$rawData = json_decode(file_get_contents("php://input"), true);
// echo json_encode($rawData);

if ($rawData['get_forms']) {
  echo json_encode($htmlfiles);
  exit;
}