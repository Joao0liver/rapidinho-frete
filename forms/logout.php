<?php

// Logout da sessão
session_start();
session_unset();
session_destroy();

// Reset dos dados da sessão
$_SESSION['id_user'] = null;
$_SESSION['email_user'] = null;

// Retorna para a tela de login
header('Location: index.php');


?>