<?php 
if (!file_exists('.env')) {
	echo "Exists";
}
elseif(isset($_POST['submit'])){
	
	if (!empty($_POST['login']) and !empty($_POST['password']) and strlen($_POST['password']) > 4) {
		
	}
	$login = $_POST['login']; 
  $password = hash('sha256', $_POST['password']); 
  $key = hash('sha256', time());

  $create_env_string = 'JWT_SECRET='. $key . "\r\n";
  $create_env_string .= 'SECURE=false' . "\r\n";
  $create_env_string .= 'LOGIN='. $login . "\r\n";
  $create_env_string .= 'PASSWORD='. $password . "\r\n";

 	$env = fopen('.env', 'w');
 	fwrite($env, $create_env_string);
 	fclose($env);
	// echo $create_env_string;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register System Welcome</title>
	<link rel="stylesheet" href="api/styles/foundation.css">
	<style>
		.all-wrap {
			position: relative;
	    width: 100%;
	    height: 100vh;
		}
		.all-wrap-inner {
			position: absolute;
			width: 100%;
			max-width: 350px;
			border: solid 1px silver;
	    padding: 30px 15px 0;
	    top: 50%;
	    left: 50%;
	    transform: translate(-50%, -50%);
		}
		h1 {
			font-size: 24px;
			font-weight: bold;
			text-align: center;
			margin-bottom: 40px;
		}
	</style>
</head>
<body>


	<div class="all-wrap">
		
		<div class="all-wrap-inner">
			<h1>Create New User</h1>
			<form id="login" method="post"  autocomplete="off"> 
			    <label>User Name
				    <input type="text" name="login">
				  </label>
			    <label>Password
				    <input type="password" name="password"  autocomplete="new-password">
				  </label>
			    <p><button class="button expanded warning" type="submit" name="submit">Login</button></p>
			</form>
		</div>
	</div>
</body>
</html>