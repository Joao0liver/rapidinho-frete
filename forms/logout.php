<?php

session_start();
session_unset();
session_destroy();

$_SESSION['id_user'] = null;
$_SESSION['email_user'] = null;

header('Location: index.php');


?>