<?php

include 'class/column.php';
include 'class/table.php';
include 'class/database.php';

function ReadDbFile() {
    $db = simplexml_load_file('xml/databases.xml');
    $records = $db->xpath("//database");
    return BuildBusinessObjects($records);
}

function GetDbByUsername($username) {
    $db = simplexml_load_file('xml/databases.xml');
    $records = $db->xpath("//database[metaInformations/creatorName = '" . $username . "']");
    return BuildBusinessObjects($records);
}

function BuildBusinessObjects($xmlElement){
    $databases = array();
    foreach ($xmlElement as $record) {
        $infos = $record->metaInformations;
        $dbName = (string) $infos->dbName;
        $creatorName = (string) $infos->creatorName;
        $creationDate = (string) $infos->creationDate;

        $tables = array();
        foreach ($record->tables->children() as $table) {
            $name = (string) $table->name;
            $primaryKey = (string) $table->primaryKey;
            $columns = array();

            foreach ($table->columns->children() as $col) {
                $column = new Column((string) $col->name, (string) $col->type);
                array_push($columns, $column);
            }


            $tb = new Table($name, $columns, $primaryKey);
            array_push($tables, $tb);
        }

        $database = new Database($dbName, $creatorName, $creationDate, $tables);
        array_push($databases, $database);
    }

    return $databases;
}