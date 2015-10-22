<?
	include("includes/configuration.php");
	function rsum($v, $w)
	{
	$v += $w['totalprice'];
	return $v;
	}
	
	$u_id=$_SESSION['sess_tt_uid'];
	$cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id  AND `cart_status`='active'");
	$cartarray_row=mysql_fetch_assoc($cartarray_rs);
	$cart=unserialize(base64_decode($cartarray_row['cart_array']));
	if($_REQUEST['projectid']!='0')
	{
	$number=$_REQUEST['number'];
	$projectid=$_REQUEST['projectid'];
	$cart[$projectid]['number'] = $number;
	$cart[$projectid]['totalprice'] = $cart[$projectid]['number']*$cart[$projectid]['ezproduct_price'];
	$serialised=base64_encode(serialize($cart));
	mysql_query("UPDATE `toon_cart` SET `cart_array` =  '$serialised',`cart_modified` = now() WHERE `user_id` ='$u_id'  AND `cart_status`='active'");

	}
	
	$total_product_price=array_reduce($cart, "rsum");
	if($pcode=$_REQUEST['pcode'])
	{
		$pcode_query=mysql_query("SELECT * FROM `toon_promo` WHERE `promo_code`='$pcode' AND current_date() BETWEEN `promo_start_date` AND `promo_expiry` AND `promo_product_type`='ez product' AND `promo_isused` = '0'");
		$pcode_row=mysql_fetch_array($pcode_query);
		if($pcode_row['promo_discount']!=0 && $pcode_row['promo_discount']!='')
			{
				if($total_product_price>$pcode_row['promo_amount'])
				{
					if($pcode_row['promo_type']==0)
						{
							$discount=($total_product_price* $pcode_row['promo_discount'])/100;
						}
					else
						{
							$discount=$pcode_row['promo_discount'];
						}
					mysql_query("UPDATE `toon_cart` SET `promo_code` =  '$pcode',`cart_modified` = now() WHERE `user_id` ='$u_id'  AND `cart_status`='active'");
				}
			}
		else
			{
				$discount=0;
			}
	}
	else
	{
		$spo_ez_query = mysql_query("SELECT * FROM `toon_special_offers` WHERE current_date() BETWEEN `spo_startdate` AND `spo_enddate` AND `spo_product`='ez product'");
		$number_spo_ez = mysql_num_rows($spo_ez_query);
		$spo_ez_row = mysql_fetch_assoc($spo_ez_query);
		if($number_spo_ez!=0)
		{
			$discount = ($total_product_price* $spo_ez_row['spo_discount'])/100;
		}
		else
		{
			$discount=0;
		}
	}
	echo $total_product_price.'||'.$discount;
?>