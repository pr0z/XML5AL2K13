<?php
include 'head.php';

$err = "";
if (isset($_GET['err'])) {
    if ($_GET['err'] == 'nouser')
        $err = "L'utilisateur n'existe pas !";

    if ($_GET['err'] == 'passw')
        $err = "Le mot de passe est incorrect !";
}
?>
<form method='POST' action="validregistration.php" name="connect"  class="custom-form">
    <div id="containerRegister">
        <div id="connect">
        <?php
            if ($err != "") {
        ?>
            <p class="error"><?php echo $err; ?></p>
        <?php         
            }
        ?>
            <table id="tabConnect">
                <caption><h3>Inscription</h3></caption>
                
                <tr><td>Prénom</td><td><input type="name" name="firstName" value=""/></td></tr>
                <tr><td>Nom</td><td><input type="name" name="name" value=""/></td></tr>
                <tr><td>Mail</td><td><input type="name" name="mail" value=""/></td></tr>
                <tr><td>Pass</td><td><input type="password" name="password" value="" /></td></tr>
                <tr><td>Confirm pass</td><td><input type="password" name="confirm" value="" /></td></tr>
            </table>
            <input type="submit" value="Inscription" name="valide" onclick="return verifierMail();"/>
        </div>
    </div>
    <?php include 'foot.php'; ?>