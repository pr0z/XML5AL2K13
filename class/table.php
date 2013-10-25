<?php

class Table {
    var $Name;
    var $Columns;
    var $PrimaryKey;
   
    public function __construct(){
        
    }
    
    public function init($name, $columns, $primaryKey) {
        $this->Name = $name;
        $this->Columns = $columns;
        $this->PrimaryKey = $primaryKey;
        }
}