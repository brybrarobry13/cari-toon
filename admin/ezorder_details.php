<?
include('includes/configuration.php');

$ezopro_id=$_REQUEST['ezopro_id'];
if(isset($_POST['paid_x']))
	{
	$payment_no=$_POST['payment_no'];
		$sql_update="UPDATE `toon_ez_order_products` SET `ezopro_ez_paymentstatus`='Paid',`ezopro_ez_paymentnumber`='$payment_no',`ezopro_ez_paymentdate`=NOW() WHERE ezopro_id ='$ezopro_id'";
	$update_promo=mysql_query($sql_update);
	}	
$sql_content="SELECT TC.*,TEOP.*,TSA.*
									FROM `toon_cart`TC,`toon_ez_order_products`TEOP,`toon_shipping_address`TSA
									WHERE TEOP.cart_id=TC.cart_id
									AND TEOP.ezopro_paymentstatus='Paid'
									AND TEOP.ezopro_id='$ezopro_id'
									AND TSA.ezopro_id='$ezopro_id'";
$rs_content = mysql_query($sql_content);
$content=mysql_fetch_assoc($rs_content);
$cart=unserialize(base64_decode($content['cart_array']));
$customer=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name FROM `toon_users` WHERE `user_id`='$content[user_id]'"));
include ('includes/header.php');
?>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">EZ Prints Order Details</td>
          </tr>
          <tr>
            <td>&nbsp;
            </td>
         </tr>
          <tr>
		  <td height="40px;"></td>
          <td height="40px;" align="center">
              <table cellspacing="0" class="table_border" cellpadding="0" width="90%">
              <tr class="heading_bg">
                    <td class="sub_heading">Product Image</td>
                    <td class="sub_heading">Product Name</td>
                    <td class="sub_heading">Quantity</td>
                    <td class="sub_heading">Total Price</td>
                </tr>
                <tr><td>&nbsp;</td>
                </tr>
              <? foreach ($cart as $key=>$name)
					{
					 ?>
                <tr>
                    <td align="left" class="table_details"><img width="100" src="<?=$name['thumbUrl']?>" border="0" /></td>
                    <td align="left" class="table_details"><?=$name['ezproduct_name'];?></td>
                    <td align="left" class="table_details"><?=$name['number'];?></td>
                    <td align="left" class="table_details"><?=number_format($name['totalprice'],2);?></td>
                </tr>
                <tr><td>&nbsp;</td>
                </tr>
                <?
                }
				?>
              </table>
          </td>
		 </tr>
         <tr>
            <td>&nbsp;
            </td>
         </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="90%" class="table_border">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td width="14%">&nbsp;</td>
                  <td width="33%" align="left" class="table_details">Customer&nbsp;:</td>
                  <td width="53%" align="left"><?=$customer['name']?></td>
                </tr>
                
               
                <!--<tr><td>&nbsp;</td>
                  <td align="left" class="table_details">EZ Prints Order format&nbsp;:</td>
                  <td align="left" ><?//$content['ezopro_orderxml']?>
				  </td>
                </tr>-->
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Shipping price&nbsp;:</td>
                  <td align="left" ><?=number_format($content['ship_price'],2)?>
				  </td>
                </tr>
				<tr><td>&nbsp;</td>
                  <td align="left" class="table_details">Total price&nbsp;:</td>
                  <td align="left" ><?=number_format($content['ezopro_totalprice'],2)?>
				  </td>
                </tr>
				<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Order Reference Number &nbsp;:</td>
                  <td align="left"><?=$content['ezopro_orderreference']?></td>
                </tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Order Date&nbsp;:</td>
                  <td align="left"><?=date('m-d-Y',strtotime($content['ezopro_posted']))?>
				 </td>
                </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Order Status&nbsp;:</td>
                  <td align="left"><? if($content['ezopro_orderstatus']==''){echo 'waiting for aproval';}else{echo $content['ezopro_orderstatus'];}?>
						</td>
					</tr>
          <tr>
                  <td>&nbsp;</td>
                  <td align="left" class="table_details" style="font-size:18px" colspan="2">Shipping Details</td>
                </tr>
		<tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">First name&nbsp;:</td>
                  <td align="left"><?=$content['ship_fname']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">last Name&nbsp;:</td>
                  <td align="left"><?=$content['ship_lname']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Address 1&nbsp;:</td>
                  <td align="left"><?=$content['ship_address1']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Address 2&nbsp;:</td>
                  <td align="left"><?=$content['ship_address2']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">City&nbsp;:</td>
                  <td align="left"><?=$content['ship_city']?>
				  </td>
          </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details">State/Province&nbsp;:</td>
                  <td align="left"><?=$content['ship_state']?></td>
                </tr>
				  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Zip/Postal Code&nbsp;:</td>
                  <td align="left"><?=$content['ship_zipcode']?></td>
                </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Country&nbsp;:</td>
                  <td align="left"><?=$content['ship_country']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Phone&nbsp;:</td>
                  <td align="left"><?=$content['ship_phone']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Email&nbsp;:</td>
                  <td align="left"><?=$content['ship_email']?>
				  </td>
          </tr>
		  <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">Shippping Method&nbsp;:</td>
                  <td align="left"><?=$content['ship_method']?>
				  </td>
          </tr>
            <?
		    if($content['ezopro_ez_paymentstatus']=='Not Paid')
		    {
            ?>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2"><form action="ezorder_details.php?ezopro_id=<?=$ezopro_id?>" method="post">
                         <table  width="80%">
                                <tr>
                                <td align="left" style="padding-left:7px">Payment Number :</td>
                                <td style="padding-left:55px">
                                <input type="text" name="payment_no" id="payment_no" />
                                </td>
                           </tr>
                                <tr>
                                <td>&nbsp;</td>
                                <td style="padding-left:55px">
                                <input align="left" onclick="return enter_paid_date()" type="image" name="paid" src="images/ezprint.jpg">
                                </td>
                                </tr>
                         </table>
                    </form>
            </td>
        </tr>
			<?
            }
            else
            {
            ?>
         <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">EZ Payment Number&nbsp;:</td>
                  <td align="left"><?=$content['ezopro_ez_paymentnumber']?>
				  </td>
          </tr>
           <tr>
				<td>&nbsp;</td>
                  <td align="left" class="table_details">EZ Payment Date&nbsp;:</td>
                  <td align="left"><?=$content['ezopro_ez_paymentdate']?>
				  </td>
          </tr>
			<?
            }
            ?>
        <tr height="50">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
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