SET @user = 1;
SET @account = (SELECT account_id FROM accounts a WHERE a.primary = 1 and a.user_id = @user);
SELECT u.user_id, u.name, a.account_id, a.account_name, uc.user_category_id, uc.category_id, c.name, c.payment_cat, c.deposit_cat, uc.hide, max(cb.check_number) as check_number, (select sum(amount) as amount FROM checkbook cb WHERE account_id = @account) as amount  
FROM users u
	INNER JOIN accounts a 
		ON u.user_id = a.user_id
	INNER JOIN user_categories uc
		ON u.user_id = uc.user_id
	INNER JOIN categories c
		ON uc.category_id = c.category_id
	INNER JOIN checkbook cb
		ON cb.account_id = a.account_id
WHERE u.user_id = @user
AND a.account_id = @account
GROUP BY u.user_id, u.name, a.account_id, a.account_name, a.primary, uc.user_category_id, uc.category_id, c.name, c.payment_cat, c.deposit_cat
ORDER BY c.name asc



/*

	
{
"Info":{
	"0":"1","user_id":"1",
	"1":"Michael Ryan","name":"Michael Ryan",
	"2":"mr@popuhler.com","email":"mr@popuhler.com"},
"Categories":{
	"0":{
		"0":"Auto","category_name":"Auto",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"3","category_id":"3"},
	"1":{
		"0":"Clothing","category_name":"Clothing",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"22","category_id":"22"},
	"2":{
		"0":"Correction","category_name":"Correction",
		"1":"1","payment_cat":"1",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"16","category_id":"16"},
	"3":{
		"0":"Debts","category_name":"Debts",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"20","category_id":"20"},
	"4":{
		"0":"Education","category_name":"Education",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"23","category_id":"23"},
	"5":{
		"0":"Gift","category_name":"Gift",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"1","hide":"1",
		"4":"0","user_id":"0",
		"5":"12","category_id":"12"},
	"6":{
		"0":"Grocery","category_name":"Grocery",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"1","category_id":"1"},
	"7":{
		"0":"Health\/Medical","category_name":"Health\/Medical",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"4","category_id":"4"},
	"8":{
		"0":"Herd Share","category_name":"Herd Share",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"1","user_id":"1",
		"5":"36","category_id":"36"},
	"9":{
		"0":"Holidays\/Gifts","category_name":"Holidays\/Gifts",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"6","category_id":"6"},
	"10":{
		"0":"Home\/Garden","category_name":"Home\/Garden",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"7","category_id":"7"},
	"11":{
		"0":"Insurance","category_name":"Insurance",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"21","category_id":"21"},
	"12":{
		"0":"Interest","category_name":"Interest",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"1","user_id":"1",
		"5":"34","category_id":"34"},
	"13":{
		"0":"Internet","category_name":"Internet",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"18","category_id":"18"},
	"14":{
		"0":"Item Sold","category_name":"Item Sold",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"1","user_id":"1",
		"5":"25","category_id":"25"},
	"15":{
		"0":"Memberships","category_name":"Memberships",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"19","category_id":"19"},
	"16":{
		"0":"Other Income","category_name":"Other Income",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"15","category_id":"15"},
	"17":{
		"0":"Payroll","category_name":"Payroll",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"11","category_id":"11"},
	"18":{
		"0":"Personal","category_name":"Personal",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"1","user_id":"1",
		"5":"26","category_id":"26"},
	"19":{
		"0":"Personal Services","category_name":"Personal Services",
		"1":"1","payment_cat":"1",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"24","category_id":"24"},
	"20":{
		"0":"Phone","category_name":"Phone",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"9","category_id":"9"},
	"21":{
		"0":"Refund","category_name":"Refund",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"13","category_id":"13"},
	"22":{
		"0":"Reimbursement","category_name":"Reimbursement",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"14","category_id":"14"},
	"23":{
		"0":"Rental Income","category_name":"Rental Income",
		"1":"0","payment_cat":"0",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"1","user_id":"1",
		"5":"30","category_id":"30"},
	"24":{
		"0":"Restaurant","category_name":"Restaurant",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"10","category_id":"10"},
	"25":{
		"0":"Samaritan Share","category_name":"Samaritan Share",
		"1":"1","payment_cat":"1",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"1","user_id":"1",
		"5":"35","category_id":"35"},
	"26":{
		"0":"Taxes\/Fees","category_name":"Taxes\/Fees",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"8","category_id":"8"},
	"27":{
		"0":"Tithe\/Ministry","category_name":"Tithe\/Ministry",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"5","category_id":"5"},
	"28":{
		"0":"Transfer","category_name":"Transfer",
		"1":"1","payment_cat":"1",
		"2":"1","deposit_cat":"1",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"17","category_id":"17"},
	"29":{
		"0":"Utilities","category_name":"Utilities",
		"1":"1","payment_cat":"1",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"2","category_id":"2"}
	},
"Accounts":{
	"0":{
		"0":"1","account_id":"1",
		"1":"CEFCU Checking","account_name":"CEFCU Checking",
		"2":"1647","check_number":"1647",
		"3":"1204724.3767249584","balance":"1204724.3767249584"},
	"1":{
		"0":"5","account_id":"5",
		"1":"Chase Freedom","account_name":"Chase Freedom",
		"2":"0","check_number":"0",
		"3":"-2433.899971008301","balance":"-2433.899971008301"},
	"2":{
		"0":"6","account_id":"6",
		"1":"360 Checking","account_name":"360 Checking",
		"2":"0","check_number":"0",
		"3":"127.05000305175781","balance":"127.05000305175781"},
	"3":{
		"0":"7","account_id":"7",
		"1":"360 Savings","account_name":"360 Savings",
		"2":"0","check_number":"0",
		"3":"1927.4300537109375","balance":"1927.4300537109375"},
	"4":{
		"0":"14","account_id":"14",
		"1":"Test - no balance","account_name":"Test - no balance",
		"2":"0","check_number":"0",
		"3":"505","balance":"505"}}} 	
	
	
	
	
		*/
		
		
		//echo ('<div class="alert alert-success alert-dismissible " role="alert">
 //         	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   //       	<strong>'.$userObject.' </strong></div>');
