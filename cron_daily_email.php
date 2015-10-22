<? // LIVE SERVER
$hostname = 'localhost';
$dbname = 'ccdb';
$db_user = 'ccdbuser';
$db_password = 'CCbd12!Pa'; 

$link = mysql_connect($hostname,$db_user,$db_password);
$connect = mysql_select_db($dbname,$link)or die(mysql_error());

## FETCH VALUES FROM CONFIG TABLE AND MOVE TO '$_CONFIG' ARRAY()
$configuration_query = mysql_query('SELECT * FROM `toon_configuration`')or die(mysql_error());	
while ($row_configuration = mysql_fetch_assoc($configuration_query)) 
{
	$config_code=strtolower($row_configuration['config_code']);
	$_CONFIG[$config_code]=$row_configuration['config_value'];
}

$user_order_resultquery = mysql_query("SELECT TS . *,TU . *,TP.* FROM `toon_orders` TS,`toon_users` TU,`toon_products` TP WHERE (TS.order_status='Paid' OR TS.order_status='Work In Progress') AND TP.product_id=TS.product_id AND TU.user_id=TS.user_id AND TS.user_id!=0") or die("Problems with query:" . mysql_error());
while($user_order_result=mysql_fetch_assoc($user_order_resultquery))
{
	$artist_email_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='".$user_order_result['artist_id']."'");
	$artist_email_row=mysql_fetch_assoc($artist_email_query);
	
	$date1  = date("Y-m-d h:i:s");
	$date2  = $user_order_result['order_date'];
	$diff 	= abs(strtotime($date1) - strtotime($date2));
	$days 	= floor($diff / (60*60*24));
	$deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('".$user_order_result["order_date"]."', INTERVAL  ".$user_order_result["product_turnaroundtime"]." DAY)"));
	
	//Email to artist if order not yet started
	if(($user_order_result['order_status']=='Paid')&&($days<$user_order_result['product_turnaroundtime']))
	{
		$wholesale_price = number_format($user_order_result['order_wholesale_price'],2,'.',',');
		$toonhelper = $_CONFIG['email_contact_us'];
		$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
		$to=$artist_email_row['user_email'];
		$subject='New Order Has Not Yet Been Started Notification';
		$message ='Hi <b>'.$artist_email_row["user_fname"].'</b>,<br><br>You have a new order. Please satrt the work as soon as possible to complete the work on time.<br><br><b>Order ID # </b>'.$user_order_result["order_id"].'<br><b>Date :</b> '.date("m-d-Y").'<br><b>Customer :</b> '.$user_order_result['user_fname'].'<br><b>No of People :</b> '.$user_order_result["order_people_count"].'<br><b>Artist Style :</b> '.$user_order_result["product_title"].'<br><b>Wholesale price :</b> $'.$wholesale_price.'<br><b>Deadline :</b> '.date("m-d-Y",strtotime($deadline[0])).'<br><b>Order Status:</b> '.$user_order_result["order_status"].'<br><b>Days Left :</b> '.($user_order_result['product_turnaroundtime']-$days).'<br><b>Caricature Request Requirements as the header : </b>'.$user_order_result["order_instructions"].'<br><br>If at anytime you have questions or require assistance, please email us at <b> '.$_CONFIG['email_contact_us'].'</b><br><br>Life should always be fun!!!<br><br>The Captoon<br>www.caricaturetoons.com<br><br>';
		$header  = "From: ".$from."\n";
		$header .= "MIME-Verson: 1.1\n";
		$header .= "Content-type:text/html; charset=iso-8859-1\n";
		$header .= "Cc: " .$toonhelper. "\r\n";
		$header .= "Bcc: priswinjose@gmail.com" . "\r\n";
		if($to)
		{	
			mail($to,$subject,$message,$header);
		}
	}
	
	//Email to artist if the job is late
	if((($user_order_result['order_status']=='Paid')||($user_order_result['order_status']=='Work In Progress'))&&($days>$user_order_result['product_turnaroundtime']))
	{
		$wholesale_price = number_format($user_order_result['order_wholesale_price'],2,'.',',');
		$toonhelper = $_CONFIG['email_contact_us'];
		$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
		$to=$artist_email_row['user_email'];
		$subject='Order Has Not Yet Been Completed Notification';
		$message ='Hi <b>'.$artist_email_row["user_fname"].'</b>,<br><br>The Caricature Toon with Order ID '.$user_order_result["order_id"].' is late.<br><br><b>Order ID # </b>'.$user_order_result["order_id"].'<br><b>Date :</b> '.date("m-d-Y").'<br><b>Customer :</b> '.$user_order_result["user_fname"].'<br><b>No of People :</b> '.$user_order_result["order_people_count"].'<br><b>Artist Style :</b> '.$user_order_result["product_title"].'<br><b>Wholesale price :</b> $'.$wholesale_price.'<br><b>Deadline :</b> '.date("m-d-Y",strtotime($deadline[0])).'<br><b>Order Status: </b> '.$user_order_result["order_status"].'<br><b>Caricature Request Requirements as the header :</b> '.$user_order_result["order_instructions"].'<br><br>If at anytime you have questions or require assistance, please email us at <b> '.$_CONFIG['email_contact_us'].'</b><br><br>Life should always be fun!!!<br><br>The Captoon<br>www.caricaturetoons.com<br><br>';
		$header  = "From: ".$from."\n";
		$header .= "MIME-Verson: 1.1\n";
		$header .= "Content-type:text/html; charset=iso-8859-1\n";
		$header .= "Bcc: priswinjose@gmail.com" . "\r\n";
		if($to)
		{
			mail($to,$subject,$message,$header);
			mail($toonhelper,$subject,$message,$header);
		}
	}
}
?>