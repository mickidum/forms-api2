<?php

// CORS uncoment below if you need 'cors support'
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
// header('Content-Type: application/json; charset=utf-8');


header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');


// FORMS LIST
if (!empty($_GET['get_forms'])) {
	if (file_exists('settings/form-list.json')) {
		header('Content-Type: application/json; charset=utf-8');
    echo json_encode(file_get_contents('settings/form-list.json'));
  }
  exit;
}

if (!empty($_GET['get_form'])) {
	if (file_exists('data/form_reg_' . $_GET["get_form"] . '.json')) {
		header('Content-Type: application/json; charset=utf-8');
    echo json_encode(file_get_contents('data/form_reg_' . $_GET["get_form"] . '.json'));
  }
  exit;
}