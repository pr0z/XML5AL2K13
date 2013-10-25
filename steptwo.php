<?php
session_start();
include 'head.php';
include 'tools/functions.php';
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
        <h3 class="mainTitle">Propriétés des tables - Etape 2/3</h3>
        <form method="get" action="stepthree.php">
            <?php
            $name = $_GET['dbname'];
            $_SESSION['dbname'] = $name;
            $nbtable = $_GET['nbtable'];

            for ($i = 0; $i < $nbtable; $i++) {
                $id = $i + 1;
                ?>
                [Table <?php echo $id ?>]<br />
                <label for="dbname" class="dblabels"> Nom de la table : </label><input type="text" name="tbname<?php echo $id; ?>" /><br />
                <label for="nbtable" class="dblabels">Nombre de colonnes : </label><input type="text" name="nbcolumns<?php echo $id; ?>" /><br />
                <hr />
                <?php
            }
            ?>
            <input type="hidden" name="nbtables" value="<?php echo $nbtable; ?>" />
            <input class="btnquery" type="submit" value="Suivant" name="go"/><br />
        </form>
    </div>
</div>
<?php include 'foot.php'; ?>