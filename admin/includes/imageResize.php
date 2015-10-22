<? /**
**Image Processing class for resizing the image once the parameters are recorded. The image is resized but not saved yet.
**The image saving is done at the end where the object is created and called from
**Creating true color template for the new image to maintain the quality of the image
**/       
    class imageProcessing{
        var $imageSizeX;
        var $imageSizeY;
        var $resizeX;
        var $resizeY;
        var $reduction_height;
		var $reduction_width;
        var $fileName;
        var $msg;
        var $image;
        var $imageType;
       
/**
** Class constructor to initialize the processing
**/       
        function imageProcessing($imgName,$red_width,$red_height){
            $this->reduction_height=$red_height;
			 $this->reduction_width=$red_width;
            if(is_file($imgName)){
                if(file_exists($imgName)){
                    $this->fileName=$imgName;
                    $this->getSize();
                    $this->setSize();
                    $this->resizeIt();
                    $this->saveImage($imgName);
                }else{
                    $this->errorState(0);
                }
            }else{
                $this->errorState(2);
            }
        }

/**
** Function to set target size for the final image
** This size is based on the aspect ratio of the actual image to maintain the image clarity
**/       
        function setSize()
		{	
			$ratio_image=$this->imageSizeX/$this->imageSizeY;
			$ratio=$this->reduction_width/$this->reduction_height;
			if($ratio_image<$ratio)
			{
			 $ratio_image=$this->imageSizeX/$this->imageSizeY;
			 $this->resizeY=$this->reduction_height;
			 $this->resizeX=round($ratio_image*$this->resizeY);
			}
			else
			{
			 $ratio_image=$this->imageSizeY/$this->imageSizeX;
			 $this->resizeX=$this->reduction_width;
			 $this->resizeY=round($ratio_image*$this->resizeX);
			}
		
            /*if($this->imageSizeY<$this->imageSizeX){
                $ratio=$this->imageSizeY/$this->imageSizeX;
                $this->resizeX=$this->reduction_width;
                $this->resizeY=round($ratio*$this->reduction_width);
            }else{
                $ratio=$this->imageSizeX/$this->imageSizeY;
                $this->resizeY=$this->reduction_height;
                $this->resizeX=round($ratio*$this->reduction_height);
            }*/
        }
       
/**
** Function to identify the image and set the image quality for JPEG images
**
**/       
        function saveImage($imgName){
            switch ($this->imageType){
                case "gif":
                    imagegif($this->image,$imgName);
                    break;
                case "jpg":
                    imagejpeg($this->image,$imgName,100);
                    break;
                case "png":
                    imagepng($this->image,$imgName);
                    break;
            }
        }

       
/**
**Function for fetching the parameters of the image. Identifying image type.
**/           
        function getSize(){
            $imgParams=getimagesize($this->fileName);
            $this->imageSizeX=$imgParams[0];
            $this->imageSizeY=$imgParams[1];
           
            switch($imgParams[2]){
                case 1:
                    $this->imageType="gif";
                    $this->image = imagecreatefromgif($this->fileName);
                    break;

                case 2:
                    $this->imageType="jpg";
                    $this->image = imagecreatefromjpeg($this->fileName);
                    break;
               
                case 3:
                    $this->imageType="png";
                    $this->image = imagecreatefrompng($this->fileName);
                    break;
               
                default:
                    $this->errorState(1);
            }
               
        }

/**
**Function for resizing the image once the parameters are recorded. The image is resized but not saved yet.
**Creating true color template for the new image to maintain the quality of the image
**/       
        function resizeIt(){

            if($this->imageSizeX<=$this->resizeX){
                $this->resizeX=$this->imageSizeX;
            }

            if($this->imageSizeY<=$this->resizeY){
                $this->resizeY=$this->imageSizeY;
            }
            $copy=imagecreatetruecolor($this->resizeX,$this->resizeY);
            if($copy){
                if(imagecopyresampled($copy,$this->image,0,0,0,0,$this->resizeX,$this->resizeY,$this->imageSizeX,$this->imageSizeY)){
                    if(imagedestroy($this->image)){
                        $this->image=$copy;
                    }else{
                        $this->errorState(6);
                    }
                }else{
                    $this->errorState(4);
                }
            }else{
                $this->errorState(5);
            }
        }
       
/**
**Function for error and displaying error messages.
**/           
        function errorState($err){
           
            switch ($err){
                case 0:
                    $this->msg="File Not Found.";
                    break;
                case 1:
                    $this->msg="Invalid File Type.";   
                    break;
                case 2:
                    $this->msg="Invalid Input.";       
                    break;
                case 3:
                    $this->msg="Could Not Save.";       
                    break;
                case 4:
                    $this->msg="Could not Create Image.";       
                    break;
                case 5:
                    $this->msg="Could not Create Blank File.";       
                    break;
                case 6:
                    $this->msg="Unable to Destroy Old File.";       
                    break;
            }
            print $this->msg;
            exit();
        }
    }
?>