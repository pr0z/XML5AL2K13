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
                <h3 class="mainTitle">Bases existantes</h3>
                <?php
                $databases = ReadDbFile();
                foreach ($databases as $db) {
                    ?>
                    <div class="dbContainer">
                        <h4 class="dbTitle"><?php echo $db->Name; ?></h4>
                        <i class="dbInfos">Créee par <?php echo $db->CreatorName; ?>, le <?php echo $db->CreationDate; ?></i><br />
                        <ul class="tbContainer">
                            <?php
                            foreach ($db->Tables as $table) {
                                ?>
                                <li class="tbName">- <?php echo $table->Name; ?></li>
                                <?php
                                foreach ($table->Columns as $column) {
                                    ?>
                                    <li class="columns">&nbsp;&nbsp;<?php echo $column->Name; ?> (<?php echo $column->Type; ?>) <?php
                                        if ($column->Name == $table->PrimaryKey) {
                                            echo "[PRIMARY_KEY]";
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
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