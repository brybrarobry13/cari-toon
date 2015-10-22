<?  include("includes/configuration.php");
	include(DIR_INCLUDES.'functions/orders.php');
	$payment=$_GET['payment'];
	$u_id=$_SESSION['sess_tt_uid'];
	$cart_id=$_GET['cart_id'];
	
	if(!isloggedIn())
	{
		header('Location:alogin.php?back_to=order-caricature.php');
		exit();
	}
	if($cart_id=="" || $payment!=1)
	{
		header('Location:shoppingcart.php');
		exit();
	}
	
	$cartarray_rs=mysql_query("SELECT TEOP.*,TC.*,T.*,TU.user_email FROM `toon_cart`TC,`toon_ez_order_products`TEOP,`toon_users`TU,`toon_shipping_address`T WHERE TEOP.user_id=$u_id  AND TC.user_id=$u_id AND TEOP.cart_id='$cart_id' AND TC.cart_id='$cart_id' AND TU.user_id=$u_id AND T.ezopro_id=TEOP.ezopro_id AND T.user_id=$u_id ");
	$cartarray_row=mysql_fetch_array($cartarray_rs);
	$number=mysql_num_rows($cartarray_rs);
	$cart=unserialize(base64_decode($cartarray_row['cart_array']));
	if($number==0)
	{
		header('Location:buy-caricature-gift.php');
		exit();
	}
	
	$k=1;
	foreach ($cart as $key=>$name)
	{
	
	$total_email+=$name['totalprice'];
	$table='<tr style="text-align:center">
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;line-height:25px;">'.$k.'</td>
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">'.$name['ezproduct_name'].'</td>
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">'.$name['number'].'</td>
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">$&nbsp;'.number_format($name['ezproduct_price'],2).' U.S</td>
		
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;'.number_format($name['totalprice'],2).' U.S</td>
	</tr>';
	
	$whole_table.=$table;
	$k++;
	 }
	 $discount=$total_email+$cartarray_row['ship_price']-$cartarray_row['ezopro_totalprice'];
	$from=$_CONFIG['site_name']."< ".$_CONFIG['email_outgoing']." >";
	$to=$cartarray_row['user_email'];
	$subject='Thank You For Your Order – Receipt';
	$message ='<table cellpadding="2" cellspacing="2" align="center" border="0" style="border:1px solid #CCCCCC;" width="100%">
	<tr>
		<td align="center"><img src="'.$_CONFIG[site_url].'images/logo.png" width="327" height="122" border="0"/></td>
	</tr>
	<tr>
		<td style="font:bold 14px arial;">Order Receipt : Order #&nbsp;'.$cart_id.'</td>
	</tr>
	<tr>
		<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;font-family:Arial, Helvetica, sans-serif;font-size:14px;">Ordered Date : '.date("m-d-y",strtotime($cartarray_row[ezopro_posted])).'</td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-top:1px solid #CCCCCC;border-left:1px solid #CCCCCC;font-family:Arial, Helvetica, sans-serif;font-size:14px;">
					<tr>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;line-height:25px;">Sl No.</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Product</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Quantity</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Unit Price</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:center;">Total Price</td>
					</tr>
                    
                    '.$whole_table.'
                    
                    <tr align="right">
						<td colspan="4" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Shipping Cost:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;'.number_format($cartarray_row[ship_price],2).' U.S</td>
					</tr>
					<tr align="right">
						<td colspan="4" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Discount:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;'.number_format($discount,2).' U.S</td>
					</tr>
					<tr align="right">
						<td colspan="4" style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:right;line-height:25px;">Grand Total:						</td>
						<td style="border-bottom:1px solid #CCCCCC;border-right:1px solid #CCCCCC;text-align:left;">&nbsp;&nbsp;$&nbsp;'.number_format($cartarray_row[ezopro_totalprice],2).' U.S</td>
					</tr>
					
					
			</table>		</td>
	</tr>
</table>';
$header = "From: ".$from."\n";
$header .= "MIME-Verson: 1.1\n";
$header .= "Content-type:text/html; charset=iso-8859-1\n";
mail($to,$subject,$message,$header);
include (DIR_INCLUDES.'header.php');
?> 
<!-- Google Code for Product Purchase Conversion Page -->

<script type="text/javascript">

/* <![CDATA[ */

var google_conversion_id = 956900108;

var google_conversion_language = "en";

var google_conversion_format = "3";

var google_conversion_color = "ffffff";

var google_conversion_label = "hx96COzflgMQjMakyAM";

var google_conversion_value = 0;

/* ]]> */

</script>

<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/956900108/?label=hx96COzflgMQjMakyAM&amp;guid=ON&amp;script=0"/>

</div>

