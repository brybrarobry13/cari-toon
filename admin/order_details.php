<? include("includes/configuration.php");
$order_id=$_REQUEST['order_id'];
if(isset($_REQUEST['restore_order']))
{
	mysql_query("UPDATE `toon_orders` SET `order_status`='Work In Progress' WHERE `order_id`='$order_id'");
}
if(isset($_POST['refunded_x']))
{
	$order_id=$_POST['order_id'];
	$refund_no=$_POST['refund_no'];
	$reason_refund=$_POST['reason_refund'];
	$sql_update="UPDATE `toon_orders` SET `order_status`='Refunded',`order_refunded_number`='$refund_no',`order_refunded_date`=NOW(),`order_refund_reason`='$reason_refund' WHERE order_id ='$order_id'";
	$update_promo=mysql_query($sql_update);
}
if(isset($_POST['change_wholesale_price_x']))
{
	$order_id=$_POST['order_id'];
	$wholesale_price=$_POST['txt_wholesaleprice'];
	mysql_query("UPDATE `toon_orders` SET `order_wholesale_price`='$wholesale_price' WHERE `order_id`='$order_id'");
}
if(isset($_POST['change_price_x']))
{
	$order_id=$_POST['order_id'];
	$price=$_POST['txt_price'];
	mysql_query("UPDATE `toon_orders` SET `order_price`='$price' WHERE `order_id`='$order_id'");
}	
if(isset($_POST['paid_x']))
{
	$order_id=$_POST['order_id'];
	$payment_no=$_POST['payment_no'];
	$sql_update="UPDATE `toon_orders` SET `order_status`='artist paid', `order_artistpayment_status` = 'Paid',`order_artist_payment_no`='$payment_no',`order_artistpayment_date`=NOW() WHERE order_id ='$order_id'";
	$update_promo=mysql_query($sql_update);
}
$sql_content="SELECT T.*,TP.`product_title`,TP.`product_turnaroundtime`,TA.`user_fname`,TA.`user_lname` FROM `toon_orders` T,`toon_products` TP,`toon_users` TA WHERE T.`product_id`=TP.`product_id` AND T.user_id=TA.user_id AND T.order_id=$order_id";
$rs_content = mysql_query($sql_content);
$content=mysql_fetch_assoc($rs_content);

$customer=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name, `user_paypal_acc` FROM `toon_users` WHERE `user_id`='$content[artist_id]'"));
$image_caricature_query = mysql_query("SELECT * FROM `toon_order_products` WHERE `order_id`='$order_id'");
$image_caricature_row=mysql_fetch_array($image_caricature_query);
$image_query = mysql_query("SELECT * FROM `toon_order_images` WHERE `order_id`='$order_id'");
include ('includes/header.php');
?>
<link rel="stylesheet" type="text/css" href="../styles/highslide.css" />
<script type="text/javascript" src="../javascripts/highslide-with-html.js"></script>
<script type="text/javascript">
	hs.graphicsDir = '../images/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<script type="text/javascript">
function enter_paid_date()
{
	if(document.getElementById('payment_no').value=='')
		{
			document.getElementById('refund_no_error').style.display='block';
			return false;
		}
	else
		{
			document.getElementById('refund_no_error').style.display='none';
		}
}
function enter_refund_date()
{
	if(document.getElementById('refund_no').value=='')
		{
			document.getElementById('refund_no_error').style.display='block';
			return false;
		}
	else
		{
			document.getElementById('refund_no_error').style.display='none';
		}
}


