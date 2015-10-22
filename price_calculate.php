<?
include("includes/configuration.php");
include(DIR_INCLUDES.'functions/orders.php');
if (isset($_REQUEST['people']))
	{
		$no_people=$_REQUEST['people'];
		$pdct_id=$_REQUEST['pdct_id'];
		$pcode=$_REQUEST['pcode'];
		$props = $_REQUEST['props'];
		if(!$props)
		$props = 1;
		$balance = price($no_people,$pdct_id,$pcode,$props);
		$artist_row = mysql_fetch_array(mysql_query("SELECT TU.user_fname FROM `toon_users`TU,`toon_products`TP WHERE TP.`user_id`=TU.`user_id` AND TP.`product_id` = '$pdct_id'"));	
		echo '$&nbsp;'.number_format($balance['2'],2,'.',',').'||'.$artist_row['user_fname'] . "##" . $balance['0'] . "##" . $balance['1'];
	}
?>