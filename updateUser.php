<?php
session_start();
include 'tools/functions.php';

if (isset($_POST['type'])) {
	if(isset($_SESSION['right']) && $_SESSION['right'] == "read") Header('Location: base.php');
    if ($_POST['type'] == 'updateRights') {
        include 'head.php';
        ?>  
        <div id='bloc'>
            <div id='cssmenu'>
                <ul>
                    <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                    <li class=''><a href='query.php'><span>Requête</span></a></li>
                    <?php if(isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li><?php } ?>
                    <?php if(isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class='active'><a href='admin.php'><span>Administration</span></a></li><?php } ?>
                    <li class='last'><a href='logout.php'><span>Logout</span></a></li>
                </ul>
            </div>
            <div id="contenu">
                <?php
                    $rights = GetUserRights($_POST['firstName'],  $_POST['name']);
                 ?>
                <h3 class="mainTitle">Modifier les droits de <?php echo $_POST['firstName'] . " " . $_POST['name']; ?></h3>
                <div class="dbContainer">
                    <form method="post" action="updateUser.php" class="custom-form">
                        <input type="radio" <?php if($rights == "read") {?> checked="checked"<?php }; ?> name="right" value="read"><i>read</i></input><br />
                        <input type="radio" <?php if($rights == "write") {?> checked="checked"<?php }; ?> name="right" value="write"><i>write</i></input>
                        <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>" />
                        <input type="hidden" name="firstName" value="<?php echo $_POST['firstName']; ?>" />
                        <input type="hidden" name="type" value="changeRights" />
                        <input type="submit" value="Enregistrer" style="margin-top: -10px;"/>
                    </form>
                </div>
                <br />
            </div>
        </div>
        <?php
        include 'foot.php';
    }
    if ($_POST['type'] == 'deleteUser') {
        DeleteUser($_POST['firstName'], $_POST['name']);
    }
    if ($_POST['type'] == 'changeRights') {
        ChangeUserRights($_POST['firstName'], $_POST['name'], $_POST['right']);
    }
}