//}
//}



UPDATE `checkbook` 
SET `last_edit`=[value-2]
,`transaction_date`=[value-3]
,`amount`=[value-4]
,`description`=[value-5]
,`current_balance`=[value-6]
,`category`=[value-7]
,`category_id`=[value-8]
,`account_id`=[value-9]
,`check_number`=[value-10]
,`clear_date`=[value-11]
,`cleared`=[value-12] 
WHERE `transaction_id`=[value-1]
<?php

session_start();
include("connection.php");
$user = $_SESSION['id'];

$account = $_POST['acct'];
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
//echo ('<p>'.$recfilter . ' '.$rec_filter . '</p><p>'.$catfilter.' '.$cat_filter . '</p>');

$check_filter = $_POST['checkFilter'];
if ($check_filter == 1) {$checkfilter = "AND `check_number` > 0";}
$search_description = $_POST['searchDesc'];
if ($search_description == ""){$searchdescription = "";} else {$searchdescription = "AND `description` LIKE '%".mysqli_real_escape_string($link, $search_description)."%' ";}
$acct = $_POST['acct'];
$filters = " ".$rec_filter." ".$catfilter." ".$checkfilter." ".$trdate." ".$cldate." ".$searchdescription." ".$amountsearch." ";




$transaction_query = "SELECT `transaction_id`, `transaction_date`, `check_number`, `clear_date`, 
`category`, `category_id`, `description`, `amount`, `cleared` 
FROM `checkbook` WHERE `account_id` = '".mysqli_real_escape_string($link, $account)."' ".$filters." ORDER BY `transaction_date` DESC, `transaction_id` DESC";;

$transaction_result = mysqli_query($link, $transaction_query);
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
	
	$transactionObject = json_encode($transaction_info);
echo $transactionObject;

?>
