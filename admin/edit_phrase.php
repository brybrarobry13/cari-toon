<?
		include('includes/configuration.php');
		$img_id =$_REQUEST['img_id'];
        $del=$_REQUEST['del'];
		if($img_id!="")
		{
		
		$sele="SELECT * FROM `toon_img_phrase` WHERE img_id=$img_id";
		
		$result = mysql_query($sele);
		$row=mysql_fetch_assoc($result);
		}
		
 		if(isset($_POST['submit']))
		{
		
		$phrase=$_POST["phrase"];
		if($img_id)
				{
					$sql_update="UPDATE `toon_img_phrase` SET `img_phrase`= '$phrase' WHERE `img_id`='$img_id'";	
					$update_promo=mysql_query($sql_update);
					$msg='Updated Successfully!';
				}
				else
				{
					$sql_insert="INSERT INTO `toon_img_phrase`(`img_phrase`)VALUES ('$phrase')";	
					mysql_query($sql_insert);
					$img_id=mysql_insert_id();
				}
		header("Location:img_phrases.php");
		}			
		include ('includes/header.php');
?>
<script type="text/javascript">
function valid()
{
	clear();
	var valid=true;
		if(document.getElementById("phrase").value=="")
    	{      
		 		document.getElementById("phrase_div").style.display="block";
				valid=false;
     	}
		return valid;
}
function clear()
{
		document.getElementById("phrase_div").style.display="none";
		
			
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

<form action="edit_phrase.php" method="post" onsubmit="return valid()" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="10" border="0" width="97%">
    <tr>
      <td width="2%" valign="top" style="padding-left:12px;"><? include ("includes/leftnav.php");?></td>
      <td align="center"><table cellpadding="0" cellspacing="0" width="100%" class="table_border">
          <tr class="table_titlebar">
            <td class="main_heading" height="30" colspan="4">Manage Caricature Phrases</td>
          </tr>
          <tr>
		  <td height="40px;"></td>
		 </tr>
		  <tr>
            <td width="1%">&nbsp;</td>
            <td width="98%" align="center" valign="top">
            <table cellpadding="5" cellspacing="0" width="60%" class="table_border" border="0">
                <tr>
				<td>&nbsp;</td>
				<td>
				<div id="phrase_div" style="display:none" class="no_details_msg" >Enter Caricature Phrases</div>
				</td>
				</tr>
				<tr>
                  <td width="50%" align="left" class="table_details" valign="top">Caricature Description&nbsp;:*</td>
                  <td width="50%" align="left"><textarea name="phrase" id="phrase" rows="5" cols="25"><?=$row['img_phrase']?></textarea></td>
                </tr>
				<tr height="50">
                  <td><input type="hidden" name="img_id" value="<?=$row['img_id'];?>" ></td>
                    <td><input type="submit" name="submit" value=<? if($img_id){?>"Update" <? }else{?>"Submit"<? }?> />
                  </td>
                </tr>
				
            </table></td>
			
            <td width="1%">&nbsp;</td>
          </tr>
		  
          <tr>
            <td height="40" colspan="4"></td>
          </tr> </table>
        
		
		</td>    </tr>  </table>
</form>

<?	include("includes/footer.php");?>
