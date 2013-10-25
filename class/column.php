<?php

class Column {
    var $Name;
    var $Type;
    var $IsPrimaryKey;
   
    public function __construct() {
    }
    
    public function init($name, $type) {
        $this->Name = $name;
        $this->Type = $type;
    }
}
?>