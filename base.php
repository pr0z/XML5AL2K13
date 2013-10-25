<?php
$mail = $_POST['mail'];
$password = $_POST['password'];

$xml = simplexml_load_file('xml/users.xml');
$user = $xml->xpath("//user[mail = '" . $mail . "']");

if ($user != NULL) {
    $passw = $user[0]->password;
    if (md5($password) == $passw) {
        include 'head.php';
        include 'tools/functions.php';
        ?>
        <div id='bloc'>
            <div id='cssmenu'>
                <ul>
                    <li class='active'><a href='base.php'><span>Dernières bases</span></a></li>
                    <li class=''><a href='util.php'><span>Liste des utilisateurs</span></a></li>            
                    <li class=''><a href='about.php'><span>Contact</span></a></li>
                </ul>
            </div>
            <div id="contenu">
                <?php
                $databases = ReadDbFile();
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