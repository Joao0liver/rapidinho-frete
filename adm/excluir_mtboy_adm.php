<?php

include_once("../conexao.php");

$id_mtboy = $_GET['id_mtboy'];

$sql = "UPDATE tbl_motoboy SET status_mtboy = 0 WHERE id_mtboy = $id_mtboy";
$rodar_sql = mysqli_query($conn, $sql);

if ($rodar_sql){
    header('Location: listar_mtboy_adm.php');
}else{
    echo "Erro ao deletar motoboy!";
}

?>