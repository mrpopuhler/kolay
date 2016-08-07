<?php 

include("connection.php");

if ($_SERVER['REQUEST_METHOD']== "POST") {
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   } 
   
function cleanData($a) {

    if(preg_match("/^[$0-9,.]+$/", $a)) 
	    {
    	$a = str_replace(',', '', $a);
    	$a = str_replace('$', '', $a);
		}
     return $a;
} 

$amt = cleanData($_POST['amount']);
/*echo ('<div class="alert alert-success alert-dismissible " role="alert">
          	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	<strong>'.$amt.' Clean</strong></div>');		

$amt = number_format($amt, 2, '.', '');
echo ('<div class="alert alert-success alert-dismissible " role="alert">
          	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	<strong>'.$amt.' Number</strong></div>');*/
$amt = test_input($amt);

/*echo ('<div class="alert alert-success alert-dismissible " role="alert">
          	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	<strong>'.$amt.' Test</strong></div>');		
   */       	
	$tr_date = $_POST['transactionDate'];
	if ($_POST['transType']=="payment") {$amt = "-".$amt;}
	elseif ($_POST['transType']=="deposit") {$amt = $amt;}
//	var_dump(filter_var($amt, FILTER_VALIDATE_FLOAT));
	$desc =  test_input($_POST['description']);
	$current_balance = $_POST['currentBalance'];
	if ($_POST['transType']=="payment") {$cat = $_POST['categoryP'];$cat_ID = $_POST['categoryP_ID'];}
	elseif ($_POST['transType']=="deposit") {$cat = $_POST['categoryD'];$cat_ID = $_POST['categoryD_ID'];}
	$cat = test_input($cat);
	$acct = $_POST['acct'];
	$cknum = $_POST['checkNumber'];
//	var_dump(filter_var($cknum, FILTER_VALIDATE_INT));
	$cl_date = $_POST['clearDate'];
	date_default_timezone_set('America/Chicago');
   	$offset = date_offset_get(new DateTime)/3600;
   	$error="";
   	$server = $_SERVER['SERVER_NAME'];
   	$mysite = $domain;
   	$referer  = $_SERVER['HTTP_REFERER'];  
	if (!in_array($server, $domain_array)) {
      $error = "No XSS allowed";
	} elseif  (!in_array($referer, $mainpage_array)) {
      $error = "Unauthorized pickling.  Referrer: " . $referer;
   	}
   	else
       	{
		$sql = "INSERT INTO `checkbook` (`transaction_date`,`amount`,`description`,`current_balance`,`category`,`category_id`,`account_id`,`check_number`,`clear_date`,`cleared`) VALUES ('$tr_date', '".mysqli_real_escape_string($link, $amt)."', '".mysqli_real_escape_string($link, $desc)."', '$current_balance', '$cat', '$cat_ID', '$acct', '".mysqli_real_escape_string($link, $cknum)."', '$cl_date', '0')";
		if (mysqli_query($link, $sql)) {
			if ($amt > 0) {
				echo ('<div class="alert alert-success alert-dismissible " role="alert">
          	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	<strong>Deposit submitted</strong></div>');			
			} else {
				echo ('<div class="alert alert-success alert-dismissible " role="alert">
          	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          	<strong>Payment submitted</strong></div>');
			} 

		} else {
			$error = "Error during transmission";
		}
   	}
	if ($error!=""){   
   echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>'.$error.'</strong></div>');}
}
mysqli_close($link); 
?>
