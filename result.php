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
                ?>
                <h3 class="mainTitle">Liste des bases ajoutées par <?php echo $_GET['username']; ?></h3>
                <?php
                foreach ($results as $db) {
                    ?>
                    <div class="dbContainer">
                        <h4 class="dbTitle"><?php echo $db->Name; ?></h4>
                        <i class="dbInfos">Ajoutée par <?php echo $db->CreatorName; ?>, le <?php echo $db->CreationDate; ?></i><br />
                        <ul class="tbContainer">
                            <?php
                            foreach ($db->Tables as $table) {
                                ?>
                                <li class="tbName">- <?php echo $table->Name; ?></li>
                                <?php
                                foreach ($table->Columns as $column) {
                                    ?>
                                    <li class="columns">&nbsp;&nbsp;<?php echo $column->Name; ?> (<?php echo $column->Type; ?>) <?php
                                        if ($column->Name == $table->PrimaryKey) {
                                            echo "[PRIMARY_KEY]";
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <br />
                    <?php
                }
                ?>
                <?php
            }
        }
        ?>
    </div>
</div>
<?php include 'foot.php'; ?>