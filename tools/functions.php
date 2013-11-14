<?php
include 'class/column.php';
include 'class/table.php';
include 'class/database.php';

function ReadDbFile() {
    $db = simplexml_load_file('xml/databases.xml');
    $records = $db->xpath("//database");
    return ListXML($records);
}

function GetDbByUsername($username) {
    $userFile = simplexml_load_file('xml/users.xml');
    $user = $userFile->xpath("//user[firstName = '" . $username . "']");
    if ($user != NULL) {
        $db = simplexml_load_file('xml/databases.xml');
        $records = $db->xpath("//database[contains(., '$username')]");
        if ($records != NULL) {
            return ListXML($records);
        } else {
            return "norecord";
        }
    } else {
        return "nouser";
    }
    
    return null;
}

function GetDbByDate($criteria, $date){
    $fdt = DateTime::createFromFormat("Y-m-d", $date);;
    $xml = simplexml_load_file('xml/databases.xml');
    $records = $xml->xpath("//database");
    $results = array();
    $operator = "";
    
    switch ($criteria) {
        case "before":
            $operator = "<";
            break;
        case "after":
            $operator = ">";
            break;
        case "on":
            $operator = "==";
            break;
        default:
            break;
    }
    
    foreach ($records as $db) {
        $path = "xml/" . (string) $db;
        $xml = simplexml_load_file($path);
        $infos = $xml->metaInformations;
        $dbName = (string) $infos->dbName;
        $creatorName = (string) $infos->creatorName;
        $creationDate = (string) $infos->creationDate;
        
        $cdt = DateTime::createFromFormat("d/m/Y", $creationDate);
        $condition = "return ".$cdt." ".$operator." ".$fdt.";";
        echo var_dump(eval($condition));
        echo "toto";
        $test = false;
        
        /*switch ($criteria) {
        case "before":
            var_dump($cdt<$fdt);
            if ($cdt < $fdt) $test = true;
            break;
        case "after":
            var_dump($cdt>$fdt);
            if ($cdt > $fdt) $test = true;
            break;
        case "on":
            var_dump($cdt==$fdt);
            if ($cdt == $fdt) $test = true;
            break;
        default:
            break;
    }*/
        
        if ($test){
            echo $creationDate." ok<br />";
            $database = new Database();
            $database->init($dbName, $creatorName, $creationDate, $db);
            array_push($results, $database);
        } else {
            echo $creationDate." ko <br/>";
        }
    }
    
    return 1;
}

function ListXML($xmlElement) {
    $databases = array();
    foreach ($xmlElement as $db) {
        $path = "xml/" . (string) $db;
        $xml = simplexml_load_file($path);
        $infos = $xml->metaInformations;
        $dbName = (string) $infos->dbName;
        $creatorName = (string) $infos->creatorName;
        $creationDate = (string) $infos->creationDate;

        $database = new Database();
        $database->init($dbName, $creatorName, $creationDate, $db);
        array_push($databases, $database);
    }
    return $databases;
}

function DisplayResults($sectionTitle, $results) {
    ?>
    <h3 class="mainTitle"><?php echo $sectionTitle;?></h3>
    <?php
    foreach ($results as $db) {
        ?>
        <div class="dbContainer">
            <h4 class="dbTitle" style="width:380px;"><?php echo $db->Name; ?></h4>
            <i class="dbInfos">Ajoutée par <?php echo $db->CreatorName; ?>, le <?php echo $db->CreationDate; ?></i><br />
            <div class="container-bt">
                <form method="post" action="steptwo.php" class="formBase" style="margin-left:-245px;">
                    <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                    <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                    <input type="submit" value="Consulter / Editer" />
                </form>
                <form method="post" action="" class="formBase" style="margin-left:-90px;">
                    <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                    <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                    <input type="submit" value="Supprimer" onClick="">
                </form>
            </div>
        </div>
        <br />
        <?php
    }
    ?>
    <?php
}