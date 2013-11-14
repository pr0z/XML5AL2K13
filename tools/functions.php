<?php
include 'class/column.php';
include 'class/table.php';
include 'class/database.php';

function ReadDbFile() {
    $db = simplexml_load_file('xml/databases.xml');
    $records = $db->xpath("//database");
    return ListXML($records);
}

function GetDbNames() {
    $xml = simplexml_load_file('xml/databases.xml');
    $records = $xml->xpath("//database");
    $names = array();

    foreach ($records as $db) {
        $path = "xml/" . (string) $db;
        $xml = simplexml_load_file($path);
        $infos = $xml->metaInformations;
        $dbName = (string) $infos->dbName;

        array_push($names, $dbName);
    }

    return $names;
}

function GetXpathQuery($dbname, $query) {
    $xml = simplexml_load_file('xml/databases.xml');
    $db = $xml->xpath("//database[contains(., '$dbname')]");
    if ($db != NULL) {
        $path = "xml/" . (string) $db[0];
        $dbf = simplexml_load_file($path);
        $result = $dbf->xpath($query);
        if ($result != NULL) {
            echo "<b>Contenu de la balise &lt;" . $result[0]->getName() . "&gt;</b> :<br /><br />";
            $level = 0;
            BrowseNode($result[0], $level);
            return "ok";
        }
    } else {
        return "nodb";
    }

    return "noresult";
}

function BrowseNode($xmlNode, $level) {
    $closed = false;
    
    //si le noeud a des enfants, on va les parcourir
    if (count($xmlNode->children()) > 0) {
        for($i = 0; $i < $level; $i++) echo "|&nbsp;&nbsp;";
        echo "<b>&lt;" . $xmlNode->getName() . "&gt;<br /></b>";
        
        foreach ($xmlNode->children() as $node) {
            BrowseNode($node[0], $level + 1);
        }
    } else { //sinon on l'affiche
        for($i = 0; $i < $level; $i++) echo "|&nbsp;&nbsp;";
        echo "<b>&lt;" . $xmlNode->getName() . "&gt;" . (string) $xmlNode . "&lt;/" . $xmlNode->getName() . "&gt;</b> <br />";
        $closed = true;
    }
    
    if (!$closed){//si la balise n'a pas été refermée on la referme
        for($i = 0; $i < $level; $i++) echo "|&nbsp;&nbsp;";
        echo "<b>&lt;/" . $xmlNode->getName() . "&gt;</b><br />";
    }
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

function GetDbByDate($criteria, $date) {
    $fdt = DateTime::createFromFormat("Y-m-d", $date);
    $xml = simplexml_load_file('xml/databases.xml');
    $records = $xml->xpath("//database");
    $results = array();

    foreach ($records as $db) {
        $path = "xml/" . (string) $db;
        $xml = simplexml_load_file($path);
        $infos = $xml->metaInformations;
        $dbName = (string) $infos->dbName;
        $creatorName = (string) $infos->creatorName;
        $creationDate = (string) $infos->creationDate;

        $cdt = DateTime::createFromFormat("d/m/Y", $creationDate);
        $test = false;

        switch ($criteria) {
            case "before":
                if ($cdt < $fdt)
                    $test = true;
                break;
            case "after":
                if ($cdt > $fdt)
                    $test = true;
                break;
            case "on":
                if ($cdt == $fdt)
                    $test = true;
                break;
            default:
                break;
        }

        if ($test) {
            $database = new Database();
            $database->init($dbName, $creatorName, $creationDate, $db);
            array_push($results, $database);
        }
    }

    return$results;
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
    <h3 class="mainTitle"><?php echo $sectionTitle; ?></h3>
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

function GetFormattedTitle($criteria, $date) {
    $date = DateTime::createFromFormat("Y-m-d", $_GET['date'])->format("d/m/Y");
    switch ($criteria) {
        case "before":
            return "Liste des bases créées avant le " . $date;
            break;
        case "after":
            return "Liste des bases créées après le " . $date;
            break;
        case "on":
            return "Liste des bases créées le " . $date;
            break;
        default:
            return null;
            break;
    }
}