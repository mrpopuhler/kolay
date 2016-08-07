<?php

session_start();
include("connection.php");
$user = $_SESSION['id'];

$account = $_POST['account'];
$recfilter = $_POST['recfilter'];
if ($recfilter == '0') {$rec_filter = "AND `cleared` = '0'";}
elseif ($recfilter == '1') {$rec_filter = "AND `cleared` = '1'";}
else {$rec_filter = "";}
$balance = $_POST['balance'];
$amt_search = $_POST['amt_search'];
if ($amt_search != ""){$amountsearch = "AND floor(abs(`amount`)) = floor(abs('".$amt_search."')) ";} else {$amountmin= "";}
$trdate_min = $_POST['trdate_min'];
$trdate_max = $_POST['trdate_max'];
$cldate_min = $_POST['cldate_min'];
$cldate_max = $_POST['cldate_max'];
if ($trdate_min>0){$trdate = "AND `transaction_date` >= '".$trdate_min."' AND `transaction_date` <= '".$trdate_max."' ";}
if ($cldate_min>0){$cldate = "AND `clear_date` >= '".$cldate_min."' AND `clear_date` <= '".$cldate_max."' ";}

$cat_filter = $_POST['catFilter'];
if ($cat_filter <> '0') {$catfilter = "AND `category_id` = '".$cat_filter."' ";}
elseif ($cat_filter == '1'){$catfilter = '';}

$check_filter = $_POST['checkFilter'];
if ($check_filter == 1) {$checkfilter = "AND `check_number` > 0";}
$search_description = $_POST['searchDesc'];
if ($search_description == ""){$searchdescription = "";} else {$searchdescription = "AND `description` LIKE '%".mysqli_real_escape_string($link, $search_description)."%' ";}

$filters = "";//.$rec_filter." ".$catfilter." ".$checkfilter." ".$trdate." ".$cldate." ".$searchdescription." ".$amountsearch." ";

$transaction_query = "SELECT `transaction_id`, `transaction_date`, `check_number`, `clear_date`, `category`, `category_id`, `description`, `amount`, `cleared` FROM `checkbook` WHERE `account_id` = '".mysqli_real_escape_string($link, $account)."' " .$filters. " ORDER BY `transaction_date` DESC, `transaction_id` DESC";

$transaction_result = mysqli_query($link, $transaction_query);
	$transactions = new ArrayObject();
	while ($transaction_row = mysqli_fetch_array($transaction_result)){
	   if ($transaction_row){
	   		$transactions ->append(($transaction_row));
		} else {
			$transactions = '{
		"0":"0","transaction_id":"0",
		"1":"","transaction_date":"",
		"2":"","check_number":"",
		"3":"","clear_date":"",
		"4":"None","category":"None",
		"5":"0","category_id":"0",
		"5":"No Transactions Retrieved","description":"No Transactions Retrieved",
		"5":"0","amount":"0",
		"5":"0","cleared":"0"}';
		}
	}
	
$sum_query = "SELECT sum(amount) as filtered_sum FROM `checkbook` WHERE `account_id` = '".mysqli_real_escape_string($link, $account)."' " .$filters;
$sum_result = mysqli_query($link, $sum_query);	
$sum = new ArrayObject();
	while ($sum_row = mysqli_fetch_array($sum_result)){
	   if ($sum_row){
	   		$sum ->append(($sum_row));
		}	
	}
$transaction_info = new ArrayObject(array('Sum'=>$sum,'Transactions'=>$transactions));

$transactionObject = json_encode($transaction_info);
echo $transactionObject;


mysqli_close($link); 

?>