

<?php 

session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD']== "POST") {
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   } 
   $email = $_POST['email'];
   $email = strtolower($email);
   $password = $_POST['pwhash'];
   $cookie_request = $_POST['setFirstCookie'];
   date_default_timezone_set('America/Chicago');
   $offset = date_offset_get(new DateTime)/3600;
   //echo $offset;
   // returns pos/neg decimal (eg. -7 if in PST and DST is active.)
   // remember there are time zones with 30 and 45 min offsets
   // http://en.wikipedia.org/wiki/Time_zone

   $error="";
   $server = $_SERVER['SERVER_NAME'];
   $referer  = $_SERVER['HTTP_REFERER'];  
   //echo  nl2br("\r\nServer: " . $server . " \r\nReferer: " . $referer."\r\n");
if (!in_array($server, $domain_array)) {
      $error = "No XSS allowed";
} elseif  (!in_array($referer, $login_array)) {
      $error = "No XSS allowed";
   } else {

   	$sql = "SELECT * FROM `users` WHERE `email` ='".mysqli_real_escape_string($link, $email)."' LIMIT 1";
        	$result = mysqli_query($link, $sql);
	        $results = mysqli_num_rows($result);
	   if ($results==0){
	   	if ($error==""){
			/*$email = $_POST['email'];
			$password = $_POST['pwhash'];*/
 		   $name = test_input($_POST['yourName']);
			$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));
	  	 	$query = "INSERT INTO `users` (`email`,`password`,`name`,`create_date`) VALUES('$email','$password','$name','$date');";
			mysqli_query($link, $query);
			//echo nl2br ("\r\nLogin for " . $name . " created on " . $date);
			
			$_SESSION['id']=mysqli_insert_id($link);
			$newid = $_SESSION['id'];
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
					$body = "New account created for user ".$name." on " .$date.".\n";
			$body .= "\n"."New user ID is " .$newid.".";
			if($cookie_request ==true) {$body .= "\n"."Cookie set.";}
			$headers = "From: mr@popuhler.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();
			$subject = "New User Account Created";
			
			echo nl2br("\r\n".$newid."\r\n");
			echo nl2br("\r\n".$body . "\r\n");
			echo nl2br("\r\n".$headers . "\r\n");
			mail("mr@popuhler.com", $subject, $body, $headers);
			
			for($i=1;$i<25;$i++){
			$sql = "INSERT INTO `user_categories`(`user_id`, `category_id`, `order`, `hide`, `date_created`) VALUES ('$newid','$i','$i','0','$date');";
			mysqli_query($link, $sql);}
			header("Location: " . $startpage);
			exit;
   		}
	   } else {
   		$error = "Login already exists.  Please sign-in above instead.";
   
	   }
   }
}
if ($error !="") {
echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error: ' . $error . '</strong></div>');
			header("Location: " . $existing_user);
}
?>
