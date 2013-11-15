<?php
session_start();

if (isset($_POST['mail'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $xml = simplexml_load_file('xml/users.xml');
    $user = $_POST['mail'] != null ? $xml->xpath("//user[mail = '" . $mail . "']") : $_SESSION['user'];

    if ($user != NULL) {
        $passw = $user[0]->password;

        if (md5($password) == $passw || isset($_SESSION['user'])) {

            if (!isset($_SESSION['user'])) {
                $_SESSION['user'] = (string) $user[0]->firstName;
                $_SESSION['right'] = (string) $user[0]->rights;
            }
        } else {
            header('Location:index.php?err=passw');
        }
    } else {

        header('Location:index.php?err=nouser');
    }
}


if (isset($_SESSION['user'])) {
    include 'head.php';
    include 'tools/functions.php';
    ?>
    <div id='bloc'>
        <div id='cssmenu'>
            <ul>
                <li class='active'><a href='base.php'><span>Bases existantes</span></a></li>
                <li class=''><a href='query.php'><span>Requête</span></a></li>
                <?php if (isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='createdb.php'><span>Nouvelle base</span></a></li><?php } ?>
                <?php if (isset($_SESSION['right']) && $_SESSION['right'] == "write") { ?><li class=''><a href='admin.php'><span>Administration</span></a></li><?php } ?>
                <li class='last'><a href='logout.php'><span>Logout</span></a></li>
            </ul>
        </div>
        <div id="contenu">

            <?php
            $databases = ReadDbFile();
            DisplayResults("Bases existantes", $databases);
            ?>
        </div>
    </div>
    <?php
    include 'foot.php';
} else {
    Header('Location: index.php');
}
?>