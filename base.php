<?php
if (isset($_POST['register'])){
    Header('Location:register.php');
}
session_start();
$mail = $_POST['mail'];
$password = $_POST['password'];

$xml = simplexml_load_file('xml/users.xml');
$user = $_POST['mail'] != null ? $xml->xpath("//user[mail = '" . $mail . "']") : $_SESSION['user'];

if ($user != NULL) {
    $passw = $user[0]->password;
    if (md5($password) == $passw || isset($_SESSION['user'])) {
        include 'head.php';
        include 'tools/functions.php';
        if (!isset($_SESSION['user']))
            $_SESSION['user'] = (string) $user[0]->firstName;
        ?>
        <div id='bloc'>
            <div id='cssmenu'>
                <ul>
                    <li class='active'><a href='base.php'><span>Bases existantes</span></a></li>
                    <li class=''><a href='query.php'><span>Requête</span></a></li>
                    <li class='last'><a href='createdb.php'><span>Nouvelle base</span></a></li>
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
        header('Location:index.php?err=passw');
    }
} else {
    header('Location:index.php?err=nouser');
}
?>