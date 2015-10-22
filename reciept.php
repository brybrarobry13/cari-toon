<?  include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	$payment = $_POST['payment'];
	if(!isloggedIn()) {
		header('Location:alogin.php?back_to=order-caricature.php');
		exit();
	}
	if($payment!=1 && $payment!=0){
		header('Location:m-order.php');
		exit();
	}
	include (DIR_INCLUDES.'header.php'); 
	
	$u_id=$_SESSION['sess_tt_uid'];
	$getuserDetails = getUserDetails($u_id);
	$ord_id=$_REQUEST['ord_id'];
	$biling_ord_query = mysql_query("SELECT *,DATE_FORMAT(`order_date`,'%m-%d-%Y') as `order_date` FROM `toon_orders` WHERE `order_id`='$ord_id' AND `user_id`='$u_id'");
	$biling_ord_row=mysql_fetch_array($biling_ord_query); 
	$product_query = mysql_query("SELECT * FROM `toon_products` WHERE `product_id`='$biling_ord_row[product_id]'");
	$product_row=mysql_fetch_array($product_query);
	$artist_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$biling_ord_row[artist_id]'");
	$artist_row=mysql_fetch_array($artist_query);
	$promo_type = $biling_ord_row['promo_type'];
	if($promo_type == 'spl coupans') {
		$pcode_query = mysql_query("SELECT * FROM `toon_special_coupons` WHERE `spc_id`='$biling_ord_row[promo_id]'");
		$pcode_row=mysql_fetch_array($pcode_query);
		$pcode=$pcode_row['spc_code'];
	} else {
		$pcode_query = mysql_query("SELECT * FROM `toon_promo` WHERE `promo_id`='$biling_ord_row[promo_id]'");
		$pcode_row=mysql_fetch_array($pcode_query);
		$pcode=$pcode_row['promo_code'];
	}
	$image_query = mysql_query("SELECT * FROM `toon_order_images` WHERE `order_id`='$ord_id'");
	while($image_row=mysql_fetch_array($image_query))
	{
	$images.=$image_row[order_image_name].'<br>';
	}
	$user_email_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$u_id'");
	$user_email_row=mysql_fetch_array($user_email_query);
	$deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD(NOW(), INTERVAL  '$product_row[product_turnaroundtime]' DAY)"));
	$no_people=$biling_ord_row['order_people_count'];
	$product_id=$biling_ord_row['product_id'];
	$props = $biling_ord_row['order_props'];
	$price_details=price($no_people,$product_id,$pcode,$props);
	if($pcode)
	{
		mysql_query("UPDATE `toon_special_coupons` SET `spc_isused` = '1' WHERE `spc_code` = '$pcode'");
	}
	
	//mail to customer
	$from			= $_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
	$cc 			= "orders@caricaturetoons.com";
	$to				= $user_email_row['user_email'];
	$usr_city		= $user_email_row['user_city'];
	$usr_state		= $user_email_row['user_state'];
	$usr_country	= $user_email_row['user_country'];
	$subject		= 'Thank You For Your Order - Receipt';
	$message 		= 'Thank you for your Caricature Toons Order. We’re excited to get started.<br><br>
	
We will send you an email once your Toon is ready. You’ll be able to review it by logging in to the MY TOONS section of our website. We expect we’ll have your proof ready by '.date("m-d-Y",strtotime($deadline[0])).'.<br><br>
	
At anytime you can also communicate directly to your Toonist through our website. Just log into the MY TOONS section and click the TALK TO YOUR TOONIST LINK.<br><br>
	
If at anytime you have questions or require assistance, please email us at '.$_CONFIG['email_contact_us'].'<br><br>
	
Life should always be fun!!!<br><br>
	
The Captoon<br>
www.caricaturetoons.com<br><br>	
	
Order Details<br><br>
	
Order ID # '.$ord_id.'<br>
Date : '.date("m-d-Y").'<br>
Customer : '.$user_email_row['user_fname'].'<br>
Toonist : '.$artist_row[user_fname].'<br>
Style : '.$product_row[product_title].'<br>

