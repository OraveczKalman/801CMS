<?php
include_once(CORE_PATH . 'UploadController.php');

class ImageHandling {
    private $pictureProperties;

    public function __construct($pictureProperties) {
        $this -> pictureProperties = $pictureProperties;
    }

    public function uploadGallery() {
        $i=0;
        for ($i=0; $i<=count($this->pictureProperties['uploadedFiles'])-1; $i++) {
            //var_dump($uploadedFiles2);
            $uploadedFiles['successfulUpload'][$i]['thumbFileName'] = '';
            list($width,$height) = getimagesize(UPLOADED_MEDIA_PATH . $this->pictureProperties["uploadedFiles"][$i]['fileName'] . "." . $this->pictureProperties["uploadedFiles"][$i]["extension"]);
            if ($this->pictureProperties['widthTarget'] == 0 && $this->pictureProperties['heightTarget'] == 0) {
                $this->pictureProperties['widthTarget'] = $width;
                $this->pictureProperties['heightTarget'] = $height;
            }
            if (isset($this -> pictureProperties['thumbWidthTarget']) && isset($this -> pictureProperties['thumbHeightTarget'])) {
                $this->editImages($this->pictureProperties["uploadedFiles"][$i]['fileName'],
                    'thumb_' . $this->pictureProperties["uploadedFiles"][$i]['fileName'],
                    $this->pictureProperties["uploadedFiles"][$i]["mime"],
                    $this->pictureProperties["uploadedFiles"][$i]['extension'],
                    $this->pictureProperties['thumbWidthTarget'],
                    $this->pictureProperties['thumbHeightTarget'],
                    $width,
                    $height,
                    "thumb");
                    $this->pictureProperties['uploadedFiles'][$i]['thumbFileName'] = 'thumb_' . $this->pictureProperties["uploadedFiles"][$i]['fileName'];
            }
            $this->editImages($this->pictureProperties["uploadedFiles"][$i]['fileName'],
                $this->pictureProperties["uploadedFiles"][$i]['fileName'],
                $this->pictureProperties["uploadedFiles"][$i]["mime"],
                $this->pictureProperties["uploadedFiles"][$i]['extension'],
                $this->pictureProperties['widthTarget'],
                $this->pictureProperties['heightTarget']);
        }

        return $this->pictureProperties['uploadedFiles'];
    }

    private function editImages($source_pic, $destination_pic, $mime, $ext, $width, $height, $t_width=null, $t_height=null, $mode=null) {
        //var_dump($source_pic);
        if (is_null($t_height)) {
            $t_height = $height;
        }
        if (is_null($t_width)) {
            $t_width = $width;
        }
        $meret_big = $this->ratio($t_width, $t_height, $width, $height);
        $tmp=imagecreatetruecolor($meret_big[0], $meret_big[1]);
        switch (strtolower($mime)) {
            case 'gif' :
                $src = imagecreatefromgif(UPLOADED_MEDIA_PATH . $source_pic);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $meret_big[0], $meret_big[1], $width, $height);
                imagewebp($tmp, UPLOADED_MEDIA_PATH . $destination_pic);
                break;
            case 'image/jpeg' :
                //var_dump($destination_pic);
                $src = imagecreatefromjpeg(UPLOADED_MEDIA_PATH . $source_pic . "." . $ext);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $meret_big[0], $meret_big[1], $width, $height);
                imagewebp($tmp, UPLOADED_MEDIA_PATH . $destination_pic . ".webp", 100);
                if (!is_null($mode)) {
                    imagejpeg($tmp, UPLOADED_MEDIA_PATH . $destination_pic . "." . $ext);
                }
                break;
            case 'png' :
                $src = imagecreatefrompng(UPLOADED_MEDIA_PATH . $source_pic);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $meret_big[0], $meret_big[1], $width, $height);
                //imagewebp($tmp, UPLOADED_MEDIA_PATH. $destination_pic);
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
