<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'head.php';
    ?>
    <div id='bloc'>
        <div id='cssmenu'>
            <ul>
                <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                <li class='active'><a href='query.php'><span>Requête</span></a></li>
                <li class='last'><a href='createdb.php'><span>Nouvelle base</span></a></li>
                <li class='last'><a href='logout.php'><span>Logout</span></a></li>
            </ul>
        </div>
        <div id="contenu" class="queriesContainer">
            <form method="get" action="result.php"  class="custom-form">
                <label for="username" class="dblabels">Bases crées par : </label><input type="text" name="username" />
                <input class="btnquery" type="submit" value="Rechercher" name="rechercher"/>
                <input type="hidden" name="type" value="byuser"/>
            </form>
            <br />
            <form method="get" action="result.php"  class="custom-form">
                <label for="username" class="dblabels">Recherche par date  : </label>
                <input type="radio" name="criteria" value="before" >Créee avant le</input>
                <input id="dateSelector" type="date" name="date" /><br />
                <input id="leftRadioDate" type="radio" name="criteria" value="after" >Créee après le</input><br />
                <input id="leftRadioDate" type="radio" name="criteria" value="on" >Créee le</input>
                <input class="btnquery" type="submit" value="Rechercher" name="rechercher"/>
                <input type="hidden" name="type" value="bydate"/>
            </form>
        </div>
    </div>
    <?php
    include 'foot.php';
} else {
    Header('Location: index.php');
}
?>