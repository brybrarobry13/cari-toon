<?  include("includes/configuration.php");
	include("includes/paging.class_sub.php");
	ini_set("memory_limit","2000M");
	include('includes/imageResize.php');
	include("includes/resizeimage.php");
	$user_id= $_SESSION['sess_tt_uid'];//Fetching the userid
	$getuserDetails = getUserDetails($user_id);//Fetching the user details according to the userid
	$artist_id=$_REQUEST['art_id'];
	$size_error = "";
	$type_error = "";

	if($artist_id=="")
	{
		header("location:index.php");
		exit();	
	}

	if($getuserDetails['utype_id']==2)
	{
		$user=$user_id;
	}
	else
	{
		$user=$artist_id;
	}
	
	$artist_name_query = mysql_query("SELECT * FROM `toon_users` WHERE `user_id`='$user' AND approval_status='Approved'");
	$artist_name_row=mysql_fetch_array($artist_name_query);
	$artist_name_numrow=mysql_num_rows($artist_name_query);
	if($artist_name_numrow==0){
		header("location:../../index.php");
		exit();
	}
	
	if(isloggedIn() && $getuserDetails['utype_id']==2)
	{
		if(isset($_POST['update']) && $_POST['update'] != "")
		{
			mysql_query("UPDATE `toon_artist_gallery` SET `agal_priority` ='0' WHERE `user_id`='$user_id'");
			foreach($_POST['update'] as $value)
			{
				$sql="UPDATE `toon_artist_gallery` SET `agal_priority` ='1'";
				$sql.=" WHERE `agal_id`='".$value."'";
				$query=mysql_query($sql);
			}
		}
	
		if(isset($_REQUEST['image_id']) && $image=$_REQUEST['image_id'])
		{
			$photoname_query=mysql_query("SELECT * FROM `toon_artist_gallery` WHERE `agal_id`='".$image."' AND `user_id`='".$user_id."'");
			$photoname_row=mysql_fetch_array($photoname_query);
			$photonum=mysql_num_rows($photoname_query);
			if($photonum>0)
			{
				$del_query="DELETE FROM `toon_artist_gallery` WHERE `agal_id`='".$image."'";
				mysql_query($del_query);
				@unlink(DIR_ARTIST_GALLERY.$photoname_row['agal_image']);
				@unlink(DIR_ARTIST_GALLERY.$photoname_row['opro_image']);
				
				$org_1=substr($photoname_row['agal_image'],3,(strlen($photoname_row['agal_image'])-3));
				$org_2=substr($photoname_row['opro_image'],3,(strlen($photoname_row['opro_image'])-3));
				
				@unlink("z_uploads/artist_gallery/artist_images/".$org_1);
				@unlink("z_uploads/artist_gallery/artist_images/".$org_2);
			}
		}
	
		if(isset($_POST['submit_btn']))
		{
			$text_before=addslashes($_POST['text_before']);
			$text_after=addslashes($_POST['text_after']);
			
			$photoName1 = str_replace("'","_",(str_replace(" ","_",$_POST['photo_1'])));
			$photoName2 = str_replace("'","_",(str_replace(" ","_",$_POST['photo_2'])));
	
			mysql_query("INSERT INTO `toon_artist_gallery` (`opro_image`,`agal_image`,`user_id`,`text_before`,`text_after` )VALUES ('$photoName1','$photoName2','$user','$text_before','$text_after')");	
			
			$name = mysql_insert_id();																			  						 				
			$newname1 = 'th_'.$name.'_'.$photoName1;
			$newname2 = 'th_'.$name.'_'.$photoName2;
	
			mysql_query("UPDATE `toon_artist_gallery` SET `opro_image`='$newname1', `agal_image` ='$newname2' WHERE `agal_id`='$name'");
			
			copy("z_uploads/artist_gallery/thumb_artist_images/th_".$photoName1, "z_uploads/artist_gallery/thumb_artist_images/th_".$name."_".$photoName1);
			unlink("z_uploads/artist_gallery/thumb_artist_images/th_".$photoName1);
			copy("z_uploads/artist_gallery/artist_images/".$photoName1, "z_uploads/artist_gallery/artist_images/".$name."_".$photoName1);
			unlink("z_uploads/artist_gallery/artist_images/".$photoName1);
			//copy("z_uploads/artist_gallery/for_crop_".$photoName1, "z_uploads/artist_gallery/for_crop_".$name."_".$photoName1);
			unlink("z_uploads/artist_gallery/artist_images/for_crop_".$photoName1);
			
			copy("z_uploads/artist_gallery/thumb_artist_images/th_".$photoName2, "z_uploads/artist_gallery/thumb_artist_images/th_".$name."_".$photoName2);
			unlink("z_uploads/artist_gallery/thumb_artist_images/th_".$photoName2);
			copy("z_uploads/artist_gallery/artist_images/".$photoName2, "z_uploads/artist_gallery/artist_images/".$name."_".$photoName2);
			unlink("z_uploads/artist_gallery/artist_images/".$photoName2);
			//copy("z_uploads/artist_gallery/for_crop_".$photoName2, "z_uploads/artist_gallery/for_crop_".$name."_".$photoName2);
			unlink("z_uploads/artist_gallery/artist_images/for_crop_".$photoName2);
		}
	}	
	$pagination_object=new paging;
	$pagenum=$pagination_object->setPageNumber($_GET['page']);
	$maxrows=$pagination_object->setDisplayRows(20);
	$pagination_object->setURL($_SERVER['PHP_SELF'],base64_encode(serialize($_GET)));
	$query = "SELECT * FROM `toon_artist_gallery` WHERE `user_id`='$user' ORDER BY `agal_id` DESC , `opro_image` DESC";
	$rs_artists=mysql_query($query);
	$num=@mysql_num_rows($rs_artists);
	$sku_count=$pagination_object->setTotalPages($num);
	if($sku_count <= $pagenum)
	$pagenum=$pagination_object->setPageNumber($totalpages-1);
	$startrow=$pagination_object->setStartRow();
	$query.=" LIMIT $startrow,$maxrows";
	$rs_artists=mysql_query($query);	
	
	if($getuserDetails['utype_id']==2)
	{
		$title_text = "Caricature Gallery:";
		include (DIR_INCLUDES.'artist_header.php');
	}
	else
	{
		$title_text = "Caricature Samples and Styles:";
		include (DIR_INCLUDES.'header.php');
	}
	
	if($artist_id)
	{
		$artist_total_qry = mysql_query("SELECT * FROM toon_orders WHERE artist_id='".$artist_id."'");
		$artist_total_orders = @mysql_num_rows($artist_total_qry);	
		
		$artist_like_qry = mysql_query("SELECT * FROM toon_orders WHERE review_rating = 1 AND artist_id='".$artist_id."'");
		$artist_like_rating=@mysql_num_rows($artist_like_qry);
		if($artist_like_rating>0)
		{
			$artist_like_rating = $artist_like_rating;
		}
		else
		{
			$artist_like_rating = 0;
		}
		$artist_dislike_qry = mysql_query("SELECT * FROM toon_orders WHERE review_rating = 0 AND artist_id='".$artist_id."'");
		$artist_dislike_rating=@mysql_num_rows($artist_dislike_qry);
		if($artist_dislike_rating>0)
		{
			$artist_dislike_rating = $artist_dislike_rating;
		}
		else
		{
			$artist_dislike_rating = 0;
		}
		
		if($artist_total_orders>0)
		{
			$per_ord = round(($artist_like_rating/$artist_total_orders)*100);
		}
		else
		{
			$per_ord = 100;
		}
	}
	
