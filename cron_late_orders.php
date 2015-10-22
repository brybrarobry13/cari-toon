<?
include_once("includes/configuration.php");

//mysql 
$query = "
SELECT 
	T.*,
	TP.`product_title`,  
	TP.`product_turnaroundtime`, 
	TA.`user_fname` AS `artist_fname`,
	TA.`user_lname` AS `artist_lname`, 
	TC.`user_fname` AS `cust_fname`, 
	TC.`user_lname` AS `cust_lname` 
FROM `toon_orders` T,`toon_products` TP,`toon_users` TA ,`toon_users` TC 
WHERE T.`product_id` = TP.`product_id`
	AND T.user_id = TC.user_id
	AND T.artist_id = TA.user_id
	AND (T.order_status = 'Paid' OR T.order_status = 'Work In Progress' OR  T.order_status = 'waiting for approval')
HAVING 
	0<DateDiff(NOW(),DATE_ADD(T.order_date, INTERVAL TP.product_turnaroundtime DAY))
";
	
$sql_content = mysql_query($query) or die("Problems with query:" . mysql_error());

while($sql_details = mysql_fetch_array($sql_content))
{
	//mail functions
	$to = $_CONFIG['email_contact_us'];
	$order_date = strtotime($sql_details['order_date']);
	$deadline = $order_date+$sql_details['product_turnaroundtime']*24*60*60;
	$subject = "Order ID {$sql_details['order_id']} - Deadline not met";
	$from = $_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
	$header = "From: ".$from."\n";
	$header.= "MIME-Verson: 1.1\n";
	$header.= "Content-type:text/html; charset=iso-8859-1\n";
	$message = "Date:".date("m-d-Y")."<br> Order ID:".$sql_details['order_id']."<br><br>";
	$message.= "The Caricature Toon with Order ID {$sql_details['order_id']} is late.<br /><br />";
	$message.= "The details are given below:<br />";
	$message.= "<b> Customer     : </b> ". $sql_details['cust_fname'] . $sql_details['cust_lname']."<br />";
	$message.= "<b> Artist       : </b> {$sql_details['artist_fname']} {$sql_details['artist_lname']}<br />";
	$message.= "<b> Product      : </b> {$sql_details['product_title']}<br />";	
	$message.= "<b> Order Status : </b> {$sql_details['order_status']}<br />";
	$message.= "<b> Order Date   : </b> ".date("m-d-Y",$order_date)."<br />"; 
	$message.= "<b> Deadline Date: </b> ".date("m-d-Y",$deadline);
	mail($to,$subject,$message,$header);
	//end of mail	
}
?>