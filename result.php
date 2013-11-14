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
                        ?>
                        <h3 class="mainTitle">Liste des bases ajoutées par <?php echo $_GET['username']; ?></h3>
                        <?php
                        foreach ($results as $db) {
                            ?>
                            <div class="dbContainer">
                                <h4 class="dbTitle" style="width:380px;"><?php echo $db->Name; ?></h4>
                                <i class="dbInfos">Ajoutée par <?php echo $db->CreatorName; ?>, le <?php echo $db->CreationDate; ?></i><br />
                                <div class="container-bt">
                                    <form method="post" action="steptwo.php" class="formBase" style="margin-left:-245px;">
                                        <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                                        <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                                        <input type="submit" value="Consulter / Editer" />
                                    </form>
                                    <form method="post" action="" class="formBase" style="margin-left:-90px;">
                                        <input type="hidden" name="creator" value="<?php echo $db->CreatorName ?>" />
                                        <input type="hidden" name="dbname" value="<?php echo $db->Name ?>" />
                                        <input type="submit" value="Supprimer" onClick="">
                                    </form>
                                </div>
                            </div>
                            <br />
                            <?php
                        }
                        ?>
                        <?php
                    } else {
                        ?>
                        <p class="error">Aucun enregitrement ne correspond à vos critères de recherche.</p>
                        <?php
                    }
                } else {
                    ?>
                    <p class="error">L'utilisateur que vous recherchez n'existe pas.</p>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>
<?php include 'foot.php'; ?>