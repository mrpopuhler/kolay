

<?php 
session_start();
include("connection.php");
$user = $_SESSION['id'];
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
$filters = "from checkbook WHERE `account_id` = '".mysqli_real_escape_string($link, $acct)."' ".$rec_filter." ".$catfilter." ".$checkfilter." ".$trdate." ".$cldate." ".$searchdescription." ".$amountsearch." ORDER BY `transaction_date` DESC, `transaction_id` DESC";
$query = "select * " . $filters;
/*echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $query . '</strong></div>');*/
$sum_query = "select SUM(`amount`) AS FilteredTotal " . $filters;
/*echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $sum_query . '</strong></div>');*/
$get_sum = mysqli_query($link, $sum_query);
$sum_row = mysqli_fetch_array($get_sum);
$sum = number_format($sum_row[0],2);

$result = mysqli_query($link, $query);
if ($result>0) {
while($row = mysqli_fetch_array($result)) { 
echo "<form method='post' id= 'reconcileForm' action = ''><tr valign='top'>"; 
//echo "<td>" . $row['account_id'] . "</td>"; 
echo "<td>" . $row['transaction_date'] . "</td>"; 
if ( $row['check_number'] == 0){
	echo "<td>" . "" . "</td>";
} else {
	echo "<td>" . $row['check_number'] . "</td>";
}	

$date_cleared = $row['clear_date'];
if ($date_cleared == "0000-00-00"){
	$date_cleared = NULL;
}
echo "<td><input class='clearDate form-control' type='date' name='clear_date[]' value ='" . $date_cleared . "' /><input name = 'cleared[]' class='cleared_id' type='hidden' value='" . $row['transaction_id'] . "'/></td>";
echo "<td>" . $row['category'] . "</td>"; 
echo "<td>" . $row['description'] . "</td>"; 
$amount = $row['amount'];
$amount= number_format($amount, 2, '.', ',');
echo "<td>" . $amount . "</td>"; 
//echo "<td>" . $row['current_balance'] . "</td>";
//echo "<td>" . $row['cleared'] . "</td>";


if ($row['cleared'] == 0) {
	echo '<td><button id="cleared" class="clrbutton"><span class="glyphicon glyphicon-ok"><input name = "cleared[]" class="cleared_id" type="hidden" value="' . $row['transaction_id'] . '"/></span></button></td>';
} else {
	echo '<td><button id="cleared" class="clrbutton"><span class="glyphicon glyphicon-ok cleared"><input name = "cleared[]" class="cleared_id" type="hidden" value="' . $row['transaction_id'] . '"/></span></button></td>';
	}
echo "<td></td>";
echo "</tr>"; 
} 
echo "</form></table></div>";
/*echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $cat_sql . '</strong></div>');*/



mysqli_close($link); 

?>

