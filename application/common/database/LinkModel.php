<?php
class LinkModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getRole($dataArray) {
        $role = $this->db->selectBuilder($dataArray);
        return $role;
    }
}
