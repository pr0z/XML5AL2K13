<?php

class Database {
    var $Name;
    var $CreatorName;
    var $CreationDate;
    var $Tables;
    
    public function __construct() {
        
    }
    
    public function init($name, $creator, $creation, $tables) {
        $this->Name = $name;
        $this->CreatorName = $creator;
        $this->CreationDate = $creation;
        $this->Tables = $tables;
    }
}