<?php
class AncestorClass {
    public function IsNullOrEmpty($value) {
        if (is_null($value) || empty($value) || $value=='') {
            return true;
        } else {
            return false;
        }
    }
}
