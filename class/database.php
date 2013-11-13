<?php

class Database {
    var $Name;
    var $CreatorName;
    var $CreationDate;
    var $File;
    
    public function __construct() {
        
    }
    
    public function init($name, $creator, $creation, $file) {
        $this->Name = $name;
        $this->CreatorName = $creator;
        $this->CreationDate = $creation;
        $this->File = $file;
    }
}