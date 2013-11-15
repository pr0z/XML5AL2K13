<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'head.php';
    include 'tools/functions.php';

    if (ISSET($_POST['creator'])) {
        $user_name = $_POST['creator'];
        $db_name = $_POST['dbname'];
    }

    $racineXML = simplexml_load_file('xml/' . $user_name . '/' . $db_name . '.xml');
    $infos = $racineXML->metaInformations;
    $creationDate = (string) $infos->creationDate;
	
    ?>
    <div id='bloc'>
        <div id='cssmenu'>
            <ul>
                <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                <li class=''><a href='query.php'><span>Requête</span></a></li>
                <?php if(isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li><?php } ?>
                <?php if(isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='admin.php'><span>Administration</span></a></li><?php } ?>
                <li class='last'><a href='logout.php'><span>Logout</span></a></li>
            </ul>
        </div>
        <div id="contenu">
            <h3 class="mainTitle">Informations sur la base de données</h3>
            <table cellspacing="8" class="tabStep2">
                <tr>
                    <td><u>Nom de la base de données</u> </td>
                    <td><u>Date de création de la base</u> </td>
                    <td><u>Créateur</u> </td><td>
                </tr>
                <tr>
                    <td><b><?php echo $db_name; ?></b></td>
                    <td><b><?php echo $creationDate; ?></b></td>
                    <td><b><?php echo $user_name; ?></b></td>
                </tr>
            </table>
            <h3 class="mainTitle">Liste des tables</h3>
			<?php if ($racineXML->tables->table->count() == 0) echo "Aucune table ajoutée pour le moment"; ?>
            <?php foreach ($racineXML->tables->table as $table) { ?>
                <h4 class="dbTitle" style="width:400px;"><?php echo $table->name; ?></h4>
                <?php foreach ($table->columns->column as $column) { ?>
                	<h5 class="colTitle" style="width:400px;margin-left:50px;"><?php echo $column->name." (".$column->type.")"; ?></h5>
                <?php } ?>
    		<?php } ?>
            <br />
        </div>
    </div>
    <?php
    include 'foot.php';
} else {
    Header('Location: index.php');
}
?>
