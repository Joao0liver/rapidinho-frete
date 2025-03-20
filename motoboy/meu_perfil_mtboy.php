<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 100){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_mtboy.php");

    $id_user = $_SESSION['id_user'];

    $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_user";
    $rodar_sql = mysqli_query($conn, $sql);

    $dados_mtboy = mysqli_fetch_assoc($rodar_sql);

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Meu Perfil</h6>
                    <div class="testimonial-item text-center">
                        <img class="img-fluid rounded-circle mx-auto mb-4" src="../upload/img_mtboy/<?php echo $dados_mtboy['foto_mtboy'] ?>" style="width: 200px; height: 200px;">
                        <h4 class="mb-1"><?php echo $dados_mtboy['nome_user'] ?></h4>
                    </div>
                    <br>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent"><b>Identificação:</b> <?php echo $dados_mtboy['id_user'] ?></li>
                        <li class="list-group-item bg-transparent"><b>E-mail:</b> <?php echo $dados_mtboy['email_user'] ?></li>
                        <li class="list-group-item bg-transparent"><b>Telefone:</b> <?php echo $dados_mtboy['tel_mtboy'] ?></li>
                        <li class="list-group-item bg-transparent"><b>Placa da Moto:</b> <?php echo $dados_mtboy['placa_mtboy'] ?></li>
                        <li class="list-group-item bg-transparent"><b>Status:</b> <?php echo status($dados_mtboy['status_user']); ?></li>
                    </ul>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>