<?
//*****************************************************************
//Project:		ftp backup
//Authors:		maTekk
//Date Created:	16-03-2008
//Description:	this file is used to take bkup of db and files
//db bacckup file name format   XXXX_db_YYYYMMDDHHMM.gz
//file backup file name format   XXXX_fl_YYYYMMDDHHMM.tar
//configure backup directory in matekk - use $ftp_dir
//*******************************************************************
///////////////////////////////////configuration//////////////////////////////////////////
$host		= "localhost";//host name
$user		= "ccdbuser"; //db username
$pass		= "CCbd12\!Pa"; //db password
$db			= "ccdb";     //db name
$prefix		= "cton";	  //sholuld be 4 chars of project name
$backupdir  = '_backups';//folder name
$docRoot    = "/var/www/vhosts/caricaturetoons.com";//root path
$backupof   = $docRoot."/httpdocs";

  
  
$ftp_user_name='matekkbkup';
$ftp_user_pass='matekK1bkup';
$ftp_server='ftp.matekk.com';
$ftp_dir='caricaturetoons';  //directory in matekk server where bkup files will be copied
///////////////////////////////////configuration//////////////////////////////////////////
  
$day="";   
$month="";
$year="";
$hour="";
$min="";
$sec="";
// Compute day, month, year, hour and min.
$today = getdate();

$day = $today['mday'];
if ($day < 10) {
  $day = "0$day";
}

$month = $today['mon'];
if ($month < 10) {
  $month = "0$month";
}
$year = $today['year'];  
$hour = $today['hours'];
if ($hour < 10)
$hour="0$hour"; 
$min = $today['minutes'];
if ($min < 10)
$min="0$min"; 

$sec = "00";

// Execute mysqldump command.
// It will produce a file named $db-$year$month$day-$hour$min.gz
// under $DOCUMENT_ROOT/$backupdir
$systemCmd = sprintf(
	'/usr/bin/mysqldump --opt -h %s -u %s -p%s %s | gzip > %s/%s/%s_db_%s%s%s%s%s.gz',                          
	$host,
	$user,
	$pass,
	$db,
	$docRoot,
	$backupdir,
	$prefix,
	$year,
	$month,
	$day,
	$hour,
	$min
  ); 
  
$myFile = $docRoot . "/" . $backupdir . "/sysCmdMysql.sh";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $systemCmd);
fwrite($fh, "\n");

/*  
$systemCmd = sprintf('tar -cf %s/%s/%s_fl_%s%s%s%s%s.tar %s', 
  	$docRoot,
    $backupdir,
  	$prefix,	
	$year,
    $month,
    $day,
	$hour,
	$min,
	$backupof
  ); 
fwrite($fh, $systemCmd);
fclose($fh);
*/
//wait for the shell to create the file
sleep(240);
// copying files to matekk server

//$bkfile=$prefix."_fl_".$year.$month.$day.$hour.$min.".tar";  // file backup  compressed
$bksql=$prefix."_db_".$year.$month.$day.$hour.$min.".gz";    // sql backup compressed
//$destination_file_bkup=$ftp_dir."/".$bkfile;
$destination_sql_bkup=$ftp_dir."/".$bksql;
//$backfile=$docRoot."/".$backupdir."/".$bkfile;
$backsql=$docRoot."/".$backupdir."/".$bksql;

$conn_id 		= ftp_connect($ftp_server);
$login_result 	= ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

//FTP the DB
if(file_exists($backsql))
{
	if (ftp_put($conn_id, $destination_sql_bkup, $backsql, FTP_BINARY))
	echo "sql backup copied \n";
}





//FTP the Files
/*if(file_exists($backfile))
{				
	if (ftp_put($conn_id, $destination_file_bkup, $backfile, FTP_BINARY))
	echo "file backup copied";
}*/
ftp_close($conn_id);

////// Deleting files more than 15 days old and is not created on the first day of a month/////////////////////////////// 
function dateDiff($dformat, $endDate, $beginDate)
{
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
	if(($end_date - $start_date) > 15 && $date_parts1[1]!='1')
	{
		return 1;
	}
	else
	{
		return -1;
	}
}


function readpath($dir,$level,$last,&$dirs,&$files){
	//print $dir." (DIR)<br/>\n";
	$dp=opendir($dir);
	while (false!=($file=readdir($dp)) && $level == $last){
		if ($file!="." && $file!="..")
		{
			if (is_dir($dir."/".$file))
			{
				readpath($dir."/".$file,$level,$last,$dirs,$files);
				if(!in_array("$dir/$file",$dirs))
					$dirs[] = "$dir/$file"; 
			}
			else{
				if(!in_array("$dir/$file",$files))
					$files[] = "$dir/$file";
			}
		}
	}
}

$today_string=strtotime("now");
$date_today = date('m-d-Y',$today_string);

$start_dir = $docRoot."/".$backupdir;  // backup directory in production server

if (is_dir($start_dir))
{
	$level=1; 
	$last=1; 
	$dirs = array(); 
	$files = array(); 
	
	readpath($start_dir,$level, $last, $dirs,$files);
	
	sort($files); 
	
	foreach($files as $file)
	{    
		$filename = $file;
		
		$fname = explode("/",$filename);
		$fname = end($fname);
		$name=substr($fname,14,2);// day part of date string
		$file_date=substr($fname,12,2)."-".substr($fname,14,2)."-".substr($fname,8,4);//mm-dd-yyyy

		if (file_exists($filename)) 
		{
			$date_comp=dateDiff("-",$date_today,$file_date);
			if($date_comp > 0 && $name!='01') {
				//echo "unlinked";
				//unlink($filename);
			} else {
				//echo "not unlinked";
			}
		}
		else
		{
			echo "File not Found";
		}
		
	}
}
echo '\n +DONE \n'; 

?>