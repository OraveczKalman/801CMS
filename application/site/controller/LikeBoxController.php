<?php
class LikeBoxController {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray = null) {
        if ($dataArray != null) {
            $this->dataArray = $dataArray;
        }
        if (!isset($this->dataArray[0]['event'])) {
            $this->dataArray[0]['event'] = 'RenderLikeBox';
        }
        $this->db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function RenderLikeBox() {
        include_once(SITE_VIEW_PATH . 'LikeBoxView.php');
    }
}