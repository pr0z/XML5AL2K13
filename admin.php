<?php
session_start();
if (isset($_SESSION['user'])) {
    include 'head.php';
    include 'tools/functions.php';
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
        <div id="contenu" style="padding-bottom:50px;">
            <h3 class="mainTitle">Administration</h3>
            <?php GetUsers(); ?>
        </div>
        <?php
        include 'foot.php';
    } else {
        Header('Location: index.php');
    }
    ?>
