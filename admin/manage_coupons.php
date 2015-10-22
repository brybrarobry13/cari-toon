<?
	include('includes/configuration.php');
	//TO DELETE COUPON
	$cc_id =$_REQUEST['cc_id'];
	$del=$_REQUEST['del'];
	if($cc_id && $del)
	{
		$del_coupon = mysql_query("delete from toon_cool_coupon where `cc_id`='$cc_id'");
    }
	$change_proid = $_POST['change_proid'];
	if($change_proid)
	{
		$pro_priority=$_POST['collink_'.$change_proid];
		$query= "UPDATE `toon_cool_coupon` SET `ref_priority`='$pro_priority' WHERE `cc_id`='$change_proid'";
		$result = mysql_query($query);
	}
	$sql_coupon="SELECT * FROM `toon_cool_coupon` WHERE `cc_flag`='1' GROUP BY `cc_id` ORDER BY `ref_priority` ASC";
	$rs_coupon=mysql_query($sql_coupon);
	$count=mysql_num_rows($rs_coupon);
//echo $count;
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

function changepriority(proid)
{
	document.getElementById("change_proid").value=proid;
	document.coolcoupouns.submit();
}
</script>

<table cellpadding="0" cellspacing="10" border="0" width="97%">
  <tr>
    <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
    <td align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
        <tr class="table_titlebar">
          <td class="main_heading" height="30" colspan="4">Coupons</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="right" style="padding-right:18px;"><input type="submit" name="submit" value="Add Coupon"onclick="window.location='edit_coupons.php'" /></td>

        </tr>

        <tr>
          <td width="1%">&nbsp;</td>
          <td width="94%" align="center"><?
		
		$number=mysql_num_rows($rs_coupon);
		if ($number!=0)
		{
		?>
		  <form action="" method="post" name="coolcoupouns">
            <table cellpadding="4" cellspacing="0" width="100%" class="table_border" border="0" >
              <tr class="heading_bg">
			   <td class="sub_heading" height="30" width="17%">Category Name</td>
                <td class="sub_heading" height="30" width="15%">Reference Name</td>
                <td class="sub_heading" height="30" width="15%">Reference Link</td>
                <td class="sub_heading" height="30" width="15%">Description</td>
				<td class="sub_heading" height="30" width="3%">Reference Priority</td>
                <td class="sub_heading" height="30" width="5%">Actions</td>
              </tr>
			  
			  <input type="hidden" id="change_proid" name="change_proid" />
              <?
	   while($row_coupon=mysql_fetch_assoc($rs_coupon))
	   {
	   		$ref_link = $row_coupon['cc_link'];
	   		$description = $row_coupon['cc_desc'];
			
			$sql_cat=mysql_query("SELECT * FROM `toon_coupon_category` WHERE `cu_id`=".$row_coupon['cc_category']);
			$rs_cat=mysql_fetch_assoc($sql_cat);
	   		
	   ?>
              <tr>
              	<td align="left" class="table_details"><?=$rs_cat['cu_category_name']?></td>
			    <td align="left" class="table_details"><?=stripslashes($row_coupon['cc_link_name']);?></td>
                <td align="left" class="table_details"><? if (strlen($ref_link)>30){ echo substr($ref_link,0,30)." ...";} else { echo $ref_link; }?></td>
                <td align="left" class="table_details"><? if (strlen($description)>30){ echo substr($description,0,30)." ...";} else { echo $description; }?></td>
				<td align="left" class="table_details" ><select name="collink_<?=$row_coupon['cc_id']?>" onchange="return changepriority(<?=$row_coupon['cc_id']?>)">
				 <? for($i=1;$i<=$count;$i++)
					{
				  ?>
				  <option value="<?=$i?>" <? if($row_coupon['ref_priority']==$i) {?> selected="selected"<? } ?>><?=$i?></option>
                  <? 
				    }
				  ?>
				</select></td>
				
				
                <td align="left" class="table_details"><a href="edit_coupons.php?cc_id=<?=$row_coupon['cc_id'];?>" class="anger_tags"><img border="0" src="images/edit.png" title="Modify this Coupon" alt="Modify this Coupon" /></a> <a onclick="return confirmation()"href="manage_coupons.php?cc_id=<?=$row_coupon['cc_id'];?>&del=1"><img border="0" src="images/delete.png" title="Delete this Coupon" alt="Delete this Coupon"/></a></td>
              </tr>
              <?
	   }
       ?>
              <tr>
                <td height="40" colspan="4"></td>
              </tr>
            </table>
			</form>
            <?
		}
		else
		{
		?>
            <table align="center">
              <tr>
                <td class="no_details_msg">No Coupons!</td>
              </tr>
            </table>
            <? } ?>
          </td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td height="40" colspan="4"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?	include("includes/footer.php");?>
