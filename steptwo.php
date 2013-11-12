<?php
session_start();
include 'head.php';
include 'tools/functions.php';

if(ISSET($_POST['creator'])) {
	$user_name = $_POST['creator'];
	$db_name = $_POST['dbname'];
}
else {
	$user_name = "user-name";
	$db_name = "";
	$date = date('d/m/o');
	if(ISSET($_POST['dbname'])) $db_name = $_POST['dbname'];
	
	if(trim($db_name) == "")  header('Location: createdb.php?1');
	if (file_exists("xml/$user_name")) {
		if (file_exists("xml/$user_name/$db_name.xml")) header('Location: createdb.php?2');
	}
	
	if (!file_exists("xml/$user_name") && trim($db_name) != "") mkdir("xml/$user_name", 0777, true);
	
	if (!file_exists("xml/$user_name/$db_name.xml") && trim($db_name) != "") {
		$racineXML = new SimpleXMLElement("<database></database>");
		$metaXML = $racineXML->addChild("metaInformations");
		$metaXML->addChild("dbName", $_POST['dbname']);
		$metaXML->addChild("creatorName", $user_name);
		$metaXML->addChild("creationDate",$date);
		$racineXML->addChild("tables");
		$racineXML->asXml('xml/'.$user_name.'/'.$db_name.'.xml');
		
		$list_scripts = simplexml_load_file("xml/databases.xml");
		$list_scripts->addChild("database", "$user_name/$db_name.xml");
		$list_scripts->asXML("xml/databases.xml");
	}
}

$racineXML = simplexml_load_file('xml/'.$user_name.'/'.$db_name.'.xml');
$infos = $racineXML->metaInformations;
$creationDate = (string) $infos->creationDate;

if(ISSET($_POST['nbcols']) && ISSET($_POST['tbname'])) {
	$XMLtables = $racineXML->xpath("//table");
	$isNewTable = true;
	foreach ($XMLtables as $XMLtable) {
		if($XMLtable->name == $_POST['tbname']) {
			$XMLcolumns = $XMLtable->xpath("columns/column");
			$isNewTable = false;
			foreach ($XMLcolumns as $XMLcolumn) {
				$dom=dom_import_simplexml($XMLcolumn);
				$dom->parentNode->removeChild($dom);
			}
			for($i=0; $i < $_POST['nbcols']; $i++) {
				if(ISSET($_POST['colname'.$i]) && ISSET($_POST['typecol'.$i]) && trim($_POST['colname'.$i]) != "") {
					$XMLcolumn = $XMLtable->columns->addChild("column");
					$XMLcolumn->addChild("name", $_POST['colname'.$i]);
					$XMLcolumn->addChild("type", $_POST['typecol'.$i]);
				}
			}
		}
	}
	if($isNewTable) {
		$XMLtable = $racineXML->tables->addChild("table");
		$XMLtable->addChild("name", $_POST['tbname']);
		$XMLcolumns = $XMLtable->addChild("columns");
		for($i=0; $i < $_POST['nbcols']; $i++) {
			if(ISSET($_POST['colname'.$i]) && ISSET($_POST['typecol'.$i]) && trim($_POST['colname'.$i]) != "") {
				$XMLcolumn = $XMLcolumns->addChild("column");
				$XMLcolumn->addChild("name", $_POST['colname'.$i]);
				$XMLcolumn->addChild("type", $_POST['typecol'.$i]);
			}
		}
	}
	$racineXML->asXml('xml/'.$user_name.'/'.$db_name.'.xml');
}

?>
<div id='bloc'>
    <div id='cssmenu'>
        <ul>
            <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
            <li class=''><a href='query.php'><span>Requête</span></a></li>
            <li class='active'><a href='createdb.php'><span>Nouvelle base</span></a></li>
        </ul>
    </div>
    <div id="contenu">
    	<h3 class="mainTitle">Informations sur la base de données</h3>
    	Nom de la base de données : <?php echo $db_name; ?><br />
    	Créateur : <?php echo $user_name; ?><br />
    	Date de création de la base de données : <?php echo $creationDate; ?><br />
    	<br />
    	<br />
    	<br />
        <h3 class="mainTitle">Liste des tables</h3>
        <?php if($racineXML->tables->table->count() == 0) echo "Aucune table ajoutée pour le moment"; ?>
        <?php foreach ($racineXML->tables->table as $table) { ?>
        <h4 class="dbTitle" style="width:400px;"><?php echo $table->name; ?></h4>
    	<div class="container-bt">
          	<form method="post" action="" class="formBase" style="margin-left:-245px;">
          		<input type="hidden" name="creator" value="<?php echo $user_name ?>" />
          		<input type="hidden" name="dbname" value="<?php echo $db_name ?>" />
          		<input type="submit" value="Consulter / Editer" />
          	</form>
          	<form method="post" action="" class="formBase" style="margin-left:-90px;">
          		<input type="hidden" name="creator" value="<?php echo $user_name ?>" />
          		<input type="hidden" name="dbname" value="<?php echo $db_name ?>" />
          		<input type="submit" value="Supprimer">
      		</form>
      	</div>
    	<?php } ?>
    	<br />
    	<br />
    	<br />
    	<h3 class="mainTitle">Ajouter un nouvelle table</h3>
        <form method="post" action="stepthree.php"  class="custom-form">
            <label for="dbname" class="dblabels"> Nom de la table : </label><input type="text" name="tbname" /><br />
            <label for="nbtable" class="dblabels">Nombre de colonnes : </label><input type="text" name="nbcols" /><br />
            <input type="hidden" name="creator" value="<?php echo $user_name ?>" />
          	<input type="hidden" name="dbname" value="<?php echo $db_name ?>" />
            <input class="btnquery" type="submit" value="Suivant"/><br />
        </form>
    </div>
</div>
<?php include 'foot.php'; ?>
