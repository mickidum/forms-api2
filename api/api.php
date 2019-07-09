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

if ($safe_post['form_name_id']) {
  $form_name_id_file_name = sanitize_file_name($safe_post['form_name_id']);
  $temp_file_name = fopen('temp_file_name.txt', 'w');
  fwrite($temp_file_name, 'form_reg_'.$form_name_id_file_name);

  $form_name_json_file_name = 'form_reg_' . $form_name_id_file_name . '.json';

if (!file_exists("data/" . $form_name_json_file_name)) {
  $exists_json_file = fopen('data/' . $form_name_json_file_name, 'w+');
  $json_encode_file = json_encode($safe_post, JSON_UNESCAPED_UNICODE);
  fwrite($exists_json_file, $json_encode_file);
}
$table_content = fopen('table_content.txt', 'w'); 
$file = fopen('html/form_reg_'.$form_name_id_file_name.'.html', 'a+'); 

$event_name = $safe_post['event_name'] ? $safe_post['event_name'] : $form_name_id_file_name;

$text_content = "";
$list_content = [];
array_push($list_content, 'Id');

foreach ($safe_post as $key => $value) {
  if ($key !== "event_name" and $key !== "form_name_id" and $key !== "g-recaptcha-response") {
    $text_content .= "<td>{$value}</td>";
    array_push($list_content, $key);
  }
}

array_push($list_content, 'date');

// COMPOSE HTML TABLE

if (count(file('html/form_reg_'.$form_name_id_file_name.'.html')) < 1) {
  $html_content_header = '<div class="event-code-name left"><strong>שם טופס</strong><span class="event-code-name-head1">' .$event_name. '</span></div><table><thead><tr>';
  foreach ($list_content as $key => $value) {
    $html_content_header .= "<th>".$value."</th>";
  }
  $html_content_header .= "</tr></thead><tbody>"."\r\n";
  fwrite($file, $html_content_header);
}
$html_content_header = '';
$html_content = "<tr><td>".count(file('html/form_reg_'.$form_name_id_file_name.'.html'))."</td>".$text_content."<td>".date("d-m-Y H:i")."</td></tr>\n";

array_push($list_content, $event_name);

fwrite($table_content, implode(',', $list_content));



// $subject = 'הרשמה חדשה התקבלה מ- '.str_replace('_', ' ', $event_name);

// $message_header = "<table style='direction:rtl; padding:5px 15px;'><tr><th colspan='2'><h2><strong>נרשם חדש לחוגים</strong></h2></th></tr>";
// $message_footer = "</table>";     
// $message = "";


// foreach ($safe_post as $key => $value) {
//   if ($key !== "event_name" and $key !== "form_name_id") {
//     $message .= "<tr><th style='border-top:dotted 1px #000;border-left:dotted 1px #000;'><strong>{$key}</strong></th><td style='border-top:dotted 1px #000;'>{$value}</td>";
//   }
// }

// $message = $message_header.$message.$message_footer;

extract($safe_post);
// ERROR HANDLING EXAMPLE:

if( $firstname && $secondname && $phone && strlen($firstname)>=2 && strlen($phone)>7){

  echo '{"valid": true, "message": "תודה על ההרשמה"}';

  fwrite($file, $html_content_header.$html_content);

  // MAIL SENDING
    $to = 'michael@zur4win.com'; 
    
    $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: sportan-pt-hogim@zur4win.com';
    // mail($to, $subject, $message, $headers);

  }

  else{
  echo '{"valid":false, "message":"יש טעויות בטופס"}'; 
  }




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

?>