No of People in Toon : '.$biling_ord_row[order_people_count].'<br>
Cost :  '.$price_details[0].' U.S<br>
Discounts :  '.$price_details[1].' U.S<br>
Total : $ '.$price_details[2].' U.S<br>';
	$header = "From: ".$from."\n";
	$headers .= "Cc: ".$cc."\n";
	$header .= "MIME-Verson: 1.1\n";
	$header .= "Content-type:text/html; charset=iso-8859-1\n";
	if($payment==1)
	{
		mail($to,$subject,$message,$header);
	}
	
	//mail to artist
	$wholesale_price = number_format($biling_ord_row['order_wholesale_price'],2,'.',',');
	$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
	$to=$artist_row['user_email'];
	$subject='New Order Notification';
	$message ='Hi '.$artist_row[user_fname].',<br><br>You have a new order<br><br>Order ID # '.$ord_id.'<br>Date : '.date("m-d-Y").'<br>Customer : '.$user_email_row['user_fname'].'<br>No of People : '.$biling_ord_row[order_people_count].'<br>Artist Style : '.$product_row[product_title].'<br>Wholesale price : $'.$wholesale_price.'<br>Deadline : '.date("m-d-Y",strtotime($deadline[0])).'<br>Caricature Request Requirements as the header : '.$biling_ord_row[order_instructions].'<br><br>If at anytime you have questions or require assistance, please email us at '.$_CONFIG['email_contact_us'].'<br><br>Life should always be fun!!!<br><br>The Captoon<br>www.caricaturetoons.com';
	$header = "From: ".$from."\n";
	$header .= "MIME-Verson: 1.1\n";
	$header .= "Content-type:text/html; charset=iso-8859-1\n";
	if($payment==1) {
		mail($to,$subject,$message,$header);
	}
	
	//mail to admin
	$to      = $_CONFIG['email_admin'];
	$subject = "Order ID ".$ord_id." payment complete";	
	$message ='';
	$from    = $_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
	$header = "From: ".$from."\n";
	$header .= "MIME-Verson: 1.1\n";
	$header .= "Content-type:text/html; charset=iso-8859-1\n";
	$message = "Date:".date('m-d-Y')."<br /> Order ID:". $ord_id ."<br /><br />
	 The Caricature Toon with Order ID {$ord_id} payment is complete.<br /><br />
	 The details are given below:<br />
	<b> Customer   : </b> {$user_email_row['user_fname']} {$user_email_row['user_lname']}<br />
	 <b> Artist     : </b> {$artist_row[user_fname]} {$artist_row[user_lname]}<br />
	 <b> Product    : </b> {$product_row[product_title]}<br />
	 <b> Wholesale price :</b> $".$wholesale_price."<br>
	 <b> Total Cost : </b> $".$biling_ord_row[order_price]."<br />
	 <b> Order Date : </b> ".date('d-m-Y',strtotime($biling_ord_row['order_date']))."<br />
	 <b> Deadline :</b> ".date('m-d-Y',strtotime($deadline[0]))."<br>";  
	if($payment==1) {
		mail($to,$subject,$message,$header);
	}
?>
<!--header ends-->
<!--content starts-->
<link href="styles/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26958699-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_addTrans',
    '<?=$ord_id?>',           				// order ID - required
    'Caricaturetoons Order',  				// affiliation or store name
    '<?=$biling_ord_row[order_price]?>',    // total - required
    '',           							// tax
    '',              						// shipping
    '<?=$usr_city?>',       				// city
    '<?=$usr_state?>',     					// state or province
    '<?=$usr_country?>'             		// country
  ]);

   // add item might be called for every item in the shopping cart
   // where your ecommerce engine loops through each item in the cart and
   // prints out _addItem for each
  _gaq.push(['_addItem',
    '<?=$ord_id?>',   						// order ID - required
    'CARI2011',        						// SKU/code - required
    'ToonOrder',       						// product name
    'Order Now',   							// category or variation
    '<?=$biling_ord_row[order_price]?>',    // unit price - required
    '1'               						// quantity - required
  ]);
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!-- Google Code for Caricature Purchase Conversion Page -->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 956900108;

var google_conversion_language = "en";

var google_conversion_format = "3";

var google_conversion_color = "ffffff";

var google_conversion_label = "5KLGCPTelgMQjMakyAM";

var google_conversion_value = 0;

/* ]]> */

</script>

<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/956900108/?label=5KLGCPTelgMQjMakyAM&amp;guid=ON&amp;script=0"/>

</div>

