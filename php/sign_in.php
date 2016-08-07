<?php 

session_start();

include("connection.php");
	
if ($_GET["logout"]==1 AND $_SESSION['id']) { 
	session_destroy();
	setcookie('rememberme', 0, time() - (86400 * 60), "/"); 	
	echo "You have been logged out. Have a nice day!";
	header("Location: ".$login);
		
} elseif ($_GET["logout"]==1) {
	$referer  = $_SERVER['HTTP_REFERER'];  


	if (isset($_COOKIE['rememberme'])) {
	$cookie_value = $_COOKIE['rememberme'];
	$selector= substr($cookie_value, 0, 12);
	$validator = substr($cookie_value, 24,64);
	echo($selector . ' and ' . $validator . ' ');
		$idquery = "SELECT * FROM `users` WHERE `user_id` =  (SELECT `userid` FROM `auth_tokens` WHERE `selector` = '$selector' AND `token` = '$validator' AND `expires` > now()
	      	LIMIT 1) LIMIT 1";
      	$result = mysqli_query($link, $idquery);
	   	$row = mysqli_fetch_array($result);
	   if ($row){
			$query = "UPDATE `users` SET last_edit_date='$date'";
			mysqli_query($link, $query);
			$_SESSION['id']=$row['user_id'];
				
			if ($referer == $mainpage) {
					
					echo ('<div class="alert alert-success alert-dismissible " role="alert">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          		<strong>Welcome back ' .$row['name'] . '</strong></div>');
          		header("Location: ".$mainpage);
				}
				else {header("Location: ".$mainpage);}
    	} else {
		echo "User in cookie not found";
			//header("Location: ".$login);} */
		}
	} else {header("Location: ".$login);}
}


if ($_SERVER['REQUEST_METHOD']== "POST") {
	$cookie_request = $_POST['setCookie'];
   
	function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
	} 
	
	function generateToken($length)
	{	
		echo 'Current PHP version: ' . phpversion();
		return bin2hex(openssl_random_pseudo_bytes($length));
	}

	$email = $_POST['loginemail'];
	$password = $_POST['loginpwhash'];
	date_default_timezone_set('America/Chicago');
	$offset = date_offset_get(new DateTime)/3600;
	//echo $offset;
	$email = strtolower($email);
	// returns pos/neg decimal (eg. -7 if in PST and DST is active.)
	// remember there are time zones with 30 and 45 min offsets
	// http://en.wikipedia.org/wiki/Time_zone

	$error="";
	$server = $_SERVER['SERVER_NAME'];
	$mysite = $domain;
	$referer  = $_SERVER['HTTP_REFERER'];  
	$mypage = $login;
	//echo  nl2br("\r\nServer: " . $server . " \r\nMy Site: " . $mysite . " \r\nReferer: " . $referer."\r\n");
if (!in_array($server, $domain_array)) {
      $error = "No XSS allowed";
} elseif  (!in_array($referer, $login_array)) {
      $error = "No XSS allowed";
   } else {

		$sql = "SELECT * FROM `users` WHERE `email` ='".mysqli_real_escape_string($link, $email)."' AND `password` = '".mysqli_real_escape_string($link, $password)."' LIMIT 1";
					$result = mysqli_query($link, $sql);
					$row = mysqli_fetch_array($result);
		if ($row){
					$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));
					$query = "UPDATE `users` SET last_edit_date='$date'";
					mysqli_query($link, $query);

					echo ('<div class="alert alert-success alert-dismissible " role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Login succesful on: ' . $date . '</strong></div>');

				
			$_SESSION['id']=$row['user_id'];
			if (isset($cookie_request)) {
				$cookie_name = "rememberme";
				$userid = $_SESSION['id'];
				$selector = generateToken(12);
				$validator = generateToken(64);
				$cookie_value = $selector . $validator;
				$expiration = time() + (86400 * 60);
				$expiration_date = date('Y-m-d H:i:s', $expiration);
				$query = "INSERT INTO `auth_tokens` (`selector`,`token`,`userid`,`expires`) VALUES('$selector','$validator','$userid','$expiration_date');";
				mysqli_query($link, $query);
				setcookie($cookie_name, $cookie_value, $expiration, "/"); // 86400 = 1 day		
			}			
			
			//echo nl2br("\r\n" . $email . "\r\n" . $password . "\r\n" . $_SESSION['id']);
			
			header("Location: " . $mainpage);   //Redirect to logged in page
			exit;
			} else {$error = "Login incorrect.  Please try again, or create a new login instead.";}
	}
}
if ($error !="") {
echo('<div class="alert alert-success alert-dismissible " role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Error: ' . $error . '</strong></div>');
		//header("Location: " . $badlogin);
		//exit;
}
?>

