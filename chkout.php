<?  include("includes/configuration.php");
	include(DIR_FUNCTIONS.'options.php');
	include(DIR_FUNCTIONS.'paypal.php');
	$ord_id=$_REQUEST['ord_id'];
	if(!isloggedIn())
	{
		if($_COOKIE["toons_order_id"])
		{
			header("Location:alogin.php?back_to=chkout.php?ord_id=$ord_id");
			exit();
		}
		else
		{
			header('Location:alogin.php');
			exit();
		}
	}
	$u_id=$_SESSION['sess_tt_uid'];
	if(isloggedIn() && $_COOKIE["toons_order_id"]==$ord_id)
	{
		mysql_query("UPDATE `toon_orders`SET`user_id`='$u_id' WHERE `order_id`='$ord_id'");
		setcookie('toons_order_id');
	}
	$biling_ord_query = mysql_query("SELECT * FROM `toon_orders` WHERE `order_id`='$ord_id' AND `user_id`='$u_id' AND `order_status`='Pending'");
	$biling_ord_row=mysql_fetch_array($biling_ord_query); 
	if(mysql_num_rows($biling_ord_query)==0)
	{
		header('Location:order-caricature.php');
		exit();
	}
	$price=$biling_ord_row['order_price'];
	$ord_date=$biling_ord_row['order_date'];
	$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`=$biling_ord_row[product_id]");
	$product_row=mysql_fetch_array($product_query);
	$artist_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`=$biling_ord_row[artist_id]");
	$artist_row=mysql_fetch_array($artist_query);
	$month_array=array
	(
		"01"	=>   "January",
		"02"	=>   "February",
		"03"	=>   "March",
		"04"	=>   "April",
		"05"	=>   "May",
		"06"	=>   "June",
		"07"	=>   "July",
		"08"	=>   "August",
		"09"	=>   "September",
		"10"	=>   "October",
		"11"	=>   "Novemeber",
		"12"	=>   "December"
	);
	if(isset($_POST['ok_x']))
	{
		$bill_fname=$_POST['bill_fname'];
		$bill_lname=$_POST['bill_lname'];
		$bill_add1=$_POST['bill_add1'];
		$bill_add2=$_POST['bill_add2'];
		$bill_country=$_POST['bill_country'];
		$bill_city=$_POST['bill_city'];
		$bill_state=$_POST['bill_state'];
		$bill_zip=$_POST['bill_zip'];
		$bill_phno=$_POST['bill_phno'];
		$bill_email=$_POST['bill_email'];
		
		$u_id=$_SESSION['sess_tt_uid'];
		
		
		$user_address_query = mysql_query("UPDATE `toon_users` SET`user_address1`='$bill_add1',`user_address2`='$bill_add2',`user_city`='$bill_city',`user_state`='$bill_state',`user_zipcode`='$bill_zip',`user_country`='$bill_country',`user_phone`='$bill_phno' WHERE `user_id`='$u_id'");
		
		
		########################################################################################################################
		
		// PAYPAL PAYMENTS PRO
		
		$fullname=$_POST['fname_card'];
		$name=explode(' ',$_POST['fname_card']);
		$paymentType = urlencode('Sale');				// or 'Sale' / Authorization
		$firstName = urlencode($name['0']);
		$lastName = urlencode($name['1']);
		$creditCardType = urlencode($_POST['type_card']);
		$creditCardNumber = urlencode($_POST['card_number']);
		$expDateMonth = urlencode($_POST['card_expiry_month']);
		$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
		$expDateYear = urlencode($_POST['card_expiry_year']);
		$cvv2Number = urlencode($_POST['card_cvv']);
		$address1 = urlencode($bill_add1);
		$address2 = urlencode($bill_add2);
		$city = urlencode($bill_city);
		$state = urlencode($bill_state);
		$zip = urlencode($bill_zip);
		$country = urlencode($bill_country);				// US or other valid country code
		$amount = urlencode($price);
		$currencyID = urlencode('USD');
		
		$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber"."&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName"."&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID&EMAIL=$bill_email&DESC=Order id: $ord_id, Product id: $biling_ord_row[product_id], Artist Name: $artist_row[user_fname] $artist_row[user_lname]";

		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = PPHttpPost('DoDirectPayment', $nvpStr);
		//print_r($httpParsedResponseAr);exit();
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
			$trans_id=$httpParsedResponseAr["TRANSACTIONID"];
			$billing_address_query=mysql_query("INSERT INTO `toon_billing_address`(`bill_fname`,`user_id`,`bill_address1`,`bill_city`,`bill_state`,`bill_zipcode`,`bill_country`,`bill_email`)VALUES('$fullname','$u_id','$bill_add1','$bill_city','$bill_state','$bill_zip','$bill_country','$bill_email')");
			$bill_id=mysql_insert_id();
			$payment_query=mysql_query("INSERT INTO `toon_payments`(`user_id`,`order_id`,`payment_txn_id`,`payment_amount`,`payment_status`,`payment_date`)VALUES('$u_id','$ord_id','$trans_id','$price','paid',now())");	
			mysql_query("UPDATE `toon_orders`SET`bill_id`='$bill_id',`order_status`='Paid',`order_date`=NOW() WHERE `order_id`='$ord_id'");	
			
			$status_query=mysql_query("SELECT * FROM `toon_orders` WHERE `order_id`='$ord_id'");
			$status_row=mysql_fetch_array($status_query);
			$status_promo_code = $status_row['$promo_id'];
			
			mysql_query("UPDATE `toon_promo` SET `promo_isused` = '1' WHERE `promo_id`= '$status_promo_code'");
			mysql_query("UPDATE `toon_special_coupons` SET `spc_isused` = '1' WHERE `spc_id`= '$status_promo_code'");
			
			$update_promo = promo_id
			?>	
			<html>
			<body onLoad="document.billing_info.submit()">
			<form action="reciept.php?ord_id=<?=$ord_id?>" method="post" name="billing_info">
			<input type="hidden" name="payment" value="1" />
			</form> 
			</body>
			</html>
			<?
			exit();
		/**/	
		
			
		
		//Uncomment to see the code
		
		//$response = "DEBUG"; //
		
		//$response = "SUCCESS";
		
		}		
		else		
		{
			$msg='*Transaction failed!!<br/>'.urldecode($httpParsedResponseAr['L_SHORTMESSAGE0']) . "<br>Error code: " . urldecode($httpParsedResponseAr['L_ERRORCODE0']);
		}

