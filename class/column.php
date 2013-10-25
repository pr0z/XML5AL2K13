<?php

class Column {
    var $Name;
    var $Type;
    var $IsPrimaryKey;
   
    function __construct($name, $type) {
        $this->Name = $name;
        $this->Type = $type;
    }
}
?>