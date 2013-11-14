<?php
include 'head.php';
include 'tools/functions.php';
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
    <div id="contenu">
        <?php
        if ($_GET['type'] == "byuser") {
            $results = GetDbByUsername($_GET['username']);
            if ($results != NULL) {
                if ($results != 'nouser') {
                    if ($results != 'norecord') {
                        DisplayResults("Liste des bases créées par " . $_GET['username'] . "", $results);
                    } else {
                        ?>
                        <p class="error">Aucun enregistrement ne correspond à vos critères de recherche.</p>
                        <?php
                    }
                } else {
                    ?>
                    <p class="error">L'utilisateur que vous recherchez n'existe pas.</p>
                    <?php
                }
            }
        }

        if ($_GET['type'] == "bydate") {
            $results = GetDbByDate($_GET['criteria'], $_GET['date']);
            if ($results != NULL) {
                DisplayResults(GetFormattedTitle($_GET['criteria'], $_GET['date']), $results);
            } else {
                ?>
                <p class="error">Aucun enregistrement ne correspond à vos critères de recherche.</p>
                <?php
            }
        }

        if ($_GET['type'] == 'xpathquery') {
            $results = GetXpathQuery($_GET['database'], $_GET['query']);
            if ($results != 'noresult') {
                if ($results != 'nodb') {
                    
                } else {
                    ?>
                    <p class="error">La base que vous recherchez n'existe pas.</p>
                    <?php
                }
            } else {
                ?>
                <p class="error">Aucun enregistrement ne correspond à vos critères de recherche.</p>
                <?php
            }
        }
        ?>
    </div>
</div>
<?php include 'foot.php'; ?>