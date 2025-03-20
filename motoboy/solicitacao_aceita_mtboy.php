<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 100){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_mtboy.php");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $id_ent = $_GET['id_ent'];

        $sql = "UPDATE tbl_entrega SET id_mtboy = 1, inicio_ent = NOW() WHERE id_ent = $id_ent";
        $rodar_sql = mysqli_query($conn, $sql);

    }

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>Solicitação Aceita com Sucesso!</h3>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>