##################################################################################################################################

	}
	$user_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$u_id'");
	$user_row=mysql_fetch_array($user_query); 
	include (DIR_INCLUDES.'header.php');
?> 
<script src="javascripts/billing_information.js" type="text/javascript"></script>
<script>

function autotab(original,destination){
if (original.getAttribute&&original.value.length==original.getAttribute("maxlength"))
destination.focus()
}

function validate()
	{
		var k=0;
		if(document.getElementById('bill_fname').value=='')
			{
				document.getElementById('bill_fname_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_fname_div').style.display='none';
			}
			if(document.getElementById('bill_lname').value=='')
			{
				document.getElementById('bill_lname_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_lname_div').style.display='none';
			}
			
			
			var bill_phno = /^\d{3}[-]?[ ]?\d{3}[-]?[ ]?\d{4}$/;
		
	if(!bill_phno.test(document.getElementById('bill_phno').value))
			{
				document.getElementById('bill_phno_div').style.display='block';
				k=1
			}
	else
			{
			document.getElementById('bill_phno_div').style.display='none';
			}
			
			if(document.getElementById('bill_email').value=='')
			{
				document.getElementById('bill_email_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_email_div').style.display='none';
			}
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById('bill_email').value))
			{
			document.getElementById('bill_email_div').style.display='none';
			}
		else
			{
			document.getElementById('bill_email_div').style.display='block';
				k=1
			}
			if(document.getElementById('bill_add1').value=='')
			{
				document.getElementById('bill_add1_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_add1_div').style.display='none';
			}
		if(document.getElementById('bill_city').value=='')
			{
				document.getElementById('bill_city_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_city_div').style.display='none';
			}
			if(document.getElementById('bill_country').value=='')
			{
				document.getElementById('bill_country_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_country_div').style.display='none';
			}
			if(document.getElementById('bill_state').value=='')
			{
				document.getElementById('bill_state_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_state_div').style.display='none';
			}
			if(document.getElementById('bill_zip').value=='')
			{
				document.getElementById('bill_zip_div').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('bill_zip_div').style.display='none';
			}
			if(document.getElementById('type_card').value=='')
			{
				document.getElementById('card_type_error').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('card_type_error').style.display='none';
			}
			if(document.getElementById('card_number').value=='')
			{
				document.getElementById('card_number_error').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('card_number_error').style.display='none';
			}
			if(document.getElementById('card_cvv').value=='')
			{
				document.getElementById('card_cvv_error').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('card_cvv_error').style.display='none';
			}
			if(document.getElementById('card_expiry_month').value==''||document.getElementById('card_expiry_year').value=='')
			{
				document.getElementById('card_expiry_month_error').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('card_expiry_month_error').style.display='none';
			}
			
			if(document.getElementById('fname_card').value=='')
			{
				document.getElementById('fcard_name_error').style.display='block';
				k=1
			}
		else
			{
				document.getElementById('fcard_name_error').style.display='none';
			}
			
		if(k==1)
		{
		return false
		}
	return true;
	}
	function checkemail(myForm)
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.email.value))
		{
			return true;
		}
			document.getElementById("valid_email_error").style.display="block";
			return false;
	}
