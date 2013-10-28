<?php
session_start();
$nbtables = $_GET['nbtables'];
$tables = $_SESSION['tables'];

$user_name = "user-name";
$db_name = $_SESSION['dbname'];

// variable contenant le xml
$xml_script = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\r\n";
$xml_script .= "\r<database>\r\n";
$xml_script .= "\t<metaInformations>\r\n";
$xml_script .= "\t\t<dbName>$db_name</dbName>\r\n";
$xml_script .= "\t\t<creatorName>$user_name</creatorName>\r\n";
$xml_script .= "\t\t<creationDate>$_SESSION['dbname']</creationDate>\r\n";
$xml_script .= "\t</metaInformations>\r\n";

$colsByTable = array();
for ($i = 0; $i < $nbtables; $i++ ){
    $id = $id+1;
    $tb = $tables[$i];
    $cols = array();
    $infos = array();
    for ($j = 0; $j < $tb[1]; $j++){
        $col = array();
        $idcol = $j+1;
        $name = $_GET['colname'.$idcol.'-'.$id];
        $type = $_GET['typecol'.$idcol.'-'.$id];
        array_push($col, $name);
        array_push($col, $type);    
        array_push($cols, $col);
    }
    array_push($infos, $id);
    array_push($infos, $tb[0]);
    array_push($infos, $cols);
    array_push($colsByTable, $infos);
}

echo "<pre>";
print_r($colsByTable);

$xml_script .= "\r</database>\r\n";

// Ecriture du fichier XML
$file = fopen("xml/$user_name/$db_name.xml", "w+");
fwrite($file, $_xml);
fclose($file);

echo "</pre>";
session_destroy();
?>
