<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 10){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $id_user = $_SESSION['id_user'];

    $sql = "SELECT nome_user FROM tbl_usuario WHERE id_user = $id_user";
    $rodar_sql = mysqli_query($conn, $sql);
    $nome_user = mysqli_fetch_assoc($rodar_sql);

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>Olá, <?php echo $nome_user['nome_user'] ?>...</h3>
                        <h5>Seja bem-vindo ao Rapidinho Frete!</h5>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}   

?>