<?
include('includes/configuration.php');

	$user_id=$_REQUEST['user_id'];
	$customer=mysql_fetch_assoc(mysql_query("SELECT `user_fname`,`user_lname` FROM `toon_users` WHERE `user_id`='$user_id'"));
$sql_content="SELECT T.*,TP.`product_title` FROM `toon_orders` T,`toon_products` TP WHERE T.`product_id`=TP.`product_id` AND T.user_id=$user_id AND T.order_status!='Pending'";
$rs_content = mysql_query($sql_content);
$sqlez_content="SELECT TEP.ezproduct_name,TEOP.*
									FROM `toon_ez_products`TEP,`toon_ez_order_products`TEOP
									WHERE TEOP.ezproduct_id=TEP.ezproduct_id
									AND TEOP.ezopro_paymentstatus='Paid'
									AND TEOP.user_id =$user_id";
	$rsez_content = mysql_query($sqlez_content);
	include ('includes/header.php');
?>
<table cellpadding="0" cellspacing="10" border="0" width="97%">
 <tr>
 <td>&nbsp;</td>
 <td style="padding-left:10px;font-family:Arial, Helvetica, sans-serif;font-size:18px">Customer&nbsp;:&nbsp;<?=ucfirst($customer['user_fname']).' '.ucfirst($customer['user_lname'])?></td>
 
 </tr>
 <tr>
  <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
  <td>
	<table cellpadding="0" cellspacing="10" border="0" width="100%">
		<tr>
			<td align="center" valign="top">
			<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
			 <tr class="table_titlebar">
			   <td class="main_heading" height="30" width="100%" colspan="4">Toon Orders</td>
			 </tr>
			  <tr><td height="40px;"></td></tr>
			  <tr>
				<td width="2%">&nbsp;</td>
				<td align="center">
				<?
					$count=mysql_num_rows($rs_content);
					if ($count)
					{?>
						<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
			  <tr class="heading_bg">
				  <td class="sub_heading">Product</td>
				  <td class="sub_heading">Artist</td>
				  <td class="sub_heading">Price($)</td>
				  <td class="sub_heading">Status</td>
				  <td class="sub_heading">Ordered Date</td>
			  </tr>
			   <?
			   while($content=mysql_fetch_assoc($rs_content))
			   {
					$artist=mysql_fetch_assoc(mysql_query("SELECT concat(`user_fname`,' ',`user_lname`)as name FROM `toon_users` WHERE `user_id`='$content[artist_id]'"));							
			
			   ?>
				<tr>
				  <td align="left" class="table_details" ><?=$content['product_title']?></td>
				  <td align="left" class="table_details" ><?=$artist['name']?></td>
				  <td align="left" class="table_details" ><?=number_format($content['order_price'], 2);?></td>
				  <td align="left" class="table_details" ><?=$content['order_status']?></td>
				  <td align="left" class="table_details" ><? echo date('m-d-Y',strtotime($content['order_date']))?></td>
				</tr>
			   <? }?>
				
				<tr>
				  <td height="40" colspan="4"></td>
				</tr>
			  </table>
				<? }else
					{?>
						<table align="center">
					<tr>
						<td class="no_details_msg">No orders Made</td>
					</tr>
				</table>
					<? } ?>
			   </td>
			  <td width="2%">&nbsp;</td>
			</tr>
			  <tr><td height="40" colspan="4"></td></tr>
			</table>
			</td>
		</tr>
		<tr>
			<td align="center" valign="top">
			<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
			 <tr class="table_titlebar"><td class="main_heading" height="30" width="100%" colspan="4">EZ Prints Orders</td></tr>
			  <tr><td height="40px;"></td></tr>
			  <tr>
				<td width="2%">&nbsp;</td>
				<td align="center">
				<?
					$countez=mysql_num_rows($rsez_content);
					if ($countez)
					{?>
						<table cellpadding="0" cellspacing="0" width="100%" class="table_border">
			  <tr class="heading_bg">
				  <td class="sub_heading">EZ Product</td>
				  <td class="sub_heading">Total Cost</td>
				  <td class="sub_heading">Status</td>
				  <td class="sub_heading">Ordered Date</td>
			  </tr>
			   <?
			   while($contentez=mysql_fetch_assoc($rsez_content))
			   {
			   ?>
				<tr>
				  <td align="left" class="table_details" ><?=$contentez['ezproduct_name']?></td>
				  <td align="left" class="table_details" ><?=number_format($contentez['ezopro_totalprice'],2)?></td>
				  <td align="left" class="table_details" ><?=$contentez['ezopro_orderstatus'];?></td>
				  <td align="left" class="table_details" ><? echo date('m-d-Y',strtotime($contentez['ezopro_posted']))?></td>
				</tr>
			   <? }?>
				
				<tr>
				  <td height="40" colspan="5"></td>
				</tr>
			  </table>
				<? }else
					{?>
						<table align="center">
					<tr>
						<td class="no_details_msg">No orders submitted</td>
					</tr>
				</table>
					<? } ?>
			   </td>
			  <td width="2%">&nbsp;</td>
			</tr>
			  <tr><td height="40" colspan="4"></td></tr>
		   </table>
		  </td>
		</tr>
	</table>
  </td>
 </tr>
</table>
<?	include("includes/footer.php");?>