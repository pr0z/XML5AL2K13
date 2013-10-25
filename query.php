<?php
include 'head.php';
?>
<div id='bloc'>
    <div id='cssmenu'>
        <ul>
            <li class=''><a href='base.php'><span>Dernières bases</span></a></li>
            <li class='active'><a href='query.php'><span>Requête</span></a></li>
            <li class='last'><a href='about.php'><span>Contact</span></a></li>
        </ul>
    </div>
    <div id="contenu" id="queriesContainer">
        <form method="get" action="result.php">
            <label for="username">Afficher les bases crées par : </label><input type="text" name="username" />
            <input class="btnquery" type="submit" value="Rechercher" name="rechercher"/>
            <input type="hidden" name="type" value="byuser"/>
        </form>
    </div>
</div>
<?php include 'foot.php'; ?>