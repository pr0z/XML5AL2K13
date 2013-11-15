<?php
session_start();

$dbname = $_POST['dbname'];
$creator = $_POST['creator'];

if(isset($_SESSION['user'])) {
	
	unlink ("xml/".$creator."/".$dbname.".xml");
	
	$dbs = simplexml_load_file('xml/databases.xml');
	
	foreach ($dbs as $db) {
        if ($db == ($creator."/".$dbname.".xml")) {
            $dom = dom_import_simplexml($db);
            $dom->parentNode->removeChild($dom);
		}
	}
	
	$dbs->asXML('xml/databases.xml');
	
	header('Location:base.php');
	
} else {
    header('Location:index.php?err=nouser');
}
?>