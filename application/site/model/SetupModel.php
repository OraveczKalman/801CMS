<?php
class SetupModel {
    public static function getSetupData($setupId, $db) {
        $result = array();
        $getSetupDataArray['sql'] = 'SELECT * FROM setupdata WHERE SetupId=:setupId';
        $getSetupDataArray['parameters'][0] = array("paramName"=>"setupId", "paramVal"=>$setupId, "paramType"=>1);
        $result = $db->parameterSelect($getSetupDataArray);
        return $result;
    }
}