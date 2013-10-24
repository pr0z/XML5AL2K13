<?php
$mail = $_POST['mail'];
$password = $_POST['password'];

$xml = simplexml_load_file('xml/users.xml');
$user = $xml->xpath("//user[mail = '" . $mail . "']");

if ($user != NULL) {
    $passw = $user[0]->password;
    if (md5($password) == $passw) {
        include 'head.php';
        ?>
        <div id='bloc'>
            <div id='cssmenu'>
                <ul>
                    <li class='active'><a href='base.php'><span>Dernières bases</span></a></li>
                    <li class=''><a href='util.php'><span>Liste des utilisateurs</span></a></li>            
                    <li class=''><a href='about.php'><span>Contact</span></a></li>
                </ul>
            </div>
            <div id="contenu">
                <?php
                    $db = simplexml_load_file('xml/realestate.xml');
                    $records = $db->xpath("//database");
                    $databases = array();
                    foreach ($records as $record){
                        $infos = $record->metaInformations;
                        $dbName = $infos->dbName;
                        $creatorName = $infos->creatorName;
                        $creationDate = $infos->creationDate;
                        $agencyName = $infos->agencyName;
                        $agencyDirector = $infos->agencyDirector;
                        $agencyAddress = $infos->agencyAddress;
                        
                        $tables = array();
                        $tbs = $record->xpath("//tables");
                        foreach ($tbs as $table){
                            foreach($table->children() as $tableName){
                                array_push($tables, $tableName->getName());
                            }
                        }
                        
                        $database = new Database($dbName, $creatorName, $creationDate, $agencyName, $agencyDirector, $agencyAddress, $tables);
                        array_push($databases, $database);
                    }
                ?>
            </div>
        </div>
        <?php
        include 'foot.php';
    } else {
        header('Location:index.php?err=passw');
    }
} else {
    header('Location:index.php?err=nouser');
}
?>