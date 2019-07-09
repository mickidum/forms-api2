<?php
  if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
      header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
      die( header( 'location: /error.php' ) );
  }
?>

<?php
// CORS uncoment below if you need 'cors support'
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
// header('Access-Control-Allow-Headers: X-Requested-With, content-type, Authorization, Content-Type');
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
// header('Content-Type: application/json; charset=utf-8');


if($_POST) {

$safe_post = array_map('test_input', $_POST);
// $json = json_encode($_POST, JSON_UNESCAPED_UNICODE);

// echo $json;
// var_dump($safe_post);
// exit();

$default_settings_array = [
  'items_names' => [],
  'validation' => [
    'validate' => false,
    'validate_items' => [],
    'messages' => [
      'success' => 'Thank you for subscribing',
      'error' => 'There Error while validating'
    ]
  ],
  'mail' => [
    'send' => false,
    'to' => 'usermail@example.com',
    'subject' => 'New message from ',
    'message_header' => 'New Subscriber Added'
  ]
];

if ($safe_post['form_name_id']) {

  $items = [];
  $items_names = [];

  $items_names[] = 'ID';
  $items['item_id'] = uniqid();

  foreach ($safe_post as $key => $value) {
    if ($key !== "form_name" and $key !== "form_name_id" and $key !== "g-recaptcha-response") {
      $items_names[] = $key;
      $items[$key] = $value;
    }
  }

  $items_names[] = 'Date';
  $items['date'] = date("d-m-Y H:i");

  // var_dump($items);

  // FORM ID
  $form_name_id = sanitize_file_name($safe_post['form_name_id']);
  // FORM READABLE NAME
  $form_name = $safe_post['form_name'] ? $safe_post['form_name'] : $form_name_id;
  // JSON FILE NAME
  $form_json_file_name = 'form_reg_' . $form_name_id . '.json';

  if (!file_exists('data/' . $form_json_file_name)) {

    $json_file = fopen('data/' . $form_json_file_name, 'w');
    $default_settings_array['items_names'] = $items_names;
    
    $json_file_array = [
      'form_id' => $form_name_id,
      'form_name' => $form_name,
      'settings' => $default_settings_array,
      'items' => [
        $items
      ]
    ];
    $json_encode_file = json_encode($json_file_array, JSON_UNESCAPED_UNICODE);

    fwrite($json_file, $json_encode_file);
    fclose($json_file);
    // var_dump($json_file_array);
    // echo $json_encode_file;
    // exit();

  } else {

    $json_file_array = file_get_contents('data/' . $form_json_file_name);
    
    $temp_array = json_decode($json_file_array, true);
    array_push($temp_array['items'], $items);

    $validation = $temp_array['settings']['validation'] ? $temp_array['settings']['validation'] : $default_settings_array['validation'];

    if ($validation['validate'] && count($validation['validate_items'])) {
      validations($validation, $items);
    }

    $json_encode_file = json_encode($temp_array, JSON_UNESCAPED_UNICODE);

    $json_file = fopen('data/' . $form_json_file_name, 'w');
    fwrite($json_file, $json_encode_file);
    fclose($json_file);
  }

  
  // MAIL SENDING (OPTIONAL)
  $mail_sending = $temp_array['settings']['mail'] ? $temp_array['settings']['mail'] : $default_settings_array['mail'];

  // COMPOSE HTML TABLE

// $subject = 'הרשמה חדשה התקבלה מ- '.str_replace('_', ' ', $form_name);

// $message_header = "<table style='direction:rtl; padding:5px 15px;'><tr><th colspan='2'><h2><strong>נרשם חדש לחוגים</strong></h2></th></tr>";
// $message_footer = "</table>";     
// $message = "";


// foreach ($safe_post as $key => $value) {
//   if ($key !== "form_name" and $key !== "form_name_id") {
//     $message .= "<tr><th style='border-top:dotted 1px #000;border-left:dotted 1px #000;'><strong>{$key}</strong></th><td style='border-top:dotted 1px #000;'>{$value}</td>";
//   }
// }

// $message = $message_header.$message.$message_footer;

// ERROR HANDLING EXAMPLE:

// if( $firstname && $secondname && $phone && strlen($firstname)>=2 && strlen($phone)>7){

//   echo '{"valid": true, "message": "תודה על ההרשמה"}';

//   fwrite($file, $html_content_header.$html_content);

//   // MAIL SENDING
//     $to = 'michael@zur4win.com'; 
    
//     $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
//     $headers .= 'From: sportan-pt-hogim@zur4win.com';
//     // mail($to, $subject, $message, $headers);

//   }

//   else{
//   echo '{"valid":false, "message":"יש טעויות בטופס"}'; 
//   }




}
}

// HELPERS

function test_input($data) {
  if (is_array($data)) {
    $data = array_map('test_input', $data);
    return $data;
  }
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace(array("\r", "\n"), '', $data);
  return $data;
}

function sanitize_file_name( $filename ) {
  $filename = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $filename);
  return $filename;
}

function validations($validation, $items) {
  $validate_items_error = [];

  foreach ($validation['validate_items'] as $v_item) {
    
    foreach ($items as $key => $value) {

      if (($v_item == $key && !$value)) {
        $validate_items_error[] = $v_item;
      }

    }

  }

  if (count($validate_items_error)) {
    $validation_object = [
      'success' => false,
      'message' => $validation['messages']['error'],
      'items' => $validate_items_error
    ];
    echo json_encode($validation_object);
    exit();

  } else {

    $validation_object = [
      'success' => true,
      'message' => $validation['messages']['success']
    ];
    echo json_encode($validation_object);

  }
}

?>
