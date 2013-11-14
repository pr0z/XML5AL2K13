<?php
include 'head.php';
?>
<form method='POST' action="validregistration.php" name="connect"  class="custom-form">
    <div id="containerRegister">
        <div id="connect">
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