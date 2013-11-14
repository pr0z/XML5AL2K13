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
<form method='POST' action="base.php" name="connect"  class="custom-form">
    <div id="container">
        <div id="connect">
        <?php
            if ($err != "") {
        ?>
            <p class="error"><?php echo $err; ?></p>
        <?php         
            }
        ?>
            <table id="tabConnect">
                <caption><h3>Identification</h3></caption>
               
                <tr><td>Identifiant</td><td><input id="mailIndex" type="name" name="mail" value=""/></td></tr>
                <tr><td>Pass</td><td><input type="password" name="password" value="" /></td></tr>
            </table>
            <input type="submit" value="ok" name="valide" onclick="return verifierMail();"/>
        </div>
    </div>
    <?php include 'foot.php'; ?>