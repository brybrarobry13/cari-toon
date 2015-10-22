<?
	include('includes/configuration.php');
	//TO DELETE Special Offers
	$spo_id =$_REQUEST['spo_id'];
	if($spo_id )
	{
		$del_query="delete from toon_special_offers where spo_id ='$spo_id'";
		mysql_query($del_query);
    }

	
	$sql_spo="SELECT *,DATE_FORMAT(`spo_startdate`, '%m-%d-%y') as `spo_startdate`,DATE_FORMAT(`spo_enddate`, '%m-%d-%y') as `spo_enddate` FROM  `toon_special_offers` WHERE `spo_product`='Toon product'";
	$rs_spo=mysql_query($sql_spo);
	
	$sql_ez_spo="SELECT *,DATE_FORMAT(`spo_startdate`, '%m-%d-%y') as `spo_startdate`,DATE_FORMAT(`spo_enddate`, '%m-%d-%y') as `spo_enddate` FROM  `toon_special_offers` WHERE `spo_product`='ez product'";
	$rs_ez_spo=mysql_query($sql_ez_spo);
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
          <td class="main_heading" height="30" colspan="4">Special Offers</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><a href="spl_offers_edit.php"><input type="button" value="Add Special Offer"></a></td>

        </tr>
        <tr><td></td><td style="padding-left:30px"><b>Toon Products</b></td></tr>
        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_spo);
		if ($number!=0)
		{
		?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Title</td>
                <td class="sub_heading" height="30">Description</td>
                <td class="sub_heading" height="30">Discount</td>
                <td class="sub_heading" height="30">Date Range</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
              <?
	   while($row_spo=mysql_fetch_assoc($rs_spo))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_spo['spo_title']?></td>
                <td align="left" class="table_details"><?=$row_spo['spo_description'];?></td>
				<td align="center" class="table_details"><?=$row_spo['spo_discount'].'(%)'?></td>
                <td align="left" class="table_details"><?=$row_spo['spo_startdate']?> - <?=$row_spo['spo_enddate']?></td>
                <td align="left" class="table_details"><a href="spl_offers_edit.php?spo_id=<?=$row_spo['spo_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this special offer" alt="Modify this special offer" /></a> <a onclick="return confirmation()"href="spl_offers.php?spo_id=<?=$row_spo['spo_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this special offer" alt="Delete this special offer"/></a></td>
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
                <td class="no_details_msg">No Special Offers!</td>
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
		
		$number=mysql_num_rows($rs_ez_spo);
		if ($number!=0)
		{
		?>
            <table cellpadding="4" cellspacing="0" width="94%" class="table_border" >
              <tr class="heading_bg">
                <td class="sub_heading" height="30">Title</td>
                <td class="sub_heading" height="30">Description</td>
                <td class="sub_heading" height="30">Discount</td>
                <td class="sub_heading" height="30">Date Range</td>
                <td class="sub_heading" height="30">Actions</td>
              </tr>
              <?
	   while($row_ez_spo=mysql_fetch_assoc($rs_ez_spo))
	   {
	   ?>
              <tr>
                <td align="left" class="table_details"><?=$row_ez_spo['spo_title']?></td>
                <td align="left" class="table_details"><?=$row_ez_spo['spo_description'];?></td>
				<td align="center" class="table_details"><?=$row_ez_spo['spo_discount'].'(%)'?></td>
                <td align="left" class="table_details"><?=$row_ez_spo['spo_startdate']?> - <?=$row_ez_spo['spo_enddate']?></td>
                <td align="left" class="table_details"><a href="spl_offers_edit.php?spo_id=<?=$row_ez_spo['spo_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this special offer" alt="Modify this special offer" /></a> <a onclick="return confirmation()"href="spl_offers.php?spo_id=<?=$row_ez_spo['spo_id'];?>&del"><img border="0" src="images/delete.png" title="Delete this special offer" alt="Delete this special offer"/></a></td>
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
                <td class="no_details_msg">No Special Offers!</td>
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
						<td align="center" class="table_details">Note:- This section provides a site wide discount. Users are not required to enter a coupon code. The site will automatically calculate the discount at check out.</td>
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