</noscript>
<table cellpadding="0" cellspacing="0">
  <tr>
    <td width="70%"><table cellpadding="0" cellspacing="0" width="724" align="center">
        <tr>
          <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
          <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
          <td><img src="images/top_right_curve.png" /></td>
        </tr>
        <tr>
          <div style="height:40px;"></div>
          <td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
          <td><form method="post" action="<?=$_SERVER['PHP_SELF']?>" >
              <div style="width:700px; margin:auto;background:#FFFFFF;">
                <div style="height:10px;"></div>
                <div style="background-color:#ff6e01;"><img src="images/thank_you.gif" alt="thank you for your order" title="Thank you for your order"  /></div>
                <div style="height:10px;"></div>
                <div style="margin-left:20px;margin-right:30px;border:solid 1px #cecece;">
                  <div style="margin-left:20px;margin-top:20px;margin-right:30px;" class="text_blue">Thank you for your Caricature Toons Order. Your Caricaturist is excited to get transform your images. A receipt will be emailed to you or you can  <a style="cursor:pointer;" onclick="print()">print</a> this page.
                    <p>&nbsp; </p>
                    <p>We will send you an email once your Caricature Toon is ready. You'll be able to review your caricatures by logging in to the MY TOONS section of our website. Your Artist will have your proof ready by <?=date("m-d-Y",strtotime($deadline[0]))?>.
                    <p>&nbsp; </p>
                    <p>At anytime you can also communicate directly to your Toonist through our website. Just log into the MY TOONS section and click the TALK TO YOUR TOONIST LINK.
                    <p>&nbsp; </p>
                    <p>If at anytime you have questions or require assistance, please email us at<br /><a style="text-decoration:none;" href="mailto:<?=$_CONFIG['email_contact_us']?>"><?=$_CONFIG['email_contact_us']?>.</a></p>
                    <p>&nbsp; </p>
                    <p>Life should always be fun!!!<br /><br />The Captoon</p>
                    </p>
                    </p>
                  </div>
                  <div style="height:20px;"></div>
                  <div style="margin-top:10px;">
                    <div style="width:120px;text-align:left;margin-top:4px;padding-left:15px" class="orange_txt">Order Details</div>
                  </div>
                  <div style="margin-top:10px;">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Order Id</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$biling_ord_row['order_id'];?>
                    </div>
                  </div>
                  <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Date</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$biling_ord_row['order_date'];?>
                    </div>
                  </div>
                  <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Customer</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$getuserDetails['user_fname'].' '.$getuserDetails['user_lname'];?>
                    </div>
                  </div>
                  <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Toonist</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$artist_row['user_fname'];?>
                    </div>
                  </div>
                  <div style="padding-top:10px;margin-bottom:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Style</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$product_row['product_title']; ?>
                    </div>
                  </div>
                  <!--<div style="padding-top:10px;margin-bottom:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Props</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?//=$biling_ord_row['order_props']; ?>
                    </div>
                  </div>-->
                  <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">No of People in Toon</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$biling_ord_row['order_people_count'];if($biling_ord_row['order_people_count']==1) {?>
                      &nbsp;person
                      <? } else{?>
                      &nbsp;people
                      <? }?>
                    </div>
                  </div>
                  <div style="padding-top:10px;margin-bottom:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Cost</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px;margin-top:4px;" class="text_blue">$&nbsp;
                      <?=$price_details['0'];?>
                      U.S</div>
                  </div>
                  <div style="padding-top:10px;margin-bottom:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Discount</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px;margin-top:4px;" class="text_blue">$&nbsp;
                      <?=$price_details['1'];?>
                      U.S</div>
                  </div>
                  <div style="padding-top:10px;margin-bottom:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Total</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px;margin-top:4px;" class="text_blue">$&nbsp;
                      <?=$price_details['2'];?>
                      U.S</div>
                  </div>
                  <div style="height:25px;"><img src="https://shareasale.com/sale.cfm?amount=<?=$price_details['2'];?>&tracking=<?=$biling_ord_row['order_id'];?>&transtype=sale&merchantID=27079" width="1" height="1"></div>
                </div>
                <div class="height20"></div>
              </div>
            </form></td>
          <td style="background:url(images/right_shadow.png) repeat-y left"><img src="images/blank.png" /></td>
        </tr>
        <tr>
          <td><img src="images/btm_left_curve.png" /></td>
          <td style="background:url(images/shadow_btm.png) repeat-x top;"><img src="images/blank.png" /></td>
          <td><img src="images/btm_right_curve.png" /></td>
        </tr>
      </table></td>
  </tr>
</table>
<!--content ends-->
<!--footer-->
<? include (DIR_INCLUDES.'footer.php') ?>

<img src="https://referzo.com/transact.php?merchant=249&amount=<?=$biling_ord_row[order_price]?>&order=<?=$ord_id?>" width="1px" height="1px" />