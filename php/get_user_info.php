<?php 
session_start();
include("connection.php");
$user = $_SESSION['id'];
//$user = '-1';
//if(strlen($user) > 0) {
$info_query = "SELECT u.user_id, u.name, u.email
FROM users u
WHERE u.user_id = '".mysqli_real_escape_string($link, $user)."'";

$info_result = mysqli_query($link, $info_query);
while($info_row = mysqli_fetch_array($info_result)) {
if($info_row) {
	$info = ($info_row);
}
}

$cat_query = "SELECT DISTINCT cat.name AS category_name
			,cat.payment_cat
        ,cat.deposit_cat
        ,uc.hide
        ,cat.user_id
        ,uc.category_id
FROM user_categories AS uc
INNER JOIN categories AS cat
ON uc.category_id = cat.category_id
WHERE (uc.user_id = '".mysqli_real_escape_string($link, $user)."') ORDER BY cat.name";
	$cat_result = mysqli_query($link, $cat_query);
	$categories = new ArrayObject();
	while ($cat_row = mysqli_fetch_array($cat_result)){
	   if ($cat_row){
	   		$categories ->append(($cat_row));
		} else {
			$categories = '{
		"0":"No Categories Retrieved","category_name":"No Categories Retrieved",
		"1":"0","payment_cat":"0",
		"2":"0","deposit_cat":"0",
		"3":"0","hide":"0",
		"4":"0","user_id":"0",
		"5":"0","category_id":"0"}';
		}
	}
$account_query = "
SELECT a.account_id, a.account_name, 
max(cb.check_number) as check_number, 
sum(cb.amount) as balance  
 FROM `accounts` a 
INNER JOIN `checkbook` cb
	ON a.account_id = cb.account_id
WHERE a.user_id = '".mysqli_real_escape_string($link, $user)."'
GROUP BY a.account_id, a.account_name" ;
      $acct_result = mysqli_query($link, $account_query);
      $accounts = new ArrayObject();
	   while ($acct_row = mysqli_fetch_array($acct_result)){
	   if ($acct_row){
	   		$accounts ->append(($acct_row));
		} else {
			$accounts =  '{"account_id":"0", "account_name":"No Accounts Retrieved","check_number":"0","balance":"0"}';
		}
		}

$user_info = new ArrayObject(array('Info'=>$info,'Categories'=>$categories,'Accounts'=>$accounts));
$userObject = json_encode($user_info);
echo $userObject;

mysqli_close($link); 

?>