</noscript>

		<!--header ends-->
		<!--content starts-->
		<link href="styles/style.css" rel="stylesheet" type="text/css" />
		<table cellpadding="0" cellspacing="0">
  <tr>
    <td width="70%"><table cellpadding="0" cellspacing="0" width="724" align="center">
        <tr>
          <td height="12" valign="bottom" align="left"><img src="images/top_left_curve.png" /></td>
          <td style="background:url(images/shadow_top.png) repeat-x bottom; font-size:2px;">&nbsp;</td>
          <td><img src="images/top_right_curve.png" /></td>
        </tr>
        <tr>
          <td width="17" style="background:url(images/left_shadow.png) repeat-y right;width:17px;"><img src="images/blank.png" /></td>
          <td bgcolor="#FFFFFF"><form method="post" action="<?=$_SERVER['PHP_SELF']?>" >
              <div style="width:700px; margin:auto;background:#FFFFFF;">
                <div style="height:10px;"></div>
                <div style="background-color:#ff6e01;"><img src="images/thank_you.gif" alt="thank you for your order" title="Thank you for your order"  /></div>
                <div style="height:10px;"></div>
                <div style="margin-left:20px;margin-right:30px;border:solid 1px #cecece;">
                  <div style="margin-left:20px;margin-top:20px;margin-right:30px;" class="text_blue"><H1 class="text_blue">Please <a style="cursor:pointer;" onclick="window.open('ez_receipt_print.php?cart_id=<?=$cart_id?>','reciept','height=350,width=650')">print</a> this receipt for your records. A copy was also emailed to you.</H1>
                </div>
                  <div style="height:20px;"></div>
                  <div style="margin-top:10px;">
                    <div style="width:120px;text-align:left;margin-top:4px;padding-left:15px" class="orange_txt">Order Details</div>
                  </div>
                  <div style="margin-top:10px;">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Order No.</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=$cartarray_row['ezopro_id'];?>
                    </div>
                  </div>
                  <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Date</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                     <?=date("m-d-y",strtotime($cartarray_row['ezopro_posted']));?>
                    </div>
                  </div>
				  <div style="height:20px;"></div>
				  <div style="margin-top:10px;">
				  <div style="float:left;width:120px; text-align:left; padding-left:15px;"class="orange_txt">Product Name</div>
                  <div style="float:left;padding-left:50px;" class="orange_txt">Quantity</div>
                  <div style="clear:both;">&nbsp;</div>
				  <? foreach ($cart as $key=>$name)
					{
					$total+=$name['totalprice'];
					?>
					<div style="float:left;width:120px;padding-left:15px" class="checkout"><?=$name['ezproduct_name']?></div>
                        <div style="float:left;padding-left:50px;" class="checkout"><?=$name['number']?></div>
                        <div style="clear:both;">&nbsp;</div>
                     	
                     <? 
					 }
					 $discount=$total+$cartarray_row['ship_price']-$cartarray_row['ezopro_totalprice'];
					 ?>
					 </div>
                 <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Product Cost</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                     <?=number_format($total,2);?> U.S
                    </div>
                  </div>
                  <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Shipping price</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                      <?=number_format($cartarray_row['ship_price'],2);?> U.S
                    </div>
                  </div>
                 <div style="padding-top:10px;margin-bottom:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Discounts</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                     <?=number_format($discount,2);?> U.S
                    </div>
                  </div>
                 <div style="padding-top:10px;clear:both">
                    <div style="float:left;width:120px;text-align:left;margin-top:4px;padding-left:15px" class="checkout">Total</div>
                    <div style="float:left;text-align:left;margin-top:4px; margin-left:10px;" class="checkout">:</div>
                    <div style="float:left;margin-left:10px; margin-top:4px;"  class="text_blue">
                     <?=number_format($cartarray_row['ezopro_totalprice'],2);?> U.S
                    </div>
                  </div>
                 <div style="height:25px;">&nbsp;</div>
                </div>
              </div>
              <div class="height20">&nbsp;</div>
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
		
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26958699-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_addTrans',
    '<?=$cartarray_row['ezopro_id']?>',          // order ID - required
    'Caricaturetoons Products Order',  			// affiliation or store name
    '<?=$cartarray_row['ezopro_totalprice']?>',   // total - required
    '',           							// tax
    '',              						// shipping
    '<?=$cartarray_row['ship_city']?>',       				// city
    '<?=$cartarray_row['ship_state']?>',     					// state or province
    '<?=$cartarray_row['ship_country']?>'             		// country
  ]);

   // add item might be called for every item in the shopping cart
   // where your ecommerce engine loops through each item in the cart and
   // prints out _addItem for each
  _gaq.push(['_addItem',
    '<?=$cartarray_row['ezopro_id']?>',   						// order ID - required
    'PROD2011',        						// SKU/code - required
    'ProductOrder',       						// product name
    'Buy Products',   							// category or variation
    '<?=$cartarray_row['ezopro_totalprice']?>',    // unit price - required
    '1'               						// quantity - required
  ]);
  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

        
		<!--content ends-->	
		<!--footer-->
<? include (DIR_INCLUDES.'footer.php') ?>