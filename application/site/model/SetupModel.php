<?php
class SetupModel {
    public static function getSetupData($setupId, $db) {
        $getSetupDataQueryString = 'SELECT * FROM setupdata WHERE SetupId = ' . $setupId;
        $getSetupDataQuery = $db -> selectQuery($getSetupDataQueryString, $error);
        return $getSetupDataQuery;
    }
}