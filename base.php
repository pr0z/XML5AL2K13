<?php
if(!isset($_POST['mail'])){
    $_POST['mail'] = "roman.leichnig@gmail.com";
    $_POST['password'] = "toto";
}

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
		            <li class='active'><a href='base.php'><span>Bases existantes</span></a></li>
		            <li class=''><a href='query.php'><span>Requête</span></a></li>
		            <li class='last'><a href='createdb.php'><span>Nouvelle base</span></a></li>
		        </ul>
		    </div>
            <div id="contenu">
                <h3 class="mainTitle">Bases existantes</h3>
                <?php
                $databases = ReadDbFile();
                foreach ($databases as $db) {
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