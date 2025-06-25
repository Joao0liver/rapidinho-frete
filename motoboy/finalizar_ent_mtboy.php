<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 100){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");

    // Captura o ID da entrega a partir do script "confirmaDel"
    $id_ent = $_GET['id_ent'];

    // Atualiza o status da entrega de 1 para 2 (Em Andamento para Finalizado)
    $sql = "UPDATE tbl_entrega SET fim_ent = NOW(), status_ent = 2 WHERE id_ent = $id_ent";
    $rodar_sql = mysqli_query($conn, $sql);

    if ($rodar_sql){
        header('Location: minhas_entregas_mtboy.php'); // Redireciona para as entregas pendentes após a execução do UPDATE
    }else{
        echo "Erro ao finalizar entrega!";
    }

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3><font color="green">Entrega finalizada!</font></h3>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>