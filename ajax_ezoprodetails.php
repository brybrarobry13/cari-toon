<?
	include("includes/configuration.php");
	$u_id=$_SESSION['sess_tt_uid'];
	$ez_sku=$_REQUEST['ez_sku'];
	$projectId=$_REQUEST['projectId'];
	$thumbUrl=$_REQUEST['thumbUrl'];
	$cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id  AND `cart_status`='active'");
	$cartarray_row=mysql_fetch_array($cartarray_rs);
	$number=mysql_num_rows($cartarray_rs);
	if($number==0)
	{
		$productdetails=mysql_query("SELECT * FROM `toon_ez_products` WHERE ezproduct_sku='$ez_sku'");
		$productdetails_row=mysql_fetch_assoc($productdetails);
		$productdetails_row[number]=1;
		$cart=array();
		$cart[$projectId] = $productdetails_row;
		$cart[$projectId]['thumbUrl'] = $thumbUrl;
		$cart[$projectId]['totalprice'] = $cart[$projectId]['number']*$cart[$projectId]['ezproduct_price'];
		$serialised=base64_encode(serialize($cart));
		mysql_query("INSERT INTO `toon_cart` (`cart_array` ,`user_id` ,`cart_modified`,`cart_status`)VALUES ('$serialised', '$u_id', now(),'active')");
		echo "success";
	}
	else
	{
		$productdetails=mysql_query("SELECT * FROM `toon_ez_products` WHERE ezproduct_sku='$ez_sku'");
		$productdetails_row=mysql_fetch_assoc($productdetails);
		$productdetails_row[number]=1;
		$cart=unserialize(base64_decode($cartarray_row['cart_array']));
		$cart[$projectId] = $productdetails_row;
		$cart[$projectId]['thumbUrl'] = $thumbUrl;
		$cart[$projectId]['totalprice'] = $cart[$projectId]['number']*$cart[$projectId]['ezproduct_price'];
		$serialised=base64_encode(serialize($cart));
		mysql_query("UPDATE `toon_cart` SET `cart_array` =  '$serialised',`cart_modified` = now() WHERE `user_id` ='$u_id'  AND `cart_status`='active'");
		echo "success";
	}
	
?>





