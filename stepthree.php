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
        <h3 class="mainTitle">Propriétés des colonnes - Etape 3/3</h3>
        <form method="get" action="finalstep.php">
            <?php
            $nbtables = $_GET['nbtables'];
            $tables = array();

            for ($i = 0; $i < $nbtables; $i++) {
                $id = $i + 1;
                $tbinfos = array();
                $name = $_GET['tbname' . $id];
                $nbcols = $_GET['nbcolumns' . $id];
                array_push($tbinfos, $name);
                array_push($tbinfos, $nbcols);
                array_push($tables, $tbinfos);
                echo '[' . $name . ']<br />';
                for ($j = 0; $j < $nbcols; $j++) {
                    $idcol = $j + 1;
                    ?>
                    <label for = "dbname" class = "dblabels"> Nom de la conne : </label><input type = "text" name="colname<?php echo $idcol; ?>-<?php echo $id;?>" /><br />
                    <label for = "nbtable" class = "dblabels"> Type : </label><input type = "text" name = "typecol<?php echo $idcol; ?>-<?php echo $id;?>" /><br />
                    <i class="separator">----------------------------</i><br/>
                    <?php
                }
                echo "<hr /><br />";
            }
            $_SESSION['tables'] = $tables;
            ?>
            <input type="hidden" name="nbtables" value="<?php echo $nbtables; ?>" />
            <input class="btnquery" type="submit" value="Suivant" name="go"/><br />
        </form>
    </div>
</div>
<?php include 'foot.php'; ?>