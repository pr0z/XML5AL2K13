<?php
include 'head.php';
?>
<div id='bloc'>
    <div id='cssmenu'>
        <ul>
            <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
            <li class='active'><a href='query.php'><span>Requête</span></a></li>
            <li class='last'><a href='createdb.php'><span>Nouvelle base</span></a></li>
        </ul>
    </div>
    <div id="contenu" class="queriesContainer">
        <form method="get" action="result.php">
            <label for="username" class="dblabels">Bases crées par : </label><input type="text" name="username" />
            <input class="btnquery" type="submit" value="Rechercher" name="rechercher"/>
            <input type="hidden" name="type" value="byuser"/>
        </form>
    </div>
</div>
<?php include 'foot.php'; ?>