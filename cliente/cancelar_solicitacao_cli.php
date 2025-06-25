<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 10){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");

    $id_ent = $_GET['id_ent'];

    $sql = "UPDATE tbl_entrega SET status_ent = 3 WHERE id_ent = $id_ent";
    $rodar_sql = mysqli_query($conn, $sql);

    if ($rodar_sql){
        header('Location: listar_solicitacao_cli.php');
    }else{
        echo "Erro ao cancelar pedido!";
    }

}

?>