?> 

<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="js/ajaxsbmt.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-pack.js"></script>
<script type="text/javascript" src="js/jquery.imgareaselect-0.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$_SERVER['HTTP_HOST']?>styles/highslide.css" />
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/highslide-with-html.js"></script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/highslide-full.js"></script>
<script type="text/javascript" src="<?=$_SERVER['HTTP_HOST']?>javascripts/imageswap.js"></script>
<link href="<?=$_SERVER['HTTP_HOST']?>styles/style.css" rel="stylesheet" type="text/css" />
<!--<base href="http://www.toonsforu.com/" />-->
<base href="http://www.caricaturetoons.com/" />
<!--<base href="http://localhost/priswin/caricaturetoons/" />-->
<script type="text/javascript">
	hs.graphicsDir = 'images/graphics/';
	hs.captionText ="<a onclick='hs.close();'><img src='images/close.gif' /></a>",
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.dimmingOpacity = 0.75;

	// define the restraining box
	hs.useBox = true;
	hs.width = 280;
	hs.height = 400;

	// Add the controlbar
	hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: false,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: 1,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
</script>
<script>
var canNavigate = 0;
function confirmation()
{
	if(confirm("Do you really want to delete?"))
	{
		canNavigate = 1;
		return true;
	}
	return false;	
}
function validation()
{
		document.getElementById("error_beforedescription").style.display='none';
		document.getElementById("error_afterdescription").style.display='none';
		document.getElementById("error_forfirstimage").style.display='none';
		document.getElementById("error_forsecondimage").style.display='none';
		
		
		
		if (document.getElementById("cropped_1").value=='no')
		{
			document.getElementById("error_forfirstimage").style.display='block';
			return false;
		}
		
		if (document.getElementById("cropped_2").value=='no')
		{
			
			document.getElementById("error_forsecondimage").style.display='block';
			return false;
		}
		
		if (document.getElementById("text_before").value=='')
		{
			document.getElementById("error_beforedescription").style.display='block';
			return false;
		}
		else
		{
		document.getElementById("error_beforedescription").style.display='none';
		}
		
		if (document.getElementById("text_after").value=='' && document.getElementById("text_after").value=='')
		{
			document.getElementById("error_afterdescription").style.display='block';
			return false;
		}
		else
		{
		document.getElementById("error_afterdescription").style.display='none';
		}
	document.getElementById("loader").style.display='block';
	canNavigate = 1;
	
}
function check_no()
{
	var checkedCount = findChecked_count();
	if(checkedCount > 3)
	{
		alert("You have already selected three images");
		return false;
	}
	else
	{
		canNavigate =1;
		document.artist_gallery.submit();
		return true;
	}
}
function findChecked_count()
{
	var checked = 0;
	for(i=0;i<document.artist_gallery.update.length;i++)
	{
		if(document.artist_gallery.update[i].checked)
		{
			checked++;
		}
	}
	return checked;
}

