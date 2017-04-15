<?php
include_once(SITE_MODEL_PATH . '/TimelineModel.php');

class TimelineController {
    private $docData;
    private $db;

    public function __construct($db, $docData) {
        $where = '';
        $this->docData = $docData;
        $this->db = $db;
        $timeline = new TimelineModel($this->db, $this->docData);
        $timeline -> renderTimeline();
        $this->docData['timelineWhere'] = $where;
    }
}