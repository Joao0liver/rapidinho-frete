<?php

    include_once("../conexao.php");

    $id_cliente = $_GET['id_cliente'];

    $sql = "UPDATE tbl_usuario SET status_user = 0 WHERE id_user = $id_cliente";
    $rodar_sql = mysqli_query($conn, $sql);

    if ($rodar_sql){
        header('Location: listar_cliente_adm.php');
    }else{
        echo "Erro ao deletar cliente!";
    }

?>