<?php
session_start();
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   } 
$pattern = '/\r|\n|bcc:|content-type|href|to:|cc:/i';
$user = $_SESSION['id'];
$emailTo="mr@popuhler.com";
$subject=$_POST['subject'];
$feedback = $_POST['feedback_text'];
$feedback = test_input($feedback);
if (preg_match($pattern, $subject)){echo '<div class="alert alert-danger alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Email injection not allowed through this form</strong></div>';
          die('Unable to verify subject');} 
if (preg_match($pattern, $feedback)){echo '<div class="alert alert-danger alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Email injection not allowed through this form</strong></div>';
          die('Unable to verify feedback');}           
$reply = $_POST['replyemail'];
if (!filter_var($reply, FILTER_VALIDATE_EMAIL)===false) {
  $headers .= "Reply-to: $reply\r\n";
  $body.= "Reply Email: $reply\r\n";
} else {die('email did not validate');}
$body.="Feedback: \r\n";
$body.= $feedback."\r\n\r\n";
$body.= "User ID: " .$user."\r\n";
$headers.="From: mr@popuhler.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();
if ($_POST['send_feedback']){
		mail($emailTo, $subject, $body, $headers);
		echo '<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Feedback submitted</strong></div>';
	} else {
		echo '<div class="alert alert-danger alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Something went wrong</strong></div>';
          die('Something went wrong');
	}
      
?>