window.onbeforeunload = function ()
{
	var checkedCount = findChecked_count();
	if(canNavigate == 0 && checkedCount < 3)
		return "You have not identified 3 profile images for your Gallery.";
}

</script>
 <link href="style/style.css" rel="stylesheet" type="text/css" />
   
<script language="javascript" type="text/javascript">

function startUpload(divid){
		
		if(divid==1)
		{
      		document.getElementById('f1_upload_process_1').style.visibility = 'visible';
			 document.getElementById('f1_upload_form_1').style.visibility = 'hidden';
			 
		}
		else
		{
			document.getElementById('f1_upload_process_2').style.visibility = 'visible';
			 document.getElementById('f1_upload_form_2').style.visibility = 'hidden';
		}
     
      return true;
}

function stopUpload(success,file_name){
//alert(file_name);
      var result = '';
      if (success == 1){
	  window.open('templates/jcrop_main.php?file_name='+file_name,'crop','width=1000,height=620,scrollbars=0');
         //result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
		 //result='<img src="z_uploads/ok/'+file_name+'" width="500" height="300" />';
		<?php /*?> result='<img src="z_uploads/ok/'+file_name+'" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail"  /><div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;"><img src="z_uploads/ok/'+file_name+'" style="position: relative;" alt="Thumbnail Preview" /></div>';<?php */?>
			
		
		 
      }
      else 
	  {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process_1').style.visibility = 'hidden';
	   document.getElementById('f1_upload_process_2').style.visibility = 'hidden';
     // document.getElementById('crop_image_1').innerHTML = result;
      document.getElementById('f1_upload_form_1').style.visibility = 'visible';  
	  document.getElementById('f1_upload_form_2').style.visibility = 'visible';     
	  if(file_name.substr(0,5)=='befor')
	  {
	 	 document.getElementById('photo_1').value=file_name;
		 document.getElementById("cropped_1").value="no";
		// alert(file_name);
	  }
	  else if(file_name.substr(0,5)=='after')
	  {
	  
	  	 document.getElementById('photo_2').value=file_name;
		 document.getElementById("cropped_2").value="no";
		 //alert("newrrrrr"+file_name);
	  }
	  else
	  {
	  	
	  }
	  /*alert(document.getElementById("cropped_1").value);
	  alert(document.getElementById("cropped_2").value);*/
      return true;   
}

function set_cropped_no(img_id)
{
	if(img_id=='1')
	{
		document.getElementById("cropped_1").value="no";
	}
	
	if(img_id=='2')
	{
		document.getElementById("cropped_2").value="no";
	}
}

function submit_form(f_type)
{

	if(f_type == 1)
	{
		startUpload(1);
		document.form_image_1.submit();
	}
	else
	{
		startUpload(2);
		document.form_image_2.submit();
	}
}
</script>  

<!--header ends-->
<!--content starts-->
<div id="content">
    <? if($getuserDetails['utype_id']!=2) { ?>
    <div style="height:80px;">
        <div style="float:left; width:185px;">&nbsp;</div>
        <div style="padding:0 0 0 140px;float:left;"><img src="<?=$_SERVER['HTTP_HOST']?>images/source_caricatures.png" border="0"/></div>
        <div style="padding:0 0 0 780px;">
        <script type="text/javascript" src="http://cdn.socialtwist.com/2011113055505/script.js"></script><a class="st-taf" href="http://tellafriend.socialtwist.com:80" onclick="return false;" style="border:0;padding:0;margin:0;"><img alt="SocialTwist Tell-a-Friend" style="border:0;padding:0;margin:0;" src="http://images.socialtwist.com/2011113055505/button.png" onmouseout="STTAFFUNC.hideHoverMap(this)" onmouseover="STTAFFUNC.showHoverMap(this, '2011113055505', window.location, document.title)" onclick="STTAFFUNC.cw(this, {id:'2011113055505', link: window.location, title: document.title });"/></a>
        </div>
    </div>
    <div style="height:150px;">
        <div style="float: left; width: 190px; padding: 0pt 0pt 0pt 15px;position:absolute;z-index:1000;"><a href="terms.php"><img src="<?=$_SERVER['HTTP_HOST']?>images/guarantee-seal.png" width="190px" border="0" /></a></div>
        <div style="padding: 30px 10px 0px 220px;position:absolute;" >
             <div class="header_text" style="vertical-align:text-bottom;width:600px;font-weight:bold;">Below are some great Caricature Toons Samples along with the original images supplied. Click the enlarge button to get a closer look at any of the caricatures.</div>					
             <div style="padding: 85px 0pt 0pt 130px;">
                <a href="order-caricature.php?artistname=<?=$artist_name_row['user_fname'];?>" style="text-decoration:none;"><div class="orderimagetxt"><?=strtoupper($artist_name_row['user_fname'])?><span style="padding-left:5px;"><img src="<?=$_SERVER['HTTP_HOST']?>images/smile_image.png" border="0"/></span></div>
                <img src="<?=$_SERVER['HTTP_HOST']?>images/order_caricature.png"  border="0" /></a>			
             </div> 
        </div>
        <div style="float:right;margin:-50px 0px 0px 0px;" >
            <div class="imagetest"><? echo strtoupper($artist_name_row['user_fname']."'s");?></div>
            <div><img src="<?=$_SERVER['HTTP_HOST']?>images/enjoy_artist's.gif" width="187" height="288" /></div>
            <div class="image"><img src="<?=$_SERVER['HTTP_HOST']?>z_uploads/profile_images/<? if($artist_name_row['user_image']) { echo $artist_name_row['user_image']; } else { echo "noimage.gif"; } ?>" width="155" height="150" border="0"/></div>
        </div>
    </div>    
    <div style="height:75px;"></div>
    <? } ?>
    <div style="height:35px;"></div>
    <div>			
        <div class="artistprice_white_curve_middle_border" style="margin-left:40px; margin-right:20px; margin-bottom:20px; width:900px; border-radius:15px; -moz-border-radius:15px; -webkit-border-radius:15px;">
            <div style="float:left;margin-left:200px;" class="div_text"><?=$size_error?></div>
            <div style="float:left;margin-left:200px;" class="div_text"><?=$type_error?></div>
            <div style="-moz-border-radius:35px;">
                <div style="margin-top: 10px; float: right; position: absolute; padding-left: 646px;"><img src="<?=$_SERVER['HTTP_HOST']?>images/happy.png" /><a href="reviewfeedback.php?artist_id=<?=$artist_name_row['user_id']?>" onclick="return hs.htmlExpand(this,{headingText: '', objectType: 'iframe',width:700,height:450 })"><div style="margin-top: 10px; position: relative; width: 46px; height: 16px; float: right; margin-left: -56px; margin-right: 5px;"><img src="<?=$_SERVER['HTTP_HOST']?>images/reviews.png" /></div></a>
                <div style="font-family: Arial,Helvetica,sans-serif; color: rgb(161, 246, 0); position: absolute; font-weight: bold; margin-top: -42px; font-size: 25px; width: 45px; text-align: right; margin-left: 60px;"><? echo $per_ord; ?></div>
                <div style="font-family: Arial,Helvetica,sans-serif; color: rgb(161, 246, 0); position: absolute; font-weight: bold; font-size: 12px; margin-left: 170px; margin-top: -44px;"><? echo $artist_like_rating; ?></div>
                <div style="font-family: Arial,Helvetica,sans-serif; color: rgb(161, 246, 0); position: absolute; font-weight: bold; font-size: 12px; margin-left: 170px; margin-top: -25px;"><? echo $artist_dislike_rating; ?></div>
                </div>
                <div style="height:60px;"></div>
                <div style="height:60px;clear:left;text-align:center;"><img alt="<?=$artist_name_row['user_fname']."'s idea gallery and style"?>" title="<?=$artist_name_row['user_fname']."'s idea gallery and style"?>" src="<?=$_SERVER['HTTP_HOST']?>show_text/<? echo base64_encode(strtoupper($artist_name_row['user_fname']."'S IDEA GALLERY & STYLE"));?>/17/" border="0"  />
                &nbsp;&nbsp;<div style="margin-left:641px;color:#887F7A;font-family:Arial;font-size:18px;font-size-adjust:none;font-style:normal;font-variant:normal;font-weight:bold;line-height:normal; margin-top: 16px;" >
                <b>PAGES <?=$pagenum+1?> OF <?=$sku_count?></b>
                </div>
                <div style="margin: -20px 0pt 0pt 845px; position: relative;">
					<?php $pagination_object->pagenation();?>
                </div>
                </div>
                 
                <div style="width: 890px; text-align: center; padding-bottom: 50px; padding-top: 20px;">
                    <form action="art-gall.php?art_id=<?=$_SESSION['sess_tt_uid']?>" name="artist_gallery" method="post">
                    <?
                    $image_description=mysql_query("SELECT `img_phrase` FROM `toon_img_phrase`");
                    $img_num = mysql_num_rows($image_description);
                    $i=0;
                    while($image_description_result = mysql_fetch_array($image_description ))
                    {
                        $image_descp[$i]=$image_description_result['img_phrase'];
                        $i++;
                    }
                    while($row = mysql_fetch_assoc($rs_artists ))
                    {
                        $imgpath='artist_gallery/thumb_artist_images';
                        $type='artist';
                        if($row['opro_image']!=""){?>
                        <div align="center" <? if($user_id!="" && $getuserDetails['utype_id']==2){ ?> style="float:left;margin: 8px 10px 3px 5px;height:375px;width:205px;text-align:center;" <? } else { ?> style="float: left; margin: 8px 10px 3px 5px; text-align: center;height:300px;width:205px;"<? } ?> >
                        <? if($user_id!="" && $getuserDetails['utype_id']==2){?><div class="text_blue" >Before Image</div><? }?>
                            <div class="gallery_position">
                            <div style="margin-left: 10px;">
                                <div class="artistgallery_first_img" align="center" style="vertical-align:top;">
                                <? $apro_image=stripslashes($row['opro_image']); ?>
                                <? if($row['text_before']!='') { $alt=$title=stripslashes($row['text_before']).' - '.$image_descp[rand(1,$img_num)-1]; }?>
                                &nbsp;<img src="<?=$_SERVER['HTTP_HOST']?>z_uploads/artist_gallery/thumb_artist_images/<? echo $apro_image;?>" border="0" width="204"/>
                                </div>
                          </div>
                          <div style="height:10px;"></div>
                          <? $org_bfr_img=str_replace("th_","",$apro_image); ?>
                          <div class="price_enlarge_btn_first_img" style="text-align:center;"><a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/artist_gallery/artist_images/<? echo $org_bfr_img; ?>" onclick="return hs.expand(this)" ><img src="<?=$_SERVER['HTTP_HOST']?>images/enlarge.png" border="0" alt="enlarge" title="Enlarge" width="80" /></a>&nbsp;&nbsp;&nbsp;
                          <? if(isloggedIn()&&$getuserDetails['utype_id']==2){?><a onClick="return confirmation()" href="<?=$_SERVER['HTTP_HOST']?>art-gall.php?art_id=<?=$artist_id?>&image_id=<?=$row['agal_id']?>"><img src="<?=$_SERVER['HTTP_HOST']?>images/delete.png" title="Delete this Picture" alt="Delete this Picture" border="0"/></a><? } ?> </div>
                          <div style="color:#04B431;display" id="saveb<?php echo $row['agal_id']?>"></div>
                        </div>
                            <div  class="text_blue" style="text-align:left"><?=$row['agal_code'];?></div>
                            <?  if($getuserDetails['utype_id']==2) { ?>
                            <div  class="text_blue" style="text-align:center;float:left;clear:left;margin-left:52px;"><input type="checkbox" name="update[]" id="update" <? if($row['agal_priority']==1){ echo 'checked="checked"';}?> onClick="return check_no()" value="<?=$row['agal_id'];?>" />Show in front&nbsp;&nbsp;</div>
                            <? } ?>
                        </div>
                         <? } ?>
                        <div align="center" <? if($user_id!="" && $getuserDetails['utype_id']==2){ ?> style="float:left;margin: 8px 10px 3px 5px;height:375px;width:205px;text-align:center"<? } else { ?> style="float: left; margin: 8px 10px 3px 5px; text-align: center;height:300px;width:205px;" <? } ?> >
                            <div class="gallery_position">
                            <? if($user_id!="" && $getuserDetails['utype_id']==2){ ?><div class="text_blue" >After Image</div><? }?>
                            <div style="margin-left: 10px;">
                                <div class="artistgallery_first_img" align="center" style="vertical-align:top;">
                                <? if($row['text_after']!='') { $alt=$title=stripslashes($row['text_after']).' - '.$image_descp[rand(1,$img_num)-1]; }?>
                                <? $agal_image=stripslashes($row['agal_image']); ?>
                                &nbsp;<img src="<?=$_SERVER['HTTP_HOST']?>z_uploads/artist_gallery/thumb_artist_images/<? echo $agal_image;?>" border="0" width="204"/>
                                </div>
                            </div>
                               <div style="height:10px;"></div>
                               <? $org_aftr_img=str_replace("th_","",$row['agal_image']); ?>
                              <div class="price_enlarge_btn_first_img" style="text-align:center;" >
                              <a href="<?=$_SERVER['HTTP_HOST']?>z_uploads/artist_gallery/artist_images/<?=$org_aftr_img?>" onClick="return hs.expand(this)" ><img src="<?=$_SERVER['HTTP_HOST']?>images/enlarge.png" border="0" alt="enlarge" title="Enlarge" width="80" /></a>&nbsp;&nbsp;&nbsp;
                              <? if(isloggedIn() && $getuserDetails['utype_id']==2){?><a onClick="return confirmation()" href="<?=$_SERVER['HTTP_HOST']?>art-gall.php?art_id=<?=$artist_id?>&image_id=<?=$row['agal_id']?>"><img src="<?=$_SERVER['HTTP_HOST']?>images/delete.png" title="Delete this Picture" alt="Delete this Picture" border="0"/></a><? } ?> </div>
                            <div style="color:#04B431;display:block" id="savea<?php echo $row['agal_id']?>"></div>
                            </div>
                            <? if($row['opro_image']=="") { ?>
                            <div  class="text_blue" style="text-align:left"><?=$row['agal_code'];?></div>
                            <? }?>
                        </div>
                    <? } ?>
                    </form>
					<div style="clear:both;"></div>
                    <? if($getuserDetails['utype_id']==2) { ?>
                    <!--<form action="upload.php" name="MyForm" method="post" enctype="multipart/form-data">-->
                    <div style="height:20px;"></div>
                    <div style="clear-both;margin-left:100px;">
                        <div style="float:left;margin-left:0px;display:none; width:500px; text-align:left;" class="div_text" id="error_forsecondimage">*Please choose and crop your after image</div>
                        <div style="float:left;margin-left:0px;display:none; width:500px; text-align:left;" class="div_text" id="error_forfirstimage">*Please choose and crop your before image</div>	
                        <div style="float:left;margin-left:0px;display:none; width:500px; text-align:left;" class="div_text" id="error_afterdescription">*Please enter description of size 20 for after image  </div>
                        <div style="float:left;margin-left:0px;display:none; width:500px; text-align:left;" class="div_text" id="error_beforedescription">*Please enter description of size 20 for before image </div>
                    </div>           
        <div id="contents" style="padding-left:35px; float:left;">
            <form action="upload.php?type=befor" name="form_image_1" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload(1);" >
                 <p id="f1_upload_process_1"><span class="text_blue">Loading...</span><br/><img src="<?=$_SERVER['HTTP_HOST']?>images/loader.gif" /><br/></p>
                 <p id="f1_upload_form_1" style="style=" color:#044BA2;float:left;margin-left:0px;clear:left;margin-top:10px;" class="text_blue""><br/>
                     <label>Before Image:
                          <input name="myfile" type="file" id="myfile_1" onchange="set_cropped_no(1);submit_form(1);" size="30"  />
                     </label>
                     <label>
                        <!-- <input type="submit" name="submitBtn" class="sbtn" value="Crop Image" />-->
                     </label>
                     <input type="hidden" name="sess_val" value="<?=$_SESSION['sess_tt_uid']?>" />
                 </p>
                 <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
             </form>
            <form action="upload.php?type=after" name="form_image_2" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload(2);" >
                 <p id="f1_upload_process_2"><span class="text_blue">Loading...</span><br/><img src="<?=$_SERVER['HTTP_HOST']?>images/loader.gif" /><br/></p>
                 <p id="f1_upload_form_2" style=" color:#044BA2;float:left;" class="text_blue"><br/>
                     <label>After Image:&nbsp;&nbsp;&nbsp;
                          <input name="myfile" type="file" id="myfile_2" onchange="set_cropped_no(2);submit_form(2);" size="30"  />
                     </label>
                    <label>
                    <!--     <input type="submit" name="submitBtn" class="sbtn" value="Crop Image" />-->
                     </label>
                     <input type="hidden" name="sess_val" value="<?=$_SESSION['sess_tt_uid']?>" />
                 </p>
                 <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
             </form>
         </div>
         <form action="art-gall.php?art_id=<?=$_SESSION['sess_tt_uid']?>" method="post" enctype="multipart/form-data">
         <div style="float:left;" class="text_blue">
         <div style="padding-top:15px;">
        Description: <input type="text" name="text_before" id="text_before" maxlength="20" />
        </div>
        <div style="padding-top:15px;">
         <br />Description: <input type="text" name="text_after" id="text_after" maxlength="20" />
         </div>
         </div>
        <div style="float:left;margin-left:0px;clear:left;margin-top:10px; padding-left:35px; padding-top:20px;"  class="text_blue_10">
        <input type="hidden" name="photo_1" id="photo_1" value="" />
        <input type="hidden" name="photo_2" id="photo_2" value="" />
        <input type="hidden" name="cropped_1" id="cropped_1" value="no" />
        <input type="hidden" name="cropped_2" id="cropped_2" value="no" />
        <input type="submit" onClick="return validation()" name="submit_btn" value="Save Cropped Images & Descriptions"  style="width: 250px; height: 30px;"/>&nbsp;
          (Important: please only upload jpg, gif or png all other file types will not appear in your gallery.)<br/><br/><br/></div>
        </div>
                </form>
                <?
                    }
                ?>
                <div style="clear:both"></div>
            </div>	
        </div>
    </div>
    <div>
		<? if(isloggedIn()) {?>
        <div style="clear:both; height:15px;">&nbsp;</div>
        <? }  else { ?>					
        <div style="clear:both; height:450px;">&nbsp;</div>
        <div class="header_text" style="padding-left:30px;"><b>* Win a FREE Caricature is open to all those on our mailing list.</br>
Once a month we choose a winner from people who are on our mailing list and announce it in one of our monthly email blasts.</b></div>
        <? }?>
    </div>
</div>

<!--content ends-->	
<!--footer-->	

<? if($getuserDetails['utype_id']==2)
{
include (DIR_INCLUDES.'artist_footer.php');
}
else
{
include (DIR_INCLUDES.'footer.php') ;
} ?>

<script>
function savetext(id,row,type,s_id)
{
	var text;
	text=document.getElementById(id).value;
	var p_id=row;
	var t_type=type;
	var sav=s_id;
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById(s_id).innerHTML=xmlhttp.responseText;
			setTimeout('document.getElementById("'+s_id+'").style.display="block"',1)
			setTimeout('document.getElementById("'+s_id+'").style.display="none"',2000)
		}
	}
	document.getElementById(s_id).innerHTML='saving...';  
	xmlhttp.open("GET","savetext_ajax.php?text="+text+"&id="+p_id+"&type="+t_type,true);
	xmlhttp.send();
}
</script>