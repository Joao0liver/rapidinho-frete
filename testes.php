<?php

$input = $_POST['campo'];



if (filter_var($input, FILTER_VALIDATE_INT)) {
    print("é e-mail");
} elseif (gettype($input) == "string") {
    print("é texto");
}

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