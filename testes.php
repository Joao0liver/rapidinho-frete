<?php

include_once('conexao.php');

$input = $_POST['campo'];

$input = filter_var($input, FILTER_SANITIZE_STRING);
$input = mysqli_real_escape_string($conn, $input);


echo $input;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="testes.php" method="post">
        <input type="e-mail" name="campo">
        <input type="submit">
    </form>
</body>
</html>