</script>
<link rel="stylesheet" type="text/css" href="styles/highslide/highslide.css" />
<script type="text/javascript" src="javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
hs.graphicsDir = 'styles/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		<div id="content">
			<div style="height:80px;"></div>
			<div align="left" style="width:74%;margin-left:20px;">
				<div align="left" style="text-align:left;" class="header_text">You're almost finished. We can hardly wait to get your images and started on your Caricature Toons Order.</div>
			</div>
            <table cellpadding="0" cellspacing="0"><tr><td width="70%">
                        <table cellpadding="0" cellspacing="0" width="724" align="center">
                            <tr>
                                <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
                                <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
                                <td><img src="images/top_right_curve.png" /></td>
                            </tr>
                            <tr>
                                <td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
                                <td>
                                <form method="post" action="#" name="billing_information">
                                    <div style="width:700px; margin:auto;background:#FFFFFF;">
                            <div style="height:10px;"></div>
                            <div style="background-color:#ff6e01;"><img src="images/check_out2.gif" alt="checkout" title="Checkout" /></div>
                            <div style="height:10px;"></div>
                            <div style="margin-left:20px;margin-right:30px;border:solid 1px #cecece;border-top:none;">
                                <div style="background:#bad6ec;padding:2px;"><img src="images/billing_address.gif" alt="Billing address" title="Billing address" /></div>
                                <div style="height:20px;font-family:Arial, Helvetica, sans-serif;color:#FF0000;" align="center"><?=$msg;?></div>
                                <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px;color:#000000;padding-left:20px;font-weight:bold;"><span style="color:#FF0000;">*&nbsp;</span><em>Required Fields</em></div>
                                <div style="height:20px;"></div>
                                <div style="margin-top:10px;">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>First Name:</div>
                                    <div style="float:left;margin-left:10px;"><input type="text" value="<?=$user_row['user_fname'];?>" name="bill_fname" id="bill_fname" style="width:300px;" /></div>
                                    <div class="div_text" id="bill_fname_div" style="display:none;float:left;padding-left:10px">*Please enter First Name</div>
                                </div>
                                
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>Last Name:</div>
                                    <div style="float:left;margin-left:10px"><input value="<?=$user_row['user_lname'];?>" type="text" name="bill_lname" id="bill_lname" style="width:300px;" /></div>
                                     <div class="div_text" id="bill_lname_div" style="display:none;float:left;padding-left:10px">*Please enter Last Name</div>
                                </div>
                               
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>Phone Number:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="bill_phno" id="bill_phno" style="width:300px;" value="<?=$user_row['user_phone'];?>" /></div>
                                     <div class="div_text" id="bill_phno_div" style="display:none;float:left;padding-left:10px">*Enter valid Phone number</div>
                                </div>
                                <div style="padding-left:170px;clear:both;padding-top:5px;font-family:Verdana, Arial, Helvetica, sans-serif;color:#828282;font-size:12px">(eg:- 555-555-5555)</div>
                               
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>Email Address:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="bill_email" id="bill_email" style="width:300px;" value="<?=$user_row['user_email'];?>" /></div>
                                    <div class="div_text" id="bill_email_div" style="display:none;float:left;padding-left:10px">*Please enter Email Address</div>
                                </div>
                                
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>Address 1:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="bill_add1" id="bill_add1" style="width:300px;" value="<?=$user_row['user_address1'];?>" /></div>
                                    <div class="div_text" id="bill_add1_div" style="display:none;float:left;padding-left:10px">*Please enter Address 1</div>
                                </div>
                                
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout">Address 2:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="bill_add2" id="bill_add2" style="width:300px;" value="<?=$user_row['user_address2'];?>" /></div>
                                     <div class="div_text" id="bill_add2_div" style="display:none;float:left;padding-left:10px">*Please enter Address 2</div>
                                </div>
                               
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>City:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="bill_city" id="bill_city" style="width:300px;" value="<?=$user_row['user_city'];?>" /></div>
                                     <div class="div_text" id="bill_city_div" style="display:none;float:left;padding-left:10px">*Please enter City</div>
                                </div>
                                
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>Country:</div>
                                    <div style="float:left;margin-left:10px">
                                    <?
                                    $countries=getoption_values('bill_country');
                                        if($user_row['user_country'] == '')$user_row['user_country']='US';
                                    ?>
                                    <select name="bill_country" id="bill_country" onChange="country1()" style="width:196px;">
                                    
                                    <? foreach($countries as $name=> $code)
                                    {?>
                                        <option value="<?=$name?>" <? if($name==$user_row['user_country']) echo 'selected="selected"';?>><?=$code?></option>
                                    <? }?>
                                    </select></div>
                                    <div class="div_text" id="bill_country_div" style="display:none;float:left;padding-left:10px">*Please enter country</div>
                              </div>
                              
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>State/Province:</div>
                                    <div style="float:left;margin-left:10px" id="stat_div"><? if($user_row['user_country']!='US'&&$user_row['user_country']!='CA'){?><input type="text" id="bill_state" name="bill_state" style="width:190px" value="<?=$user_row['user_state'];?>"><? } else {?>
                                    <? 
                                        $states = getoption_values('state',NULL,$user_row['user_country']);
                                    ?>
                                    <select name="bill_state" id="bill_state" style="width:196px;"><option value="">--Select State--</option>
                                    <? foreach($states as $key => $value)
                                    {?>
                                        <option value="<?=$key?>" <? if($key==$user_row['user_state']) echo 'selected="selected"';?>><?=$value?></option>
                                    <? } ?>
                                    </select>
                                    <? }?></div>
                                    <div class="div_text" id="bill_state_div" style="display:none;float:left;padding-left:10px">*Please enter State</div>
                                </div>
                               
                                
                                <div style="padding-top:10px;clear:both;margin-bottom:10px">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout"><span style="color:#FF0000;">*&nbsp;</span>Zip/Postal Code:</div>
                                    <div style="float:left;margin-left:10px"><input name="bill_zip" id="bill_zip" type="text" value="<?=$user_row['user_zipcode'];?>" /></div>
                                    <div class="div_text" id="bill_zip_div" style="display:none;float:left;padding-left:10px">*Please enter Zip Code</div>
                                </div>
                                
                                <div style="height:20px;"></div>
                                <div style="background:#bad6ec;padding:2px;padding-left:9px"><img src="images/cc_info.gif" alt="credit card information" title="credit card information" /></div>
                                <div style="height:20px;"></div>
                                <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px;color:#000000;padding-left:20px;font-weight:bold;"><span style="color:#FF0000;">*&nbsp;</span><em>All Fields Required </em></div>
                                <div style="height:30px;"></div>
                                <div style="margin-top:10px;">
								
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout">Card Type:</div>
									
                                    <div style="float:left;margin-left:10px">
									<select name="type_card" id="type_card" style="width:196px;" >
										<option></option>
										<option value="MasterCard">MasterCard</option>
										<option value="Visa">Visa</option>
										<!--option value="Amex">American Express</option-->
									</select>
									</div>
									<!--<div style="padding-bottom:25px; float:right;"><img border="0" src="images/paypal.gif" alt="paypal" title="paypal" width="70px"/></div>-->
                                    <div class="div_text" id="card_type_error" style="display:none;float:left;padding-left:10px">*Please enter card type</div>
                               
                                 <!--</div>-->
                                <div style="padding-top:10px;clear:both"></div>
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout">Card Number:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="card_number" id="card_number" style="width:300px;" /></div>
                                    <div class="div_text" id="card_number_error" style="display:none;float:left;padding-left:10px">*Please enter card number</div>
                               <!-- </div>-->
                                
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout">Expiration Date:</div>
                                    <div style="margin-left:10px;float:left">
                                   		<input type="text" style="width:50px;" name="card_expiry_month" id="card_expiry_month" onKeyup="autotab(this, document.billing_information.card_expiry_year)" maxlength="2">&nbsp;&nbsp;<span style="font-family:Verdana, Arial, Helvetica, sans-serif;color:#828282;font-size:12px">(mm)</span>
                                  </div>
                                    <div style="float:left">
                                   		 <input type="text" name="card_expiry_year" id="card_expiry_year" style="width:50px;margin-left:12px;" onKeyup="autotab(this, document.billing_information.fname_card)" maxlength="4" />&nbsp;&nbsp;<span style="font-family:Verdana, Arial, Helvetica, sans-serif;color:#828282;font-size:12px">(yyyy)</span></div>
                                    <div class="div_text" id="card_expiry_month_error" style="display:none;float:left;padding-left:10px">*Please enter card expiry month and year</div>
                                </div>
                                <div style="padding-top:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout">Name on Card:</div>
                                    <div style="float:left;margin-left:10px"><input type="text" name="fname_card" id="fname_card" style="width:300px;" /></div>
                                    <div class="div_text" id="fcard_name_error" style="display:none;float:left;padding-left:10px">*Please enter name as in card</div>
                                </div>
                                <div style="padding-top:10px;margin-bottom:10px;clear:both">
                                    <div style="float:left;width:150px;text-align:right;margin-top:4px;" class="checkout">Security Code:</div>
                                    <div style="float:left;margin-left:10px"><input name="card_cvv" id="card_cvv" type="text"  style="width:80px;"/>&nbsp;&nbsp;<span class="checkout_btm_txtlink"><a href="" class="checkout_btm_txtlink" onClick="return hs.htmlExpand(this,{headingText: 'Where is the CVV Number?'})">What is this?</a>
                                    <div class="highslide-maincontent">
                                    <TABLE cellPadding=0 width="100%" border=0>
                                        <TR>
                                          <TD><IMG alt="Visa Verification" 
                                            src="images/cardid_v2.gif"></TD>
                                          <TD><IMG alt="Mastercard Verification" 
                                            src="images/cvc.jpe"></TD>
                                        </TR>
                                        <TR>
                                          <TD colSpan=2>
                                            <P>This number is printed on your MasterCard &amp; 
                                            Visa cards in the signature area of the back of the card. (it is the 
                                            last 3 digits AFTER the credit card number in the signature area of 
                                            the card). </P></TD>
                                        </TR>
                                        <TR>
                                          <TD colSpan=2 height=18></TD>
                                       </TR>
                                        <TR>
                                          <TD vAlign=top colSpan=2 height=180>
                                            <DIV align=center><IMG alt="American Express Verification" src="images/amexco.gif" width="278" height="169"></DIV>
                                          </TD>
                                        </TR>
                                        <TR>
                                
                                          <TD colSpan=2>
                                            <P>You can find your four-digit card verification 
                                            number on the front of your American Express credit card above the 
                                            credit card number on either the right or the left side of your 
                                            credit card.</P>
                                         </TD>
                                       </TR>
                                    </TABLE>
                                    </div>
                                    </span></div>    </div>
									
							<div style="float:right;margin-top:-210px; margin-right:10px;">
							<img border="0" src="images/pay_logo.jpg" alt="paypal" title="paypal" width="220px"/>
							</div>
                                    <div class="div_text" id="card_cvv_error" style="display:none;float:left;padding-left:10px">*Please enter security code</div>
                                </div>
                                
                                <div style="height:25px;"></div>
                          <!--  </div>-->
                            
                            <div style="color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:13px;margin-left:20px;margin-top:10px;">
                                These <span class="checkout_btm_txtlink"><a href="" onClick="return hs.htmlExpand(this,{headingText: 'Terms of Service'})" style="color:#3366CC; text-decoration:none" >Terms of Service</a>
							<div class="highslide-maincontent">
							<b>BY CLICKING "PLACE ORDER" YOU AGREE TO ALL THE "TERMS OF
							SERVICE" LISTED BELOW</b><br /><br />
							<b>100% MONEY BACK GUARANTEE IS FOR CARICATURE TOONS ONLY.</b><br />
							If your not 100% happy with the final result, based on your original instructions
							and photo's supplied and after giving the Artist the ample opportunity to make
							the necessary changes, we refund your money. No questions asked. The 100%
							Money back guarantee does not apply if you decided to change Artists after
							you have placed your initial order. Each Artist is freelance and independent of
							each other and you are committed to their style to completion. Once you have
							approved the final image, which is defined by you downloading the Caricature
							Toon and the proof watermark being removed, you are no longer eligible for
							a refund. Once the final Character Toon has been downloaded you cannot
							requests changes or revisions without paying an additional cost.<br /><br />
							 <b>100%SATISFACTION GUARANTEE FOR PRODUCTS AND MERCHANDISE</b><br />
							If products or merchandise are lost or damaged in shipping, or arrives with
							any workmanship defects, we will replace it. All we ask is that you report any
							problems to us within 48 hours of accepting shipment. After an order has been
							placed we do not allow order cancellation or refunds.<br /><br />
							<b>OWNERSHIP OF FINAL CARICATURE TOON</b><br />
							All Caricature Toons ordered are 100% Royalty Free to the customer to be used
							how they like. Caricature Toons reserves the right to use any Caricature Toon and
							original Images supplied in their marketing materials or promotional materials
							without formal consent of the customer.<br /><br />
							<b>PRIVACY POLICY</b><br />
							We do not share or sell your personal information or email address with anyone.
							From time to time we may send you information or special offers, however, if
							you prefer not to receive them, you can easily unsubscribe at any time. We do
							reserve the right to use your Caricature Toon and original images supplied in our
							marketing or promotional materials.<br /><br />
							This Caricaturetoons Terms of Service Agreement (the "Agreement") is an
							agreement between you and Caricaturetoons, Inc ("Caricaturetoons"). This
							Caricaturetoons Web site and the products and services offered thereby (the
							Service) is owned and operated by Caricaturetoons, Inc. The following terms
							and conditions apply to your use of our Services. Please read this Agreement
							carefully before you enter our Web site. In this Agreement, "you" or "your" means
							any person or entity using the Service. Unless otherwise stated, "we" or "our" will
							refer collectively to Caricaturetoons, Inc. and its subsidiaries, affiliates, directors,
							officers, employees, agents and contractors.<br /><br />
							By clicking "I Agree" or "Order Now" you agree to the Agreement, the
							Caricaturetoons Privacy Policy, and any documents incorporated by reference.
							You further agree that this Agreement forms a legally binding contract between
							you and Caricaturetoons, and that this Agreement constitutes "a writing signed
							by You" under any applicable law or regulation effective as of the date you
							click "I Agree or Buy Now". I also understand that as a result of agreeing to
							this statement, a digital confirmation of my acceptance will be marked in my
							Caricaturetoons account record as verification of my approval of this condition.<br /><br />
							<b>ACCOUNTS</b><br />
							A. Eligibility To use the Service, you must open an account with Caricaturetoons,
							which means you must register with Caricaturetoons on the Web site and agree
							to the terms of this Agreement (Account). You must be at least 18 years of age
							to use the Service. By using our Service, you certify that you are at least 18
							years of age and that you agree to be bound by these terms and conditions of
							use. If you do not agree to be bound by this Agreement or if you are not at least
							18 years of age, please immediately exit the site. B. Use Your Caricaturetoons
							Account is available for your non-commercial, personal use. Your Account can
							be utilized to post photographs that you want to let other specified people view
							and purchase. You can also use your Account to view photographs in other
							Accounts if you have been authorized by that account holder. Any photographs
							in your account are password protected unless you allow other Caricaturetoons
							Account holders access to such photographs. Caricaturetoons reserves the right to
							cancel or discontinue Accounts which have been inactive for more than 60 days.
							We may do so at our discretion after sending an email warning to the address
							you used when you set up your Account. If you do not respond to the email
							within 10 days, your account may be removed. You may not use your Account to
							create an Internet link to eBay or any other web site without the express written
							permission of Caricaturetoons.<br /><br />
							<b>PHOTOGRAPHS AND PRODUCTS</b><br />
							A. You can purchase the photographs featured on our Web site
							Caricaturetoons in the form of photographic prints, or other photographic products
							such as picture frames or photo-albums (collectively, the "Products"). You
							acknowledge that all Products are custom made to your order and have no
							market beyond your purchase thereof. As such, all Products are non-returnable
							and payment for all Products is required to be made in full in advance. All items
							purchased through Caricaturetoons and shipped to you are subject to a shipment
							contract under which the risk of loss and title for such items pass to you upon
							our delivery to our shipping carrier.  B. You may not reproduce, display, transmit,
							distribute or otherwise exploit the Products, or any portion thereof, in any
							manner, including, without limitation, print or electronic reproduction, publication
							or any display of photographs, without the prior written consent of Caricaturetoons.
							While you can add captions and descriptions to the photographs in your account
							in accordance with the terms hereof, you agree not to otherwise modify, alter
							or otherwise manipulate any Product, including without limitation, adding other
							material to a Product, without Caricaturetoons's prior written consent.  C. While
							Caricaturetoons uses reasonable efforts to ensure compliance with applicable
							laws relating to rights of privacy or publicity, including the use of subject releases
							when necessary and requiring the photographers to screen the photographs
							posted on the Web site, it makes no representations or warranties as to the
							accuracy, correctness or reliability of the photographs, nor can Caricaturetoons
							ensure that all persons depicted in the photographs have consented to the
							display of their image on this Web site. If your photograph appears on this Web
							site and you wish to have it removed, please copy the thumbnail image and e-
							mail it to <a href="mailto:helper@caricaturetoons.com">helper@caricaturetoons.com</a> with a description of why you would like it
							removed.<br /><br />
							<b>YOUR COPYRIGHTS</b><br />
							Caricaturetoons respects the copyrights, real and implied, of photographers,
							Artists and/or other copyright holders. Caricaturetoons will not knowingly print
							and/or distribute images without the consent of the creator or owner of the
							copyrights. The copyrights in the photographs are owned by the photographers
							thereof who have licensed to Caricaturetoons the right to post them on the
							Web site and provide the Services offered. Caricaturetoons makes no claim of
							ownership to any images uploaded to our servers by our customers. Since
							we cannot research every image transmitted to us or printed by us, it is your
							sole responsibility to ensure that you have the necessary authorizations and/or
							permissions to use the images. If you believe your copyright in a work has been
							violated through this service, please contact Caricaturetoons for notice of claims
							of copyright infringement at <?=$_CONFIG['email_contact_us']?> Caricaturetoons, Inc.,
							1890 Beaver Ridge Circle, Suite A, Norcross Georgia, 30071, 415.935.6285<br /><br />
							<b>CONTENT</b><br />
							A. Limits
							You may NOT post or obtain any content using the Web site which: Is
							threatening, obscene, pornographic or profane material or any other material
							that could give rise to any civil or criminal liability under applicable law.
							Caricaturetoons recommends you use, an "adult-content" warning label when
							pictures are being shared that include legal adult content; Infringes rights of
							privacy, publicity or copyrights or otherwise uses content without the permission
							of the owner of these rights and the persons (or their parents or legal guardians,
							where applicable) who are shown in the material.  B. Content Monitoring While
							Caricaturetoons does not and cannot review all content provided to it, and is not
							responsible for such content, Caricaturetoons reserves the right to delete, edit
							or rearrange content that it, in its sole discretion, deems abusive, defamatory,
							obscene or in violation of copyright or trademark laws or otherwise unacceptable.
							You acknowledge that any content may be removed, published, copied, modified,
							transmitted and displayed by Caricaturetoons for the purposes of delivering
							the offered services. All content provided by a user of this service is the sole
							responsibility of that user, not Caricaturetoons.  C. Unauthorized Content If you
							send any image to the Web site which violates any term of this Agreement or any
							applicable law or regualtion, for example copyrighted or pornographic material,
							Caricaturetoons reserves the right to retain the image and charge your Account the
							full amount for the Service that you requested.<br /><br />
							<b>DISCLAIMERS</b><br />
							THIS WEB SITE AND ITS CONTENT (INCLUDING WITHOUT LIMITATION
							THE PHOTOGRAPHS) ARE PROVIDED "AS IS" AND CARICATURE TOONS
							MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EITHER
							EXPRESS OR IMPLIED, ABOUT THE IMAGES OR WEB SITE INCLUDING,
							WITHOUT LIMITATION, WARRANTIES OF MERCHANTABILITY, FITNESS
							FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT, TO THE
							FULLEST EXTENT PERMISSIBLE UNDER APPLICABLE LAW. CARICATURE
							TOONS DOES NOT WARRANT THAT ACCESS TO THE WEB SITE OR
							ITS CONTENTS WILL BE UNINTERRUPTED OR ERROR-FREE, THAT
							DEFECTS WILL BE CORRECTED, OR THAT THIS SITE OR THE SERVER
							THAT MAKES IT AVAILABLE ARE FREE OF VIRUSES OR OTHER HARMFUL
							COMPONENTS. CARICATURE TOONS DOES NOT WARRANT OR MAKE ANY
							REPRESENTATIONS REGARDING THE USE OR THE RESULTS OF THE
							USE OF ANY CONTENT ON THIS SITE IN TERMS OF ITS CORRECTNESS,
							ACCURACY, RELIABILITY, OR OTHERWISE. ACCORDINGLY, YOU
							ACKNOWLEDGE THAT YOUR USE OF THIS WEB SITE IS AT YOUR OWN
							RISK. YOU (AND NOT CARICATURE TOONS) ASSUME THE ENTIRE COST
							OF ALL NECESSARY SERVICING, REPAIR, OR CORRECTION RESULTING
							FROM COMPUTER MALFUNCTION, VIRUSES OR THE LIKE. APPLICABLE
							LAW MAY NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES, SO
							THE ABOVE EXCLUSION MAY NOT APPLY TO YOU.<br /><br />
							<b>LIMITATION OF LIABILITY</b><br />
							Neither Caricaturetoons, nor its licensors or representatives, shall be responsible
							or liable for any damages of any kind including, without limitation, lost business
							or profits, direct, indirect, incidental, consequential, compensatory, exemplary,
							special or punitive damages that may result from your access to or use of
							either this Web site or the photographs or Products. You acknowledge that the
							photographers are independent contractors of Caricaturetoons and if you are not
							satisfied with the photographs or Products in any way, you shall look solely to
							such photographer(s), and not to Caricaturetoons, for any damages and/or claims
							whatsoever relating to the photographs or Products.<br /><br />
							<b>INDEMNIFICATION</b><br />
							In the event that you reproduce, display, transmit, distribute or otherwise
							exploit the photographs or Products, or any portion thereof, in any manner not
							authorized by Caricaturetoons, or if you otherwise infringe any intellectual property
							rights or any other rights relating to the photographers, photographs, Products or
							this Web site, you agree to indemnify and hold Caricaturetoons, its subsidiaries,
							affiliates, licensors and representatives, harmless against any losses, expenses,
							costs or damages, including reasonable attorneys' fees, incurred by them as a
							result of unauthorized use of the photographs or Products and/or your breach or
							alleged breach of these terms of this Agreement.<br /><br />
							<b>OWNERSHIP OF OUR WEB SITE</b><br />
							All of the content (other than the photographs) on our Web site, including without
							limitation, the graphics, design, and look and feel are owned by Caricaturetoons
							and are protected by United States and international copyright, trademark,
							patent, trade secrets and other intellectual property rights protection. The
							Caricaturetoons logos are trademarks owned by Caricaturetoons and may not be
							used or reproduced without our written permission. In addition, you may not
							reverse engineer, de-compile, or otherwise disassemble software included on
							this Web site.<br /><br />
							<b>THIRD-PARTY SOFTWARE</b><br />
							Caricaturetoons may make software from third-party companies available to you.
							To download such software, you may be required to agree to the respective
							software licenses and/or warranties of such third-party software. Each software
							product is subject to the individual company's terms and conditions, and the
							agreement will be between you and the respective company. This means that
							Caricaturetoons does not guarantee that any software you download will be free
							of any contaminating or destructive code, such as viruses, worms or Trojan
							horses. Caricaturetoons does not offer any warranty on any third-party software
							you download using the Web site.<br /><br />
							<b>LINKED INTERNET SITES</b><br />
							Caricaturetoons may make software from third-party companies available to you.
							To download such software, you may be required to agree to the respective
							software licenses and/or warranties of such third-party software. Each software
							product is subject to the individual company's terms and conditions, and the
							agreement will be between you and the respective company. This means that
							Caricaturetoons does not guarantee that any software you download will be free
							of any contaminating or destructive code, such as viruses, worms or Trojan
							horses. Caricaturetoons does not offer any warranty on any third-party software
							you download using the Web site.<br /><br />
							A. Third Party Links<br />
							Our Web site may provide a link to other sites by allowing the user to leave this
							Site to access third-party material or by bringing the third-party material into this
							Web site via hyperlinks and framing technology (a "Linked Site"). Caricaturetoons
							has no discretion to alter, update, or control the content on a Linked Site. The fact
							that Caricaturetoons has provided a link to a site is not an endorsement,
							authorization, sponsorship, or affiliation with respect to such site, its owners, or its
							providers. There are inherent risks in relying upon using, or retrieving any
							information found on the internet, and Caricaturetoons, urges you to make sure
							you understand these risks before relying upon, or retrieving any such
							information on a Linked Site. It is your responsibility to become familiar with each
							site's privacy and other policies and terms of service, and to contact that site's
							webmaster or site administrator with any concerns.  B. You May Not Create a Link
							to Our Web site Caricaturetoons prohibits caching, unauthorized hypertext links to
							the Web site and the framing of any content available through the Web site.
							Caricaturetoons reserves the right to disable any unauthorized links or frames and
							specifically disclaims any responsibility for the content available on any other
							Internet sites linked to the Web site. You may not create a link to our Website
							without the express written permission of Caricaturetoons.<br /><br />
							<b>INTERNATIONAL USE</b><br />
							Caricaturetoons makes no representation that materials on this site are
							appropriate or available for use in locations outside of North America,
							and accessing them from territories where their contents are illegal is
							prohibited. Those who choose to access this site from other locations do so
							on their own initiative and are responsible for compliance with local laws.<br /><br />
							<b>OTHER TERMS</b><br />
							These terms shall be governed by and construed in accordance with the laws of
							the Province of Ontario, without giving effect to any principles of conflicts of law.
							You agree that any action at law or in equity arising out of or relating to these
							terms shall be filed only in the state or federal courts located in Toronto, Ontario
							and you hereby consent and submit to the personal jurisdiction of such courts
							for the purposes of litigating any such action. If any provision of these terms
							shall be unlawful, void, or for any reason unenforceable, then that provision
							shall be deemed severable from these terms and shall not affect the validity and
							enforceability of any remaining provisions. You acknowledge and agree that
							except as specified herein, no representations, warranties or promises of any
							kind have been made to you by Caricaturetoons regarding the use of the Web site
							or the use or purchase of the photographs or the Products.<br />
							
							</div>
						  </span> apply to your purchase.</div>
                            <div style="color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:13px;margin-left:20px;margin-top:20px;">By placing your order, you agree to our Terms.</div>
                            <div style="text-align:right;margin-top:10px;" class="margin_right30"><a href="order-caricature.php"><img src="images/cancel2.gif" border="0" alt="cancel" title="Cancel" /></a>&nbsp;<input type="image" name="ok" onClick="return validate()" src="images/place_order.gif" alt="place order" title="Place order" border="0" /></div>
                            <div class="height20"></div>
                        </div>
                                </form>
                                </td>
                                <td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
                            </tr>
                            <tr>
                                <td><img src="images/btm_left_curve.png" /></td>
                                <td style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
                                <td><img src="images/btm_right_curve.png" /></td>
                            </tr>
                        </table>
                        </td>
                        <td width="30%"  valign="top">
                            <div>
                            <table cellpadding="0" cellspacing="0" width="100%" >
                                <tr>
                                    <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
                                    <td width="413" style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
                                    <td width="26"><img src="images/top_right_curve.png" /></td>
                                </tr>
                                <tr>
                                    <td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
                                    <td valign="top" bgcolor="#FFFFFF">
                                        <table cellpadding="0" cellspacing="0" border="0" width="95%"  align="center">
                                        <tr><td width="27%"  height="15" colspan="2"></td>
                                        </tr>
                                    <tr bgcolor="#FF6E01">
                                    <td   height="40" align="center" colspan="3" valign="middle"><img src="images/order_summery.gif" border="0" /></td>				
                                    </tr>
                                    <tr><td colspan="3" height="10"></td></tr>
                                    <tr><td valign="top"><table cellpadding="0" cellspacing="5" border="0" width="92%"  align="center"><tr>
                                    <td width="76" height="16" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><b>Caricatures By</b></td>
                                    <td width="149" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><b>Details</b></td>
                                    <td width="62" align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><b>Product</b></td>
                                    </tr>
                                   <tr>
                                    <td width="76" height="16" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><?=$artist_row['user_fname']; ?></td>
                                    <td width="149" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><?=$biling_ord_row['order_people_count'];if($biling_ord_row['order_people_count']==1) {?>&nbsp;person<? } else{?>&nbsp;people<? }?>,<br> <?=$biling_ord_row['order_props'].' Props';?></td>
                                    <td width="62" align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-size:12px;" ><?=$product_row['product_title']; ?></td>
                                    </tr>
                                    <tr><td colspan="3" valign="top">
                                        <table cellpadding="0" cellspacing="5" border="0" width="100%">
                                        <tr>
                                        <td width="70%" align="right" class="normal_font"><b>Order Total :</b></td>
                                        <td width="30%" align="right" class="normal_font" >$&nbsp;<?=number_format($biling_ord_row['order_price'],2);?></td>
                                        </tr>
                                        <tr><td colspan="2" height="5" align="right"><img src="images/dot_border.gif" /></td></tr>
                                        <tr><td colspan="2">
                                            <table  cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr><td colspan="2"  height="5"></td></tr>
                                        <tr><td colspan="2"  height="5"></td></tr>					
                                        <tr><td colspan="2"  height="15"></td></tr>
                                        </table>
                                        </td></tr>
                                        </table>
                                    </td></tr>
                                    </table></td></tr>
                                    </table>
                                        </td>
                                    <td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
                                </tr>
                                <tr>
                                    <td><img src="images/btm_left_curve.png" /></td>
                                    <td style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
                                    <td><img src="images/btm_right_curve.png" /></td>
                                </tr>
                            </table>
                            </div>
        				 </td>
                   </tr>
             </table>
		</div>
		
		<!--content ends-->	
		<!--footer-->	
<? include (DIR_INCLUDES.'footer.php') ?>