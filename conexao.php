<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'rapidinho_teste';

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn){
    die();
}

?>