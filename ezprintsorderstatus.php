<?
include("includes/configuration.php");
$xml=$HTTP_RAW_POST_DATA;
$obj=simplexml_load_string($xml);
//echo "Obj:\r\n";
//print_r($obj);
if($obj->ordernumber)
	{
		$ordnum=$obj->ordernumber;
		$referencenumber=$obj->referencenumber;
		$message=$obj->message;
		if($message=='4002 Error: Type mismatch')
			{
				$orderstatus='failed to unmarshal';
				//mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_orderstatus`='$orderstatus' WHERE `ezopro_orderreference`='$referencenumber' AND `ezopro_id`='$ordnum'");
			}
	}
else
	{
		$obj->attributes()->Id;
		$order_id=$obj->Order->attributes()->Id;
		$ezpreferenceNumber=$obj->Order->attributes()->EZPReferenceNumber;
		if($obj->Order->Accepted->attributes()->DateTime)
			{
			$orderstatus='Accepted';
			$orderdate=$obj->Order->Accepted->attributes()->DateTime;
			//mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_orderstatus`='$orderstatus',`ezopro_ezpreference`='$ezpreferenceNumber',`ezopro_orderstatusposted`='$orderdate' WHERE `ezopro_id`='$order_id'");
			}
		elseif($obj->Order->AssetsCollected->attributes()->DateTime)
			{
			$orderstatus='AssetsCollected';
			$orderdate=$obj->Order->AssetsCollected->attributes()->DateTime;
			//mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_orderstatus`='$orderstatus',`ezopro_orderstatusposted`='$orderdate',`ezopro_ezpreference`='$ezpreferenceNumber' WHERE `ezopro_id`='$order_id'");
			}
		elseif($obj->Order->InProduction->attributes()->DateTime)
			{ 
			$orderstatus='InProduction';
			$orderdate=$obj->Order->InProduction->attributes()->DateTime;
			//mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_orderstatus`='$orderstatus',`ezopro_orderstatusposted`='$orderdate',`ezopro_ezpreference`='$ezpreferenceNumber' WHERE `ezopro_id`='$order_id'");
			}
		elseif($obj->Order->Canceled->attributes()->DateTime)
			{
			$orderstatus='Canceled';
			$orderdate=$obj->Order->Canceled->attributes()->DateTime;
			//mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_orderstatus`='$orderstatus',`ezopro_orderstatusposted`='$orderdate',`ezopro_ezpreference`='$ezpreferenceNumber' WHERE `ezopro_id`='$order_id'");
			}
		elseif($obj->Order->Shipment->attributes()->DateTime)
			{
			$orderstatus='Shipment';
			$orderdate=$obj->Order->Shipment->attributes()->DateTime;
			$tracking_no=$obj->Order->Shipment->attributes()->TrackingNumber;
			$carrier=$obj->Order->Shipment->attributes()->Carrier;
			mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_carrier`='$carrier',`ezopro_trackingnumber`='$tracking_no',`ezopro_ezpreference`='$ezpreferenceNumber' WHERE `ezopro_id`='$order_id'");
			$user_row = mysql_fetch_array((mysql_query("SELECT * FROM `toon_ez_order_products` WHERE `ezopro_id`='$order_id'")));
			$getUserDetails = getUserDetails($user_row['user_id']);
			$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
			$to=$getUserDetails['user_email'];
			$subject='Your Order Shipped!!!';
			$message ='Date: '.date("m-d-Y").'<br>
			Order ID: '.$order_id.'<br><br>
													
			Hi '.$getUserDetails['user_fname'].',<br><br>
			We’re pleased to let you know your order is shipped.<br><br>
			
			Tracking Number: '.$tracking_no.'<br>
			
			Carrier: '.$carrier.'<br><br>
			
			If at anytime you have questions or require assistance, please email us at '.$_CONFIG['email_contact_us'].'<br><br>
			
			Life should always be fun!!!<br>
			The Captoon'; 
			$header = "From: ".$from."\n";
			$header .= "MIME-Verson: 1.1\n";
			$header .= "Content-type:text/html; charset=iso-8859-1\n";
			mail($to,$subject,$message,$header);
			
			}
		elseif($obj->Order->CompleteShipment->attributes()->DateTime)
			{
			$orderstatus='CompleteShipment';
			$orderdate=$obj->Order->CompleteShipment->attributes()->DateTime;
			mysql_query("UPDATE `toon_ez_order_products`SET`ezopro_orderstatus`='$orderstatus',`ezopro_orderstatusposted`='$orderdate',`ezopro_ezpreference`='$ezpreferenceNumber' WHERE `ezopro_id`='$order_id'");
			}
	}

?>