<?php 
if (!file_exists('.env')) {
	echo "Exists";
}
elseif(isset($_POST['submit'])){
	
	if (!empty($_POST['login']) and !empty($_POST['password']) and strlen($_POST['password']) > 4 and strlen($_POST['login']) > 2) {
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
	} else {
		echo '<div class="error">Error, Password must be minimum 5 symbols<br>Login minimum 3 symbols</div>';
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create New User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="css/foundation.css">
	<style>
		.error {
			position: absolute;
	    text-align: center;
	    width: 100%;
	    left: 0;
	    top: 0;
	    padding: 5px;
	    color: red;
	    background: black;
	    font-weight: bold;
		}
		.all-wrap {
			position: relative;
			display: -webkit-flex;
			display: -moz-flex;
			display: -ms-flex;
			display: -o-flex;
			display: flex;
			-ms-align-items: center;
			align-items: center;
			justify-content: center;
	    width: 100%;
	    height: 100vh;
	    padding: 0 15px;
		}
		.all-wrap-inner {
			width: 100%;
			max-width: 600px;
			border: solid 1px silver;
	    padding: 30px 24px;
		}
		input {
			height: 50px !important;
			font-size: 24px !important;
			font-weight: normal;
			box-shadow: none !important;
		}
		h1 {
			font-size: 36px;
			font-weight: bold;
			text-align: center;
			margin-bottom: 40px;
		}
		label {
			font-size: 18px;
		}


	</style>
</head>
<body>


	<div class="all-wrap">
		
		<div class="all-wrap-inner">
			<h1>Create Admin Account</h1>
			<form id="login" method="post"  autocomplete="off"> 
			    <p>
			    	<label>LOGIN <small>(*minimum 3 symbols)</small>
					    <input type="text" name="login">
					  </label>
			    </p>
			    <p>
			    	<label>PASSWORD <small>(*minimum 5 symbols)</small>	
					    <input type="password" name="password"  autocomplete="new-password">
					  </label>
			    </p>
			    <br>
			    <p><button class="button large expanded warning" type="submit" name="submit">CREATE ADMIN</button></p>
			</form>
		</div>
	</div>
</body>
</html>