</script>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Order Details</td>
          </tr>
          <tr>
		  <td height="40px;"></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="60%" class="table_border" border="0">
            	<tr>
				<td width="7%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details" colspan="3"><div style="color:#FF0000;font-family:Arial, Helvetica, sans-serif;display:none" id="refund_no_error">*Please enter Payment Number </div></td> 
                </tr>
                <tr>
				<td width="7%">&nbsp;</td>
                  <td width="40%" align="left" class="table_details">Order Number</td><td>:</td>
                  <td width="53%" align="left"><?=$content['order_id']?></td>
                </tr>
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Number of People</td><td>:</td>
                  <td align="left"><?=$content['order_people_count']?></td>
                </tr>
              <!--  <tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">Props</td><td>:</td>
                  <td width="53%" align="left"><?=$content['order_props']?></td>
                </tr>-->
                <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Product</td><td>:</td>
                  <td align="left"><?=$content['product_title']?>
				  
				  </td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Artist</td><td>:</td>
                  <td align="left" ><?=$customer['name']?>
				  </td>
                </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Artist Paypal Account</td><td>:</td>
                  <td align="left"><? if($customer['user_paypal_acc']!="") { echo $customer['user_paypal_acc']; } else { echo "NILL"; } ?></td>
                </tr>
				<tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Customer</td><td>:</td>
                  <td align="left" ><?=ucfirst($content['user_fname']).' '.ucfirst($content['user_lname'])?>
				  </td>
                </tr>
                <tr>
                <td>&nbsp;</td>                   
                     <form action="order_details.php?order_id=<?=$order_id?>" method="post">
                     <td align="left" class="table_details">Wholesale Price</td><td>:</td>
                     <td align="left"><input style="width:75px" type="text" name="txt_wholesaleprice" id="txt_wholesaleprice" value="<?=number_format($content['order_wholesale_price'],2);?>"/>
                     <input type="image" name="change_wholesale_price" src="images/save.png">
                     <input type="hidden" name="order_id" value="<?=$order_id?>">
                     </td>
                    </form>
                </tr>
                <tr>
                <td>&nbsp;</td>                   
                     <form action="order_details.php?order_id=<?=$order_id?>" method="post">
                      <td align="left" class="table_details">Price</td><td>:</td>
                      <td align="left"><input style="width:75px" type="text" name="txt_price" id="txt_price" value="<?=number_format($content['order_price'],2);?>"/>
                      <input type="image" name="change_price" src="images/save.png">
                      <input type="hidden" name="order_id" value="<?=$order_id?>">
                      </td>
                    </form>
                </tr>

				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Order Status</td><td valign="top">:</td>
                  <td align="left"><?=$content['order_status']?>
				  <?
				  	if(($content['order_status'] =='Completed')||($content['order_status'] =='artist paid'))
					{?>
						<form name="form_restore" method="post" action="<?=$_SERVER['PHP_SELF']?>?<?=$_SERVER['QUERY_STRING']?>" style="margin:0px;">
							<input type="submit" name="restore_order" value="Re-open this order" />
						</form>
					<? }?>
				 </td>
                </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Ordered Date</td><td>:</td>
                  <td align="left"> <? echo date('m-d-Y',strtotime($content['order_date']))?>
				  </td>
		  </tr>
          <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Turnaround Days</td><td>:</td>
                  <td align="left"><?=$content['product_turnaroundtime']?>
				  </td>
		  </tr>
			<?
          
            $deadline =mysql_fetch_array(mysql_query("SELECT DATE_ADD('$content[order_date]', INTERVAL '$content[product_turnaroundtime]' DAY),NOW() AS `today`"));
            ?>
          <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Dead Line</td><td>:</td>
                  <td align="left"><span <? if($deadline[0]<$deadline['today']) {?>style="color:#FF0000"<? }?>><? echo date("m-d-y",strtotime($deadline[0]));?></span>
				  </td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="left" class="table_details" valign="top">Order Images</td><td valign="top">:</td>
			<td align="left">
				<table>
			<? 	while($image_row=mysql_fetch_array($image_query)){ 
			?>
						<tr>
							<td align="left" class="shift_right"><a href="../z_uploads/cart_images/<?=$image_row['order_image_name']?>" onclick="return hs.expand(this)"><img src="<?='../includes/imageProcess.php?image='.$image_row['order_image_name'].'&type=cart&size=150';?>"  border="0" /></a>
							</td>
						</tr>
						<tr>
							<td align="left" class="shift_right"><a href="../save_image.php?f_name=<?=$image_row['order_image_name']?>">Download image</a>
							</td>
						</tr>
					<? }?>
				</table>
			  </td>
		   </tr>
                    <? if($content['order_status']=='Completed'){?>
        		 <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details">Completed Date</td><td>:</td>
                  <td align="left"><? echo date('m-d-Y',strtotime($content['order_completed_date']));?>
				  </td>
                </tr>
                <? }?>
		  <? if($content['order_status']=='Completed'||$content['order_status']=='artist paid'){?>
		  		<tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Caricature</td><td valign="top">:</td>
                  <td align="left">
                  	<table width="100%">
                    	<tr><td><a href="../z_uploads/caricature_images/<?=$image_caricature_row['opro_caricature']?>" onclick="return hs.expand(this)"><img src="<?='../includes/imageProcess.php?image='.$image_caricature_row['opro_caricature'].'&type=caricature&size=150';?>"  border="0" /></a></td></tr>
                    	<tr>
							<td align="left" class="shift_right"><a href="download_toon.php?img=<?=$image_caricature_row['opro_caricature']?>">Download image</a>
							</td>
						</tr>
                  	</table>
				  </td>
                </tr>
				<!--<tr>
				<td colspan="3">&nbsp;</td><td>Download</td>
				</tr>-->
		  
		  <? }?>
                <? if($content['order_status']=='artist paid') {?>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">payment Date</td><td>:</td>
                  <td align="left"><? echo date('m-d-Y',strtotime($content['order_artistpayment_date']));?></td>
                </tr>
                <tr>
                    <td>&nbsp;
                    </td>
                    <td align="left" class="table_details">Payment Number</td><td>:</td>
                	<td align="left"><?=$content['order_artist_payment_no']?></td>
                </tr>
                <? }?>
                 <? if($content['order_status']=='Refunded') {?>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Refunded Date</td><td>:</td>
                  <td align="left"><? echo date('m-d-Y',strtotime($content['order_refunded_date']));?></td>
                </tr>
                <tr>
                    <td>&nbsp;
                    </td>
                    <td align="left" class="table_details">Payment Number</td><td>:</td>
                	<td align="left"><?=$content['order_refunded_number']?></td>
                </tr>
                <tr>
                    <td>&nbsp;
                    </td>
                    <td align="left" class="table_details">Comments</td><td>:</td>
                	<td align="left"><?=$content['order_refund_reason']?></td>
                </tr>
                <? }?>
                
                    <? if($content['order_status']!='artist paid' && $content['order_status']!='Pending' && $content['order_status']!='Refunded') {?>
                    <tr>
                    <td>&nbsp;</td>
                   
                    <td align="left" colspan="3">
                     <form action="order_details.php?order_id=<?=$order_id?>" method="post">
                         <table  width="100%">
                                <tr>
                                <td width="41%" align="left" class="table_details">Payment Number :</td>
                                <td width="59%">
                                <input type="text" name="payment_no" id="payment_no" />
                                </td>
                           </tr>
                                <tr>
                                <td>&nbsp;</td>
                                <td><input type="hidden" name="order_id" value="<?=$order_id?>">
                                <input align="left" onclick="return enter_paid_date()" type="image" name="paid" src="images/artistpaid.gif">
                                </td>
                                </tr>
                         </table>
                    </form>
                    </td>
                </tr>
                    <? }?>
                    <? if($content['order_status']!='Refunded'&&$content['order_status']!='Pending'&&$content['order_status']!='artist paid') {?>
                <tr>
                    <td>&nbsp;</td>

                    <td align="left" colspan="4">
                    <form action="order_details.php?order_id=<?=$order_id?>" method="post">
                        <table width="100%">
                        	<tr>
                             <td width="41%" align="left" valign="top" class="table_details">Comments :</td>
                            <td width="59%"><textarea name="reason_refund"></textarea></td>
                            </tr>
                            <tr>
                            <td align="left" class="table_details">Payment Number :</td>
                            <td><input type="text" name="refund_no" id="refund_no" /></td>
                            </tr>
                            <tr>
                            <td>&nbsp;</td>
                          <td><input type="hidden" name="order_id" value="<?=$order_id?>"><input align="left" onclick="return enter_refund_date()" type="image" name="refunded" src="images/refunded.gif"></td>
                            </tr>
                         </table>
                    </form>
               		</td>
               </tr>
				<? }?>
                <tr>
				<td width="7%">&nbsp;</td>
                  <td width="40%" align="left" class="table_details"></td><td></td>
                  <td width="53%" align="left"></td>
                </tr>
            </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?	include("includes/footer.php");?>