<?
		include('includes/configuration.php');
 		$cct_id=$_REQUEST['cct_id'];
 		
 		$del=$_REQUEST['del'];
		
		if($cct_id!="")
		{
			$sql_cool_categories="SELECT * FROM `toon_cool_categories` WHERE `cct_id`='$cct_id'";
			$rs_cool_categories = mysql_query($sql_cool_categories);
			$row_cool_categories = mysql_fetch_assoc($rs_cool_categories);
		}
		
		if(isset($_POST['submit']))
		{
			 	
				$ref_category_name=$_POST["ref_category_name"];
				$ref_desc=$_POST["ref_desc"];
				
				if($cct_id)
				{
					$sql_update="UPDATE `toon_cool_categories` SET `cct_category_name`='$ref_category_name',`cct_description`='$ref_desc' WHERE `cct_id`='$cct_id'";	
					$update_promo=mysql_query($sql_update);
					$msg='Updated Successfully!';
				}
				else
				{
					$sql_insert="INSERT INTO `toon_cool_categories`(`cct_category_name` ,`cct_description`)VALUES 
					('$ref_category_name','$ref_desc')";	
					mysql_query($sql_insert);
					$cc_id=mysql_insert_id();
				}
									
				header("Location:manage_cool_categories.php");
			}			

		include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("ref_category_name").value=="")
    	{      
		 		document.getElementById("rname_div").style.display="block";
				valid=false;
     	}
	 	if(document.getElementById("ref_desc").value=="")
   		{
     			document.getElementById("des_div").style.display="block";
	 			valid=false;
    	}
		
		return valid;
}
function clear()
{
		document.getElementById("rname_div").style.display="none";
		document.getElementById("des_div").style.display="none";
			
}
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		return true;
	}
	return false;	
}
</script>

<form action="edit_cool_category.php" method="post" onsubmit="return valid()" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Cool  Link Category</td>
          </tr>
          <tr>
		  <td height="40px;"></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="60%" class="table_border">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td>
					<div id="rname_div" style="display:none" class="no_details_msg">Enter Category Name</div>
					<div id="des_div" style="display:none" class="no_details_msg">Enter Description</div>
				</td>
				</tr>
				<tr>
				  <td width="14%">&nbsp;</td>
				  <td width="33%" align="left" class="table_details">Category Name&nbsp;:*</td>
				  <td width="53%" align="left"><input type="text" name="ref_category_name" id="ref_category_name" value="<?=$row_cool_categories['cct_category_name']?>" /></td>
			    </tr>
                <tr><td>&nbsp;</td>
                  <td align="left" class="table_details" valign="top">Description&nbsp;:*</td>
                  <td align="left"><textarea name="ref_desc" id="ref_desc" rows="5" cols="25"><?=$row_cool_categories['cct_description']?></textarea>
				  </td>
                </tr>
                <tr height="50">
                  <td colspan="2"><input type="hidden" name="cct_id" value="<?=$row_cool_categories['cct_id'];?>" ></td>
                    <td><input type="submit" name="submit" value=<? if($cct_id){?>"Update" <? }else{?>"Submit"<? }?> />
                  </td>
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
</form>

<?	include("includes/footer.php");?>
