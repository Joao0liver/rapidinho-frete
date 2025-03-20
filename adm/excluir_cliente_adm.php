<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 777){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");

    $id_cliente = $_GET['id_cliente'];

    $sql = "UPDATE tbl_usuario SET status_user = 0 WHERE id_user = $id_cliente";
    $rodar_sql = mysqli_query($conn, $sql);

    if ($rodar_sql){
        header('Location: listar_cliente_adm.php');
    }else{
        echo "Erro ao deletar cliente!";
    }

}

?>