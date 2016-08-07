

<?php 

session_start();
include("connection.php");

$user = $_SESSION['id'];
//$user = '-1';

if(strlen($user) > 0) {
$query = "select distinct cat.name
			,cat.payment_cat
        ,cat.deposit_cat
        ,uc.order
        ,uc.hide
        ,cat.user_id
        ,cat.category_id
from user_categories AS uc
inner Join categories as cat
on cat.category_id=uc.category_id
WHERE (uc.user_id = '".mysqli_real_escape_string($link, $user)."') ORDER BY `order`";
/*echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $query . '</strong></div>');*/

$result = mysqli_query($link, $query);
if ($result>0) {echo '<form method="post" id= "categoryForm" action = ""><div class="row visible-sm visible-md visible-lg"><table class="categoryTable table"> <tr> <th>Category Name</th><th>Payment</th> <th>Deposit</th>  <th>Hide</th> </tr>';
echo '<tr id="new_category_row"><td><input class="form-control" id="category_name" placeholder="Category Name"></td>';
echo '<td><div class="checkbox"><input type="checkbox" id="new_paymentCategory" class="payment_category" value="0"></div></td>';
echo '<td><div class="checkbox"><input type="checkbox" id="new_depositCategory" class="deposit_category" value="0"></div></td>';
echo '<td><div class="checkbox"><input type="checkbox" id="new_hideCategory" class="hide_category" value="0"></div></td></tr>';} 
while($row = mysqli_fetch_array($result)) { 
echo "<tr valign='top' id= 'category" . $row['category_id'] . "' >"; 
echo "<td>" . $row['name'] . "</td>"; 
if ($row['payment_cat']=='1'){$pay_check="checked='checked' value='1'";}else{$pay_check="value='0'";}
if ($row['user_id']==$user){$disable="disabled='disabled'";}
else{$disable="disabled='disabled'";}

echo "<td><div class='checkbox'><input type='checkbox' id='' class='payment_category' " . $pay_check . $disable . " ></div></td>"; 
if ($row['deposit_cat']=='1'){$dep_check="checked='checked' value='1'";}else{$dep_check="value='0'";}
echo "<td><div class='checkbox'><input type='checkbox' id='' class='deposit_category' " . $dep_check . $disable . " ></div></td>";
if ($row['hide']=='1'){$hide_check="checked='checked' value='1'";}else{$hide_check="value='0'";}
echo "<td><div class='checkbox'><input type='checkbox' id='' class='hide_category' " . $hide_check . " ></div></td>";
}	
echo "</table></div></form>";

}

mysqli_close($link); 

?>

