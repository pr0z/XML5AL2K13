<?php
include 'tools/functions.php';

if (isset($_POST['type'])) {
    if ($_POST['type'] == 'updateRights') {
        include 'head.php';
        ?>  
        <div id='bloc'>
            <div id='cssmenu'>
                <ul>
                    <li class=''><a href='base.php'><span>Bases existantes</span></a></li>
                    <li class=''><a href='query.php'><span>Requête</span></a></li>
                    <li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li>
                    <li class='active'><a href='admin.php'><span>Administration</span></a></li>
                    <li class='last'><a href='logout.php'><span>Logout</span></a></li>
                </ul>
            </div>
            <div id="contenu">
                <h3 class="mainTitle">Modifier les droits de <?php echo $_POST['firstName'] . " " . $_POST['name']; ?></h3>
                <div class="dbContainer">
                    <form method="post" action="updateUser.php" class="custom-form">
                        <input type="radio" name="right" value="read"><i>read</i></input><br />
                        <input type="radio" name="right" value="write"><i>write</i></input>
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