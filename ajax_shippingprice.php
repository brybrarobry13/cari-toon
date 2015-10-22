<?
 include("includes/configuration.php");	
 
 $order=array();
 $order["FC"]='Not available';
 $order["PM"]='Not available';
 $order["SD"]='Not available';
 $order["ON"]='Not available';
	
 $u_id=$_SESSION['sess_tt_uid'];

 $cartarray_rs=mysql_query("SELECT * FROM `toon_cart` WHERE `user_id`=$u_id  AND `cart_status`='active'");
 $cartarray_row=mysql_fetch_assoc($cartarray_rs);
 $number_row=mysql_num_rows($cartarray_rs);
 if($number_row==0)
 {
	 $xml = "<?xml version='1.0' ?><response><FC>".$order["FC"]."</FC><PM>".$order["PM"]."</PM><SD>".$order["SD"]."</SD><ON>".$order["ON"]."</ON><price>total</price></response>";
	 echo $xml;
	 exit();
 }
 $firstname=$_REQUEST['firstname'];
 $lastname=$_REQUEST['lastname'];
 $address1=$_REQUEST['address1'];
 $address2=$_REQUEST['address2'];
 $city=$_REQUEST['city'];
 $state=$_REQUEST['state'];
 $zip=$_REQUEST['zip'];
 $countrycode=$_REQUEST['countrycode'];
 $productid=$_REQUEST['productid'];
 //$price=$_REQUEST['price'];
// $shipmethod=$_REQUEST['shipmethod'];
 $description=$_REQUEST['description'];
 $cart=unserialize(base64_decode($cartarray_row['cart_array']));
 //print_r($cart);
 $orderline="";
 foreach ($cart as $key=>$name)
 {
	$orderline.='<orderline productid = "'.$name['ezproduct_sku'].'">
<quantity>'.$name['number'].'</quantity>
</orderline>';

 }
 
$doc = new DOMDocument();
$doc->loadxml('<orders partnerid = "717" version = "1">
<ordersession>
<order>
<shippingaddress>
<title>Ms</title>
<firstname>'.$firstname.'</firstname>
<lastname>'.$lastname.'</lastname>
<address1>'.$address1.'</address1>
<address2>'.$address2.'</address2>
<city>'.$city.'</city>
<state>'.$state.'</state>
<zip>'.$zip.'</zip>
<countrycode>'.$countrycode.'</countrycode>
</shippingaddress>
'.$orderline.'</order>
</ordersession>
</orders>');
$ezPrintsXML = $doc->saveXML();
// Generate an XML stringto send to EZPrints. $doc is a DOMDocument populated with required EZPrints data. Alternatively the $ezPrintsXML string can be generated manually.
// create a header array that specifies a blank content type.
$header[] = "Content-type:";
// initialize CURL to use the EZPrints URL
$ch = curl_init("http://www.ezprints.com/ezpartners/shippingcalculator/xmlshipcalc.asp");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Returns response data instead ofTRUE
curl_setopt($ch, CURLOPT_POST, true); // specify that POST should be used
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // set the customized headers
curl_setopt($ch, CURLOPT_POSTFIELDS, $ezPrintsXML); // use HTTP POST to send data
$resp = curl_exec($ch); //execute post and get results as string into $respvariable
curl_close ($ch); // close the curl object
// $resp is the response from EZPrints. This will output that result
$xml = simplexml_load_string($resp);

for($i=0;$i<count($xml->order->option);$i++)
{
	$xml->order->option[$i]->attributes()->shippingMethod;
	$xml->order->option[$i]->attributes()->type;
	$xml->order->option[$i]->attributes()->price;
	$xml->order->option[$i]->attributes()->description;
	if($xml->order->option[$i]->attributes()->type=="FC")
	{
		$order["FC"]=$xml->order->option[$i]->attributes()->price;
	}
	elseif($xml->order->option[$i]->attributes()->type=="PM")
	{
		$order["PM"]=$xml->order->option[$i]->attributes()->price;
	}
	elseif($xml->order->option[$i]->attributes()->type=="SD")
	{
		$order["SD"]=$xml->order->option[$i]->attributes()->price;
	}
	elseif($xml->order->option[$i]->attributes()->type=="ON")
	{
		$order["ON"]=$xml->order->option[$i]->attributes()->price;
	}
	//array_push($order,$xml->order->option[$i]->attributes()->price);
}
//if($shipmethod==usfc){$total=(float)$order[0]+(float)$price;}
//if($shipmethod==uspm){$total=(float)$order[1]+(float)$price;}
//if($shipmethod==ussd){$total=(float)$order[2]+(float)$price;}
//if($shipmethod==ovnt){$total=(float)$order[3]+(float)$price;}
/*if($order[0])
{
$cost1=$order[0];
}
else
{
$cost1='Not available';
}
if($order[1])
{
$cost2=$order[1];
}
else
{
$cost2='Not available';
}
if($order[2])
{
$cost3=$order[2];
}
else
{
$cost3='Not available';
}
if($order[3])
{
$cost4=$order[3];
}
else
{
$cost4='Not available';
}*/
$xml = "<?xml version='1.0' ?><response><FC>".$order["FC"]."</FC><PM>".$order["PM"]."</PM><SD>".$order["SD"]."</SD><ON>".$order["ON"]."</ON><price>total</price></response>";
echo $xml;
?>
