<?
	include('includes/configuration.php');
	//TO DELETE PROMOTIONAL CODES
	$promo_id =$_REQUEST['promo_id'];
	if($promo_id )
	{
		$del_query="delete from toon_promo where promo_id ='$promo_id'";
		mysql_query($del_query);
    }

	
	$sql_promo="SELECT *,DATE_FORMAT(`promo_expiry`, '%m-%d-%y') as `promo_expiry` FROM  `toon_promo` WHERE `promo_product_type`='Toon product' and `bulk_id` = '0'";
	$rs_promo=mysql_query($sql_promo);
	
	$sql_ez_promo="SELECT *,DATE_FORMAT(`promo_expiry`, '%m-%d-%y') as `promo_expiry` FROM  `toon_promo` WHERE `promo_product_type`='ez product' and `bulk_id` = '0'";
	$rs_ez_promo=mysql_query($sql_ez_promo);
	include ('includes/header.php');
 ?>
<script>
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Coupon Codes</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Add Coupon Code"onclick="window.location='promotional_edit.php'" /></td>

        </tr>
        <tr><td></td><td style="padding-left:30px"><b>Toon Products</b></td></tr>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_promo);
		if ($number!=0)
		{
		?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Coupon Code</td>
                <td class="sub_heading" height="30">Discount</td>
				<td class="sub_heading" height="30"> Minimum Amount of Purchase($)</td>
                <td class="sub_heading" height="30">Expiry Date</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
              <?
	   while($row_promo=mysql_fetch_assoc($rs_promo))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_promo['promo_code']?></td>
                <td align="left" class="table_details"><?=$row_promo['promo_discount']; if($row_promo['promo_type']==0) { echo '(%)';}?></td>
				<td align="center" class="table_details"><?=$row_promo['promo_amount']?></td>
                <td align="left" class="table_details"><?=$row_promo['promo_expiry']?></td>
                <td align="left" class="table_details"><a href="promotional_edit.php?promo_id=<?=$row_promo['promo_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this coupon code" alt="Modify this coupon code" /></a> <a onclick="return confirmation()"href="promotional_codes.php?promo_id=<?=$row_promo['promo_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this coupon code" alt="Delete this coupon code"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
            </table>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Coupon Codes!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr height="30"><td></td><td valign="bottom" style="padding-left:30px"><b>EZ Products</b></td></tr>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_ez_promo);
		if ($number!=0)
		{
		?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Coupon Code</td>
                <td class="sub_heading" height="30">Discount</td>
				<td class="sub_heading" height="30"> Minimum Amount of Purchase($)</td>
                <td class="sub_heading" height="30">Expiry Date</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
              <?
	   while($row_ez_promo=mysql_fetch_assoc($rs_ez_promo))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_ez_promo['promo_code']?></td>
                <td align="left" class="table_details"><?=$row_ez_promo['promo_discount']; if($row_ez_promo['promo_type']==0) { echo '(%)';}?></td>
				<td align="center" class="table_details"><?=$row_ez_promo['promo_amount']?></td>
                <td align="left" class="table_details"><?=$row_ez_promo['promo_expiry']?></td>
                <td align="left" class="table_details"><a href="promotional_edit.php?promo_id=<?=$row_ez_promo['promo_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this coupon code" alt="Modify this coupon code" /></a> <a onclick="return confirmation()"href="promotional_codes.php?promo_id=<?=$row_ez_promo['promo_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this coupon code" alt="Delete this coupon code"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
            </table>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Coupon Codes!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="5%">&nbsp;</td>
        </tr>
		<tr>
          <td height="20" colspan="4"></td>
        </tr>
		<tr>
			<td colspan="4">
				<table align="center">
					<tr>
						<td align="center" class="table_details">Note:- This section is a global coupon that when entered will apply a discount whenever used. It can be used multiple times.</td>
					</tr>
				</table>
			</td>
		</tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
