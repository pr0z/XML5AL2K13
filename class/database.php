<?php

class Database {
    var $Name;
    var $CreatorName;
    var $CreationDate;
    var $AgencyName;
    var $AgencyDirector;
    var $AgencyAddress;
    var $Tables;
   
    public function __construct($name, $creator, $creation, $aname, $director, $address, $tables) {
        $this->Name = $name;
        $this->CreatorName = $creator;
        $this->CreationDate = $creation;
        $this->AgencyName = $aname;
        $this->AgencyDirector = $director;
        $this->AgencyAddress = $address;
        $this->Tables = $tables;
    }
}