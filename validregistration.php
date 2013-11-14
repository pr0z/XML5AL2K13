<?php
session_start();
$firstName = $_POST['firstName'];
$name = $_POST['name'];
$mail = $_POST['mail'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];

if (md5($password) == md5($confirm)) {
    include 'head.php';
    include 'tools/functions.php';
    RegisterUser($firstName, $name, $mail, $password, $confirm);
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
            <h3 class='mainTitle'>Merci de vous être inscrit !</p>
        </div>
    </div>
    <?php
    include 'foot.php';
}
?>