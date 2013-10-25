<?php
include 'head.php';
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
        <h3 class="mainTitle">Créer une nouvelle base - Etape 1/3</h3>
        <form method="get" action="steptwo.php">
            <label for="dbname" class="dblabels"> Nom de la base : </label><input type="text" name="dbname" /><br />
            <label for="nbtable" class="dblabels">Nombre de tables : </label><input type="text" name="nbtable" />
            <input class="btnquery" type="submit" value="Suivant" name="go"/>
        </form>
    </div>
</div>
<?php include 'foot.php'; ?>