<?	include('includes/configuration.php');
	$ti_id=$_REQUEST['ti_id'];
	$del=$_REQUEST['del'];
	
	if($ti_id!="")
	{
		$sql_ideas="SELECT * FROM `toons_ideas` WHERE `ti_id`='$ti_id'";
		$rs_ideas = mysql_query($sql_ideas);
		$row_ideas=mysql_fetch_assoc($rs_ideas);
	}
	if(isset($_POST['submit']))
	{
		$toons_link=addslashes($_POST["ti_ref_link"]);
		$toons_link_name=addslashes($_POST["ti_ref_name"]);
		$toons_link_top_text=addslashes($_POST["ti_top_text"]);
		$toons_link_bottom_text=addslashes($_POST["ti_bottom_text"]);
		$toons_link_pg_keyword=addslashes($_POST["ti_pg_keyword"]);
		$toons_link_pg_title=addslashes($_POST["ti_pg_title"]);
		$toons_link_pg_des=addslashes($_POST["ti_pg_des"]);
		if($ti_id)
		{
			$sql_update="UPDATE `toons_ideas` SET `ti_ref_link`='$toons_link',`ti_ref_name`='$toons_link_name', ti_top_text='$toons_link_top_text', ti_bottom_text='$toons_link_bottom_text', ti_pg_keyword='$toons_link_pg_keyword', ti_pg_title='$toons_link_pg_title', ti_pg_des='$toons_link_pg_des' WHERE `ti_id`='$ti_id'";	
			$update_promo=mysql_query($sql_update);
			$msg='Updated Successfully!';
		}
		else
		{
			 $sql_insert="INSERT INTO `toons_ideas`(`ti_ref_link`,`ti_ref_name`,`ti_top_text`,`ti_bottom_text`,`ti_pg_keyword`,`ti_pg_title`,`ti_pg_des`)VALUES ('$toons_link', '$toons_link_name', '$toons_link_top_text', '$toons_link_bottom_text', '$toons_link_pg_keyword', '$toons_link_pg_title', '$toons_link_pg_des')";	
			mysql_query($sql_insert);
			$ti_id=mysql_insert_id();
		}
			?>
		<script type="text/javascript">
		window.opener.location='edit_toonsideas.php?ti_id='+<?=$ti_id?>;
		window.close();
		//alert('sdf3');
		</script>
<?php			
	}			
	include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
	var link_value=document.getElementById("ti_ref_link").value;
	var sub_char=false;
	var special_char = new Array("`","~","!","@","#","$","%","^","&","*","(",")","=","+","[","]","{","}",":",";","<",">",",","?","|","/","'"," ","\"","\\");
	
		for(var sp_ct=0;sp_ct < special_char.length;sp_ct++)
		{
			for(var ch=0;ch < link_value.length;ch++)
			{
				if(link_value.substr(ch,1) == special_char[sp_ct])
				{
					sub_char=true;
				}
			}
		}
	
		if(document.getElementById("ti_ref_name").value=="")
    	{      
			document.getElementById("rname_div").style.display="block";
			valid=false;
     	}
		else if(link_value=="" || sub_char==true)
    	{      
			document.getElementById("rlink_div").style.display="block";
			valid=false;
     	}
		else if(document.getElementById("ti_top_text").value=="")
    	{      
			document.getElementById("rtop_div").style.display="block";
			valid=false;
     	}
		return valid;
}
function clear()
{
	document.getElementById("rname_div").style.display="none";
	document.getElementById("rlink_div").style.display="none";
	document.getElementById("rtop_div").style.display="none";
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
<form action="edit_idea_details.php" method="post" onsubmit="return valid()" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
	<td style="width:40px;"></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Toons Ideas</td>
          </tr>
		  <tr>
            <td class="header_sub_text" style="padding-left:50px; padding-top:30px;" height="30" colspan="4">Page Details</td>
          </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top"><table cellpadding="5" cellspacing="0" width="100%" class="">
                <tr>
				<td colspan="2">&nbsp;</td>
				<td></td>
				<td>
			<div id="rname_div" style="display:none" class="no_details_msg">Enter Page Name</div>
			<div id="rlink_div" style="display:none" class="no_details_msg">Enter the Url Name (Only '-' & '_' are allowed other than alphabets/numericals).</div>
			<div id="rtop_div" style="display:none" class="no_details_msg">Enter Top Text</div>
			
				</td>
				</tr>
				<tr>
					<td width="14%">&nbsp;</td>
                 	<td width="33%" align="left" class="table_details">Page Name&nbsp;<span style="color:#F00;">*</span></td><td>:</td>
                  	<td width="53%" align="left"><input type="text" name="ti_ref_name" id="ti_ref_name" value="<?=$row_ideas['ti_ref_name']?>" /></td>
                </tr>
                <tr>
					<td>&nbsp;</td>
                  	<td align="left" class="table_details" >Page Link&nbsp;<span style="color:#F00;">*</span></td><td>:</td>
                  	<td align="left"><input type="text" name="ti_ref_link" id="ti_ref_link" value="<?=$row_ideas['ti_ref_link']?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
                  	<td align="left" class="table_details" valign="middle">Top Text&nbsp;<span style="color:#F00;">*</span></td><td>:</td>
                 	 <td align="left"><textarea name="ti_top_text" id="ti_top_text" rows="5" cols="25"><?=$row_ideas['ti_top_text']?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
                  	<td align="left" class="table_details" valign="middle" >Bottom Text&nbsp;</td><td>:</td>
                  	<td align="left"><textarea name="ti_bottom_text" id="ti_bottom_text" rows="5" cols="25"><?=$row_ideas['ti_bottom_text']?></textarea></td>
				</tr>
                <tr>
					<td>&nbsp;</td>
                  	<td align="left" class="table_details" >Meta Keyword&nbsp;</td><td>:</td>
                  	<td align="left"><input type="text" name="ti_pg_keyword" id="ti_pg_keyword" value="<?=$row_ideas['ti_pg_keyword']?>" /></td>
				</tr>
                <tr>
					<td>&nbsp;</td>
                  	<td align="left" class="table_details" >Meta Title&nbsp;</td><td>:</td>
                  	<td align="left"><input type="text" name="ti_pg_title" id="ti_pg_title" value="<?=$row_ideas['ti_pg_title']?>" /></td>
				</tr>
                <tr>
					<td>&nbsp;</td>
                  	<td align="left" class="table_details" valign="middle" >Meta Description&nbsp;</td><td>:</td>
                  	<td align="left"><textarea name="ti_pg_des" id="ti_pg_des" rows="5" cols="25"><?=$row_ideas['ti_pg_des']?></textarea></td>
				</tr>
				<tr height="35">
                  <td colspan="2"><input type="hidden" name="ti_id" value="<?=$row_ideas['ti_id'];?>" ></td><td></td>
                    <td><input type="submit" name="submit" value=<? if($ti_id){?>"Update" <? }else{?>"Submit"<? }?> />
                  </td>
                </tr>
            </table></td>
            <td width="1%">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="4"></td>
          </tr>
        </table>
		</td>
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
