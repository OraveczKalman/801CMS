<?php 
include_once('../model/gallery_model.php');

class CropController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        $this->db = $db;
    }

    private function RenderCropForm() {
        list($orig_width, $orig_height, $type, $attr) = getimagesize($this -> dataArray[0]['filename']);
        $ratio = $this -> dataArray[0]['targ_w'] / $this -> dataArray[0]['targ_h'];
        require_once "templates/app_crop_form.php";		
    }

    private function ImageCrop() {
        $size = getimagesize($this -> dataArray[0]['filename']);
        list($orig_width, $orig_height, $type, $attr) = getimagesize($this -> dataArray[0]['filename']);
        $mime = image_type_to_mime_type($type);

        $img_name_array = explode('/', $this -> dataArray[0]['filename']);
        $thumb_name_array = explode('/', $this -> dataArray[0]['thumb_filename']);
        switch ($this -> dataArray[0]['mode']) {
            case 0 :
                $f_idopont = date('YmdHis');
                $fileInfo = pathinfo($this -> dataArray[0]['thumb_filename']);
                $fileInfoArray = explode('_', $fileInfo['filename']);
                $basename = $fileInfoArray[0] . '_' . $fileInfoArray[1] . '_' . $f_idopont . '_' . $fileInfoArray[3] . '.' . $fileInfo['extension'];
                $filename = '../' . $img_name_array[1] . '/' . $basename;
                $pictureInfo['ThumbKepnev'] = $basename;
                $pictureInfo['pic_id'] = $this -> dataArray[0]['pic_id'];
                $pic = new Gallery_Model(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
                $pic -> updatePictureThumbnail($pictureInfo);
                if (file_exists($this -> dataArray[0]['thumb_filename'])) {
                    unlink($this -> dataArray[0]['thumb_filename']);
                }
                break;
            case 1 :
                $filename = '../' . $img_name_array[1] . '/' . $img_name_array[2];
                break;
            case 2 :
                $filename = '../' . $img_name_array[1] . '/' . $img_name_array[2];
                break;
            case 3 :
                $filename = '../' . $img_name_array[1] . '/' . $thumb_name_array[2];
                break;
            case 4 :
                $filename = '../' . $img_name_array[1] . '/' . $thumb_name_array[2];
                break;
        }
        
        $tmp = imagecreatetruecolor($this -> dataArray[0]['targ_w'], $this -> dataArray[0]['targ_h']);
      
        switch ($mime) {
            case "image/pjpeg" :
            case "image/jpeg" :
                $src = imagecreatefromjpeg($this -> dataArray[0]['filename']);
                imagecopyresampled($tmp, $src, 0, 0, $this -> dataArray[0]['x'], $this -> dataArray[0]['y'], $this -> dataArray[0]['targ_w'], $this -> dataArray[0]['targ_h'], $this -> dataArray[0]['w'], $this -> dataArray[0]['h']);
                imagejpeg($tmp, $filename, 100);
                imagedestroy($tmp);
                imagedestroy($src);
                print '<img class="img-thumbnail" src="' . $filename . '" />';
                break;
            case "image/gif" :
                $img_name_array = explode('/', $this -> dataArray[0]['filename']);
                $src = imagecreatefromgif($this -> dataArray[0]['filename']);
                imagecopyresampled($tmp, $src, 0, 0, $this -> dataArray[0]['x'], $this -> dataArray[0]['y'], $this -> dataArray[0]['targ_w'], $this -> dataArray[0]['targ_h'], $this -> dataArray[0]['w'], $this -> dataArray[0]['h']);
                imagegif($tmp, $this -> dataArray[0]['thumb_filename'], 0);
                imagedestroy($src);
                imagedestroy($tmp);
                print '<img class="img-thumbnail" src="' . $filename . '" />';
                break;
            case "image/png" :
                $img_name_array = explode('/', $this -> dataArray[0]['filename']);
                $src = imagecreatefrompng($this -> dataArray[0]['filename']);
                imagecopyresampled($tmp, $src, 0, 0, $this -> dataArray[0]['x'], $this -> dataArray[0]['y'], $this -> dataArray[0]['targ_w'], $this -> dataArray[0]['targ_h'], $this -> dataArray[0]['w'], $this -> dataArray[0]['h']);
                imagepng($tmp, $this -> dataArray[0]['thumb_filename'], 0);
                imagedestroy($src);
                imagedestroy($tmp);
                print  '<img class="img-thumbnail" src="' . $filename . '" />';
                break;
        }
    }
}
?>