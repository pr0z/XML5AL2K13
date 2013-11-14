<?php
session_start();
session_destroy();
session_unset();
Header('Location: index.php');
