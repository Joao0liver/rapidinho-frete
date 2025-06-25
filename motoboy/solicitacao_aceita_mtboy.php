<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 100){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_mtboy.php");

    $id_mtboy = $_SESSION['id_user'];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $id_ent = $_GET['id_ent'];

        // Faz uma atualização do status do registro de 0 para 1 (Pendente para Em Andamento)
        $sql = "UPDATE tbl_entrega SET id_mtboy = $id_mtboy, inicio_ent = NOW(), status_ent = 1 WHERE id_ent = $id_ent";
        $rodar_sql = mysqli_query($conn, $sql);

    }

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3><font color="green">Solicitação Aceita com Sucesso!</font></h3>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>