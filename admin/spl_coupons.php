<?
	include('includes/configuration.php');
	//TO DELETE Special Coupons
	$spc_id =$_REQUEST['spc_id'];
	if($spc_id )
	{
		$del_query="delete from toon_special_coupons where spc_id ='$spc_id'";
		mysql_query($del_query);
    }

	
	$sql_spc="SELECT * FROM  `toon_special_coupons` WHERE `spc_product`='Toon product'";
	$rs_spc=mysql_query($sql_spc);
	
	$sql_ez_spc="SELECT * FROM  `toon_special_coupons` WHERE `spc_product`='ez product'";
	$rs_ez_spc=mysql_query($sql_ez_spc);
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
          <td class="main_heading" height="30" colspan="4">Special Coupons</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><a href="spl_coupons_edit.php"><input type="button" value="Add Special Coupon"></a></td>

        </tr>
        <tr><td></td><td style="padding-left:30px"><b>Toon Products</b></td></tr>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_spc);
		if ($number!=0)
		{
		?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Coupon Code</td>
                <td class="sub_heading" height="30">Product Price</td>
                <td class="sub_heading" height="30">Wholesale Price</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
              <?
	   while($row_spc=mysql_fetch_assoc($rs_spc))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_spc['spc_code']?></td>
                <td align="left" class="table_details"><?echo '$ ';?><?=number_format($row_spc['spc_product_price'],2);?></td>
                <td align="left" class="table_details"><?echo '$ ';?><?=number_format($row_spc['spc_wholesale_price'],2);?></td>
                <td align="left" class="table_details"><a href="spl_coupons_edit.php?spc_id=<?=$row_spc['spc_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this special coupon" alt="Modify this special coupon" /></a> <a onclick="return confirmation()"href="spl_coupons.php?spc_id=<?=$row_spc['spc_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this special coupon" alt="Delete this special coupon"/></a></td>
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
                <td class="no_details_msg">No Special Coupons!</td>
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
						<td align="center" class="table_details">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<table align="center">
					<tr>
						<td align="center" class="table_details">Note:- This section provides the ability to create special pricing for special requests. For example, if a client wants a caricature toon with multiple images, we would discuss with the artist, determine a wholesale price and retail price based on the requirements and the client would enter this coupon code to get the special quoted price. </td>
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
