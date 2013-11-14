<?php
session_start();
$nbtables = $_GET['nbtables'];
$tables = $_SESSION['tables'];

$user_name = $_SESSION['user'];;
$db_name = $_SESSION['dbname'];
$date = date('d/m/o');

// variable contenant le xml
$xml_script = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\r\n";
$xml_script .= "<database>\r\n";
$xml_script .= "\t<metaInformations>\r\n";
$xml_script .= "\t\t<dbName>$db_name</dbName>\r\n";
$xml_script .= "\t\t<creatorName>$user_name</creatorName>\r\n";
$xml_script .= "\t\t<creationDate>$date</creationDate>\r\n";
$xml_script .= "\t</metaInformations>\r\n";
$xml_script .= "\t<tables>\r\n";

$colsByTable = array();
$id = 0;
for ($i = 0; $i < $nbtables; $i++ ){
    $id = $id+1;
    $tb = $tables[$i];
    $xml_script .= "\t\t<table>\r\n";
	$xml_script .= "\t\t\t<name>$tb[0]</name>\r\n";
	$xml_script .= "\t\t\t<columns>\r\n";
    $cols = array();
    $infos = array();
    for ($j = 0; $j < $tb[1]; $j++){
    	$col = array();
        $idcol = $j+1;
        $name = $_GET['colname'.$idcol.'-'.$id];
        $type = $_GET['typecol'.$idcol.'-'.$id];
    	$xml_script .= "\t\t\t\t<column>\r\n";
    	$xml_script .= "\t\t\t\t\t<name>$name</name>\r\n";
    	$xml_script .= "\t\t\t\t\t<type>$type</type>\r\n";
    	$xml_script .= "\t\t\t\t</column>\r\n";
        array_push($col, $name);
        array_push($col, $type);    
        array_push($cols, $col);
    }
    $xml_script .= "\t\t\t</columns>\r\n";
    $xml_script .= "\t\t</table>\r\n";
    array_push($infos, $id);
    array_push($infos, $tb[0]);
    array_push($infos, $cols);
    array_push($colsByTable, $infos);
}

//echo "<pre>";
//print_r($colsByTable);

$xml_script .= "\t</tables>\r\n";
$xml_script .= "</database>\r\n";

// Ecriture du fichier XML
if (!file_exists("xml/$user_name")) mkdir("xml/$user_name", 0777, true);
$file = fopen("xml/$user_name/$db_name.xml", "w+");
fwrite($file, $xml_script);
fclose($file);

$list_scripts = simplexml_load_file("xml/databases.xml");
$list_scripts->addChild("database", "$user_name/$db_name.xml");
$list_scripts->asXML("xml/databases.xml");

//echo "</pre>";
session_destroy();

header('Location: base.php');
?>
