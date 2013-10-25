<?php
include 'class/column.php';
include 'class/table.php';
include 'class/database.php';

function ReadDbFile() {
    $db = simplexml_load_file('xml/databases.xml');
    $records = $db->xpath("//database");
    $databases = array();
    foreach ($records as $record) {
        $infos = $record->metaInformations;
        $dbName = $infos->dbName;
        $creatorName = $infos->creatorName;
        $creationDate = $infos->creationDate;

        $tables = array();
        foreach ($record->tables->xpath("//table") as $table) {
            $name = $table->name;
            $columns = array();
            
            foreach ($table->columns->xpath("//column") as $col) {
                $column = new Column($col->name, $col->type);
                array_push($columns, $column);
            }
            
            $tb = new Table($name, $columns);
            array_push($tables, $tb);
        }

        $database = new Database($dbName, $creatorName, $creationDate, $tables);
        array_push($databases, $database);
    }
    
    return $databases;
}

?>
