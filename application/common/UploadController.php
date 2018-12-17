<?php
class UploadController {
    private $dataArray;

    public function __construct($dataArray) {
        $this->setDataArray($dataArray);
    }

    public function setDataArray($dataArray) {
        $this->dataArray = $dataArray;
    }

    public function uploadFiles() {
        $uploadResult = array();
        $uploadResult['successfulUpload'] = array();
        $uploadResult['unSuccesfulUpload'] = array();
        $i = 1;
        foreach ($_FILES[$this->dataArray[0]['fileArrayName']]["error"] as $key => $error) {
            var_dump($_FILES);
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES[$this->dataArray[0]['fileArrayName']]["tmp_name"][$key];
                $pth = pathinfo($_FILES[$this->dataArray[0]['fileArrayName']]["name"][$key]);
                if ($this->dataArray[0]['rename'] == 1) {
                    $name = $this->dataArray[0]['newName'] . '_' . date('YmdHis') . '_' . $i . '.' . $pth['extension'];
                } else {
                    $name = $_FILES[$this->dataArray[0]['fileArrayName']]["name"][$key];
                }
                move_uploaded_file($tmp_name, $this->dataArray[0]['uploadPath'] . $name);
                chmod($this->dataArray[0]['uploadPath'] . $name, 0644);
                array_push($uploadResult['successfulUpload'], array('fileName' => $name, 'extension' => $pth['extension']));
            } else {
                $pth = pathinfo($_FILES[$this->dataArray[0]['fileArrayName']]["name"][$key]);
                array_push($uploadResult['unSuccesfulUpload'], array('fileName' => $_FILES[$this->dataArray[0]['fileArrayName']]["name"][$key], 'extension' => $pth['extension']));
            }
            $i++;
        }
        return $uploadResult;
    }
}