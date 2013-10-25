<?php

class Column {
    var $Name;
    var $Type;
   
    function __construct($name, $type) {
        $this->Name = $name;
        $this->Type = $type;
    }
}
?>