<?php
class SponsorController {
    private $sponsorData;
    private $db;

    public function __construct($db, $sponsorData=null) {
        if (!is_null($sponsorData)) {
            $this->sponsorData = $sponsorData;
        }
        $this->db = $db;
        call_user_func(array($this, $this->sponsorData[0]['event']));
    }

    private function RenderSponsors() {
        include_once(SITE_VIEW_PATH . 'SponsorView.php');
    }
}