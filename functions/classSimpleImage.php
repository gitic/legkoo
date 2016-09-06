<?php
class SimpleImage {

   var $image;
   var $image_type;

   function load($filename) {      
    $image_info = getimagesize($filename);
//    print_arr($image_info);

    //Проверка на содержание PHP Файла
        $pos = strpos($filename,'php');
        if(!($pos === false)) {return FALSE;}
    //Получить расширение файла
        $file_ext = strrchr($filename, '.');
    //Проверка допустимых расширений
        $whitelist = array(".jpg",".jpeg",".gif",".png",".JPG",".JPEG",".GIF",".PNG"); 
        if (!(in_array($file_ext, $whitelist))) {return FALSE;}
    //Проверка типа файла
        $pos = strpos($image_info['mime'],'image');
        if($pos === false) {return FALSE;}       
        if($image_info['mime'] != 'image/gif' && $image_info['mime'] != 'image/jpeg'&& $image_info['mime'] != 'image/jpg'&& $image_info['mime'] != 'image/png') {return FALSE;}
    //Проверка дублирования расширения файла (image with comment)
        if(substr_count($image_info['mime'], '/')>1){return FALSE;}
       
        $this->image_type = $image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
           $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {
           $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {
           $this->image = imagecreatefrompng($filename);
        }
//        Делаем прозрачній фон для изображения png
//        imageAlphaBlending($this->image, false);
//        imageSaveAlpha($this->image, true); 
           
        //Делаем белый фон для изображения jpeg
        $new_image = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagefill($new_image, 0, 0, 0xFFFFFF);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $this->getWidth(), $this->getHeight(), $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
        return true;
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         header("Content-type: image/jpeg");
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         header("Content-type: image/gif");
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         header("Content-type: image/png");
         imagepng($this->image);
      }
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getHeight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getHeight() * $scale/100;
      $this->resize($width,$height);
   }
   function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagefill($new_image, 0, 0, 0xFFFFFF);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
   }
    function cutToSize($width,$height) {
        $w_src = $this->getWidth();
        $h_src = $this->getHeight();
        $new_image = imagecreatetruecolor($width, $height);
        imagefill($new_image, 0, 0, 0xFFFFFF);
        $delta = round($height/$width,2);
        $rec_width = round($this->getHeight()/$delta);
        $space_x = round(($this->getWidth() - $rec_width)/2); 
        if($space_x>0){
            imagecopyresampled($new_image, $this->image, 0, 0, $space_x, 0, $width, $height, $w_src-$space_x*2, $this->getHeight());
        }
        else{
            $delta = round($width/$height,2);
            $rec_height = round($this->getWidth()/$delta);
            $space_y = round(($this->getHeight() - $rec_height)/2);
            imagecopyresampled($new_image, $this->image, 0, 0, 0, $space_y, $width, $height, $this->getWidth(), $h_src-$space_y*2);
        } 
        $this->image = $new_image;
    }
    
    public function maxarea($width, $height = null)	{
        $height = $height ? $height : $width;

        if ($this->getWidth() > $width) {
                $this->resizeToWidth($width);
        }
        if ($this->getHeight() > $height) {
                $this->resizeToheight($height);
        }
    }
        
    public function maxareafill($width, $height, $red = 255, $green = 255, $blue = 255) {
        $this->maxarea($width, $height);
        $new_image = imagecreatetruecolor($width, $height); 
        $color_fill = imagecolorallocate($new_image, $red, $green, $blue);
        imagefill($new_image, 0, 0, $color_fill);   
        imagecopyresampled(	$new_image, 
                                            $this->image, 
                                            floor(($width - $this->getWidth())/2), 
                                            floor(($height-$this->getHeight())/2), 
                                            0, 0, 
                                            $this->getWidth(), 
                                            $this->getHeight(), 
                                            $this->getWidth(), 
                                            $this->getHeight()
                                    ); 
        $this->image = $new_image;
    }
}