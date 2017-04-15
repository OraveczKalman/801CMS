<?php
class LikeBoxController {
    private $likeBoxData;
    private $db;

    public function __construct($likeBoxData, $db) {
        $this->likeBoxData = $likeBoxData;
        $this->db = $db;
        call_user_func(array($this, $this->likeBoxData[0]['event']));
    }

    private function RenderLikeBox() {
        include_once(SITE_VIEW_PATH . 'LikeBoxView.php');
    }
}