<? 	include("includes/configuration.php");
	$opro_id=$_REQUEST['opro_id'];
	$user_id=$_SESSION['sess_tt_uid'];
	$query = "SELECT OP.opro_caricature, OP.opro_id, O.order_id,O.user_id 
			FROM `toon_order_products` OP, `toon_orders` O
			WHERE OP.order_id = O.order_id 
			AND O.user_id=$user_id 
			AND OP.opro_id=$opro_id";
	$content=mysql_query($query);
	$content_row=mysql_fetch_array($content);
	$filename=$content_row['opro_caricature'];
	header("Content-type: application/image");
    header("Content-Disposition:attachment; filename=$filename");
	readfile(DIR_CARICATURE_IMAGES.$filename);
?>