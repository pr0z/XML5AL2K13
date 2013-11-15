<?php
include 'class/column.php';
include 'class/table.php';
include 'class/database.php';

function ReadDbFile() {
    $db = simplexml_load_file('xml/databases.xml');
    $records = $db->xpath("//database");
    return ListXML($records);
}

function GetUsers() {
    $xml = simplexml_load_file('xml/users.xml');
    $users = $xml->xpath("//user");
    $results = array();

    foreach ($users as $user) {
        $us = array();
        $us['firstName'] = (string) $user->firstName;
        $us['name'] = (string) $user->name;
        $us['mail'] = (string) $user->mail;
        $us['rights'] = (string) $user->rights;

        array_push($results, $us);
    }

    DisplayUsers($results);
}

function DeleteUser($firstName, $name) {
    $xml = simplexml_load_file('xml/users.xml');
    $user = $xml->xpath("//user[firstName = '" . $firstName . "' and name = '" . $name . "']");
    $dom = dom_import_simplexml($user[0]);
    $dom->parentNode->removeChild($dom);
    $xml->asXML('xml/users.xml');
    header('Location:admin.php');
}

function ChangeUserRights($firstName, $name, $rights) {
    $xml = simplexml_load_file('xml/users.xml');
    $user = $xml->xpath("//user[firstName = '" . $firstName . "' and name = '" . $name . "']");
    $user[0]->rights = $rights;
    $xml->asXML('xml/users.xml');
    if ($user[0]->firstName == $_SESSION['user']) {
        $_SESSION['right'] = $rights;
    }
    header('Location:admin.php');
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
        $results = $dbf->xpath($query);
        if ($results != NULL) {
            echo "<h3 class='mainTitle'>Résultats pour : '" . $query . "'</h3>";
            $level = 0;
            foreach ($results as $result)
                BrowseNode($result, $level);
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
        for ($i = 0; $i < $level; $i++)
            echo "|&nbsp;&nbsp;";
        echo "<b>&lt;" . $xmlNode->getName() . "&gt;<br /></b>";

        foreach ($xmlNode->children() as $node) {
            BrowseNode($node[0], $level + 1);
        }
    } else { //sinon on l'affiche
        for ($i = 0; $i < $level; $i++)
            echo "|&nbsp;&nbsp;";
        echo "<b>&lt;" . $xmlNode->getName() . "&gt;</b>" . (string) $xmlNode . "<b>&lt;/" . $xmlNode->getName() . "&gt;</b> <br />";
        $closed = true;
    }

    if (!$closed) {//si la balise n'a pas été refermée on la referme
        for ($i = 0; $i < $level; $i++)
            echo "|&nbsp;&nbsp;";
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
    $fdt = DateTime::createFromFormat("m/d/Y", $date);
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

function RegisterUser($firstName, $name, $mail, $password) {
    $xml = simplexml_load_file('xml/users.xml');

    $user = $xml->addChild('user');
    $user->addChild('firstName', $firstName);
    $user->addChild('name', $name);
    $user->addChild('mail', $mail);
    $user->addChild('password', md5($password));
    $user->addChild("rights", 'read');

    $xml->asXML('xml/users.xml');
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
                <?php if (isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?>
                    <form method="post" action="editTable.php" class="formBase" style="margin-left:-245px;">
                        <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                        <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                        <input type="submit" value="Consulter / Editer" />
                    </form>
                    <form method="post" action="deleteBase.php" class="formBase" style="margin-left:-90px;" onSubmit="return confirmDelete('Etes-vous sûr de vouloir supprimer cette structure de base de données?');">
                        <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                        <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                        <input type="submit" value="Supprimer">
                    </form>
                <?php } else {
                    ?>
                    <form method="post" action="consultTable.php" class="formBase" style="margin-left:-90px;">
                        <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                        <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                        <input type="submit" value="Consulter" />
                    </form>
                <?php } ?>
            </div>
        </div>
        <br />
        <?php
    }
    ?>
    <?php
}

function DisplayUsers($users) {
    foreach ($users as $user) {
        ?>
        <div class="dbContainer">
            <h4 class="dbTitle" style="width:380px;"><?php echo $user['firstName'] . " " . $user['name']; ?></h4>
            <i class="dbInfos">Droits <?php echo "-" . $user['rights']; ?></i><br />
            <div class="container-bt">
                <form method="post" action="updateUser.php" class="formBase" style="margin-left:-225px;">
                    <input type="hidden" name="firstName" value="<?php echo $user['firstName']; ?>" />
                    <input type="hidden" name="name" value="<?php echo $user['name']; ?>" />
                    <input type="hidden" name="type" value="updateRights" />
                    <input type="submit" value="Gérer les droits" />
                </form>
                <form method="post" action="updateUser.php" class="formBase" style="margin-left:-90px;">
                    <input type="hidden" name="firstName" value="<?php echo $user['firstName']; ?>" />
                    <input type="hidden" name="name" value="<?php echo $user['name']; ?>" />
                    <input type="hidden" name="type" value="deleteUser" />
                    <input type="submit" value="Supprimer" />
                </form>
            </div>
        </div>
        <br />
        <?php
    }
}

function GetFormattedTitle($criteria, $date) {
    $fdt = DateTime::createFromFormat("m/d/Y", $date)->format("d/m/Y");
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
