<?php
include_once(CORE_PATH . 'UploadController.php');

class ImageHandling {
    private $pictureProperties;

    public function __construct($pictureProperties) {
        $this -> pictureProperties = $pictureProperties;
    }

    public function uploadGallery() {
        $i=0;
        foreach ($this->pictureProperties['uploadedFiles'] as $uploadedFiles2) {
            if (isset($this->pictureProperties['widthTarget']) && isset($this->pictureProperties['heightTarget'])) {
                $uploadedFiles['successfulUpload'][$i]['thumbFileName'] = '';
                list($width,$height) = getimagesize(UPLOADED_MEDIA_PATH . $uploadedFiles2['fileName']);
                if (isset($this -> pictureProperties['thumbWidthTarget']) && isset($this -> pictureProperties['thumbHeightTarget'])) {
                    $this->editImages($uploadedFiles2['fileName'],
                        'thumb_' . $uploadedFiles2['fileName'],
                        $uploadedFiles2['extension'],
                        $this->pictureProperties['thumbWidthTarget'],
                        $this->pictureProperties['thumbHeightTarget'],
                        $width,
                        $height);
                        $this->pictureProperties['uploadedFiles'][$i]['thumbFileName'] = 'thumb_' . $uploadedFiles2['fileName'];
                }
                if ($this->pictureProperties['widthTarget'] > 0 && $this->pictureProperties['heightTarget'] > 0) {
                    $this->editImages($uploadedFiles2['fileName'],
                        $uploadedFiles2['fileName'],
                        $uploadedFiles2['extension'],
                        $this->pictureProperties['widthTarget'],
                        $this->pictureProperties['heightTarget'],
                        $width,
                        $height);
                }
            }
            $i++;
        }

        return $this->pictureProperties['uploadedFiles'];
    }

    private function editImages($source_pic, $destination_pic, $ext, $t_width, $t_height, $width, $height) {
        $meret_big = $this->ratio($t_width, $t_height, $width, $height);
        $tmp=imagecreatetruecolor($meret_big[0], $meret_big[1]);
       
        switch (strtolower($ext)) {
            case 'gif' :
                $src = imagecreatefromgif(UPLOADED_MEDIA_PATH . $source_pic);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $meret_big[0], $meret_big[1], $width, $height);
                imagegif($tmp, UPLOADED_MEDIA_PATH . $destination_pic);
                break;
            case 'jpg' :
            case 'jpeg' :
                $src = imagecreatefromjpeg(UPLOADED_MEDIA_PATH . $source_pic);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $meret_big[0], $meret_big[1], $width, $height);
                imagejpeg($tmp, UPLOADED_MEDIA_PATH . $destination_pic, 100);
                break;
            case 'png' :
                $src = imagecreatefrompng(UPLOADED_MEDIA_PATH . $source_pic);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $meret_big[0], $meret_big[1], $width, $height);
                imagepng($tmp, UPLOADED_MEDIA_PATH. $destination_pic, 0);
                break;
        }
        
        imagedestroy($src);
        imagedestroy($tmp);
    }

    private function ratio($max_width, $max_height, $width, $height) {
        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;
        if(($width <= $max_width) && ($height <= $max_height)) {
            $tn_width = $width;
            $tn_height = $height;
        } elseif (($x_ratio * $height) < $max_height) {
            $tn_height = ceil($x_ratio * $height);
            $tn_width = $max_width;
        } else {
            $tn_width = ceil($y_ratio * $width);
            $tn_height = $max_height;
        }
        $vissz_tomb = array($tn_width, $tn_height);
        return $vissz_tomb;
    }
}
