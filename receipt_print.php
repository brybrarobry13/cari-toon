<?
	include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	if(!isloggedIn()){
		exit();
	}
	$u_id=$_SESSION['sess_tt_uid'];
	$ord_id=$_REQUEST['ord_id'];
	$biling_ord_query = mysql_query("SELECT * FROM `toon_orders` WHERE `order_id`='$ord_id' AND `user_id`='$u_id'");
	$biling_ord_row=mysql_fetch_array($biling_ord_query);
	$number_biling_ord=mysql_num_rows($biling_ord_query);
	if($number_biling_ord==0)
	{ exit();
	}
	$biling_ord_row['order_instructions'];
	$artist_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$biling_ord_row[artist_id]");
	$artist_row=mysql_fetch_array($artist_query);
	$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$biling_ord_row[product_id]");
	$product_row=mysql_fetch_array($product_query);
	$image_query = mysql_query("SELECT * FROM `toon_order_images` WHERE `order_id`='$ord_id'");
	$pcode_query = mysql_query("SELECT * FROM `toon_promo` WHERE `promo_id`=$biling_ord_row[promo_id]");
	$pcode_row=mysql_fetch_array($pcode_query);
	$pcode=$pcode_row['promo_code'];
	$no_people=$biling_ord_row['order_people_count'];
	$product_id=$biling_ord_row['product_id'];
	$price_details=price($no_people,$product_id,$pcode);
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
		<td align="center"><img src="images/logo.gif" width="327" height="122" border="0"/></td>
	</tr>
	<tr>
		<td style="font:bold 14px arial;">Order Receipt : Order #&nbsp;<?=$ord_id?></td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;font-family:Arial, Helvetica, sans-serif;font-size:14px;">
					<tr>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;line-height:25px;">Sl No.</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Artist</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Style</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">No.of people</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Images</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Price</td>
					</tr>
					<tr style="text-align:center">
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;line-height:25px;">1</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;"><?=$artist_row['user_fname']; ?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;"><?=$product_row['product_title']; ?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;"><?=$biling_ord_row['order_people_count']?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;"><? while($image_row=mysql_fetch_array($image_query)){echo $image_row[order_image_name].'<br>';}?></td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">$&nbsp;<?=number_format($price_details['0'], 2);?> U.S</td>
					</tr>
					<tr align="right">
						<td colspan="5" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Discount:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">$&nbsp;<?=number_format($price_details['1'], 2);?> U.S</td>
					</tr>
					<tr align="right">
						<td colspan="5" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Grand Total:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">$&nbsp;<?=number_format($price_details['2'],2);?> U.S</td>
					</tr>
					<tr>
						<td colspan="6" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;line-height:25px;">Your
						additonal instructions:</td>
					</tr>
					<tr>
						<td colspan="6" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;line-height:25px;"><?=$biling_ord_row['order_instructions']; ?></td>
					</tr>
			</table>		</td>
	</tr>
</table>
</body>
</html>
