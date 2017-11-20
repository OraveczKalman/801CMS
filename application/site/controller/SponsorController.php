<?php
class SponsorController {
    private $dataArray;
    private $db;

    public function __construct($db, $dataArray=null) {
        if (!is_null($dataArray)) {
            $this->dataArray = $dataArray;
        }
        $this->db = $db;
        call_user_func(array($this, $this->dataArray[0]['event']));
    }

    private function RenderSponsors() {
        include_once(SITE_VIEW_PATH . 'SponsorView.php');
    }
}