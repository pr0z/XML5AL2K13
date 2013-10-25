<?php

class Table {
    var $Name;
    var $Columns;
   
    public function __construct($name, $columns) {
        $this->Name = $name;
        $this->Columns = $columns;
    }
}