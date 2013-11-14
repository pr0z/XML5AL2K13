<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'head.php';
    ?>
    <div id='bloc'>
        <div id='cssmenu'>
            <ul>
                <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                <li class=''><a href='query.php'><span>Requête</span></a></li>
                <li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li>
                <li class='active'><a href='admin.php'><span>Administration</span></a></li>
                <li class='last'><a href='logout.php'><span>Logout</span></a></li>
            </ul>
        </div>
        <div id="contenu" style="padding-bottom:50px;">
            <h3 class="mainTitle">Créer une nouvelle base de données</h3>
            <form method="post" action="editTable.php" class="custom-form">
                <label for="dbname" class="dblabels"> Nom de la base : </label><input type="text" name="dbname" /><br />
                <input class="btnquery" type="submit" value="Suivant" name="go"/>
                <?php if (ISSET($_GET['1'])) echo '<span style="color:red;font-size:10px;position:absolute;margin-left:151px;">Veuillez saisir un nom de base non vide</span>'; ?>
                <?php if (ISSET($_GET['2'])) echo '<span style="color:red;font-size:10px;position:absolute;margin-left:151px;">Une base de données portant ce nom existe déjà veuillez saisir un autre nom</span>'; ?>
            </form>
        </div>
    </div>
    <?php
    include 'foot.php';
} else {
    Header('Location: index.php');
}
?>
