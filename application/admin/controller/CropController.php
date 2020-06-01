<?php 
include_once(MODEL_PATH . 'GalleryModel.php');

class CropController {
    private $dataArray;
    private $db;

    public function __construct($dataArray, $db) {
        $this->dataArray = $dataArray;
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderCropForm';
        }
        $this->db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function RenderCropForm() {
        list($origWidth, $origHeight, $type, $attr) = getimagesize(PATH_LEVEL_UP1 . "resources/uploaded/media/" . $this->dataArray[0]['fileName']);
        $ratio = $this -> dataArray[0]['targW'] / $this->dataArray[0]['targH'];
        include_once(ADMIN_VIEW_PATH . "CropForm.php");		
    }

    private function ImageCrop() {
        $size = getimagesize(PATH_LEVEL_UP1 . "resources/uploaded/media/" . $this->dataArray[0]['fileName']);
        list($orig_width, $orig_height, $type, $attr) = getimagesize(PATH_LEVEL_UP1 . "resources/uploaded/media/" . $this->dataArray[0]['fileName']);
        $mime = image_type_to_mime_type($type);

        $img_name_array = explode('/', $this -> dataArray[0]['fileName']);
        $thumb_name_array = explode('/', $this -> dataArray[0]['thumbFileName']);
        switch ($this -> dataArray[0]['modeHidden']) {
            case 0 :
                $f_idopont = date('YmdHis');
                $fileInfo = pathinfo($this -> dataArray[0]['thumbFileName']);
                $fileInfoArray = explode('_', $fileInfo['filename']);
                $basename = $fileInfoArray[0] . '_' . $fileInfoArray[1] . '_' . $f_idopont . '_' . $fileInfoArray[3] . '.' . $fileInfo['extension'];
                $filename = PATH_LEVEL_UP1 . "resources/uploaded/media/" . $basename;
                $pictureInfo['thumbKepnev'] = $basename;
                $pictureInfo['picId'] = $this -> dataArray[0]['picId'];
                $pic = new GalleryModel($this->db, $pictureInfo);
                $pic -> updatePictureThumbnail($pictureInfo);
                if (file_exists($this -> dataArray[0]['thumbFileName'])) {
                    unlink($this -> dataArray[0]['thumbFileName']);
                }
                break;
            case 1 :
                $filename = './' . $img_name_array[1] . '/' . $img_name_array[2];
                break;
            case 2 :
                $filename = './' . $img_name_array[1] . '/' . $img_name_array[2];
                break;
            case 3 :
                $filename = './' . $img_name_array[1] . '/' . $thumb_name_array[2];
                break;
            case 4 :
                $filename = './' . $img_name_array[1] . '/' . $thumb_name_array[2];
                break;
        }
        
        $tmp = imagecreatetruecolor($this->dataArray[0]['targW'], $this -> dataArray[0]['targH']);
      
        switch ($mime) {
            case "image/pjpeg" :
            case "image/jpeg" :
                $src = imagecreatefromjpeg(PATH_LEVEL_UP1 . "resources/uploaded/media/" . $this->dataArray[0]['fileName']);
                imagecopyresampled($tmp, $src, 0, 0, $this -> dataArray[0]['x'], $this -> dataArray[0]['y'], $this -> dataArray[0]['targW'], $this -> dataArray[0]['targH'], $this -> dataArray[0]['w'], $this -> dataArray[0]['h']);
                imagejpeg($tmp, $filename, 100);
                imagedestroy($tmp);
                imagedestroy($src);
                print $this->dataArray[0]['MainHeaderId'];
                break;
            case "image/gif" :
                $img_name_array = explode('/', $this -> dataArray[0]['fileName']);
                $src = imagecreatefromgif($this -> dataArray[0]['fileName']);
                imagecopyresampled($tmp, $src, 0, 0, $this -> dataArray[0]['x'], $this -> dataArray[0]['y'], $this -> dataArray[0]['targW'], $this -> dataArray[0]['targH'], $this -> dataArray[0]['w'], $this -> dataArray[0]['h']);
                imagegif($tmp, $this -> dataArray[0]['thumbFileName'], 0);
                imagedestroy($src);
                imagedestroy($tmp);
                print $this->dataArray[0]['MainHeaderId'];
                break;
            case "image/png" :
                $img_name_array = explode('/', $this -> dataArray[0]['fileName']);
                $src = imagecreatefrompng($this -> dataArray[0]['fileName']);
                imagecopyresampled($tmp, $src, 0, 0, $this -> dataArray[0]['x'], $this -> dataArray[0]['y'], $this -> dataArray[0]['targW'], $this -> dataArray[0]['targH'], $this -> dataArray[0]['w'], $this -> dataArray[0]['h']);
                imagepng($tmp, $this -> dataArray[0]['thumbFileName'], 0);
                imagedestroy($src);
                imagedestroy($tmp);
                print $this->dataArray[0]['MainHeaderId'];
                break;
        }
    }
}
