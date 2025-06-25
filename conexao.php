<?php

// Define o servidor e o banco de dados que será utilizado
$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'rapidinho_teste';

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn){
    die();
}



?>