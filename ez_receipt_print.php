<?  include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	if(!isloggedIn()) { exit();	}
	$u_id=$_SESSION['sess_tt_uid'];
	$cart_id=$_REQUEST['cart_id'];
	$cartarray_rs=mysql_query("SELECT TEOP.*,TC.*,T.*,TU.user_email FROM `toon_cart`TC,`toon_ez_order_products`TEOP,`toon_users`TU,`toon_shipping_address`T WHERE TEOP.user_id=$u_id  AND TC.user_id=$u_id AND TEOP.cart_id='$cart_id' AND TC.cart_id='$cart_id' AND TU.user_id=$u_id AND T.ezopro_id=TEOP.ezopro_id AND T.user_id=$u_id ");
	$cartarray_row=mysql_fetch_array($cartarray_rs);
	$cart=unserialize(base64_decode($cartarray_row['cart_array']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Receipt</title>
</head>
<body onload="print()">
<table cellpadding="2" cellspacing="2" align="center" border="0" style="border:1px solid #CCCCCC;" width="100%">
	<tr>
		<td align="center"><img src="images/logo.png" width="327" height="122" border="0"/></td>
	</tr>
	<tr>
		<td style="font:bold 14px arial;">Order Receipt : Order #&nbsp;<?=$cart_id?></td>
	</tr>
    <tr>
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;font-family:Arial, Helvetica, sans-serif;font-size:14px;">Ordered Date : <?=date("m-d-y",strtotime($cartarray_row['ezopro_posted']))?></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;font-family:Arial, Helvetica, sans-serif;font-size:14px;">
					<tr>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;line-height:25px;">Sl No.</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Product</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Quantity</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Unit Price</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Total Price</td>
					</tr>
                    
                    <? 
					$k=1;
					foreach ($cart as $key=>$name)
					{
					$total+=$name['totalprice'];
					?>
                    
					<tr style="text-align:center">
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;line-height:25px;"><?=$k;?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;"><?=$name['ezproduct_name']?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;"><?=$name['number']?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">$&nbsp;<?=number_format($name['ezproduct_price'],2)?> U.S</td>
						
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;<?=number_format($name['totalprice'],2)?> U.S</td>
					</tr>
                    
                    <? 
					$k++;
					 }
					 $discount=$total+$cartarray_row['ship_price']-$cartarray_row['ezopro_totalprice'];
					 ?>
                    
                    <tr align="right">
						<td colspan="4" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Shipping Cost:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;<?=number_format($cartarray_row['ship_price'],2)?> U.S</td>
					</tr>
					<tr align="right">
						<td colspan="4" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Discount:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;<?=number_format($discount,2)?> U.S</td>
					</tr>
					<tr align="right">
						<td colspan="4" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Grand Total:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;<?=number_format($cartarray_row['ezopro_totalprice'],2)?> U.S</td>
					</tr>
					
					
			</table>		</td>
	</tr>
</table>
</body>
</html>
