<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'head.php';
    include 'tools/functions.php';
    ?>
    <script>
        $(function() {
            $("#dateSelector").datepicker();
        });
    </script>
    <div id='bloc'>
        <div id='cssmenu'>
            <ul>
                <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                <li class='active'><a href='query.php'><span>Requête</span></a></li>
                <?php if (isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li><?php } ?>
                <?php if (isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='admin.php'><span>Administration</span></a></li><?php } ?>
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
                <input type="radio" checked="checked" name="criteria" value="before" >Créee avant le</input>
                <input id="dateSelector" type="text"  name="date" /><br />
                <input id="leftRadioDate" type="radio" name="criteria" value="after" >Créee après le</input><br />
                <input id="leftRadioDate" type="radio" name="criteria" value="on" >Créee le</input>
                <input class="btnquery" type="submit" value="Rechercher" name="rechercher"/>
                <input type="hidden" name="type" value="bydate"/>
            </form>
            <form method="get" action="result.php"  class="custom-form">
                <label for="username" class="dblabels">Recherche xpath  : </label>
                <select name="database">
                    <option value="none">Base de données</option>
                    <?php
                    foreach (GetDbNames() as $db) {
                        ?>
                        <option value="<?php echo $db; ?>"><?php echo $db; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <input type="text" name="query" width="210" /><br />
                <input class="btnquery" type="submit" value="Rechercher" name="rechercher"/>
                <input type="hidden" name="type" value="xpathquery"/>
            </form>
            <br />
            <br />
        </div>
    </div>
    <?php
    include 'foot.php';
} else {
    Header('Location: index.php');
}
?>