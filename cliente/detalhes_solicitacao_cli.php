<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 10){
    
    header('Location: ../forms/index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $msg = "";

    // Obter Registros/Informações de Entrega

    $id_ent = $_GET['id_ent'];

    $sql = "SELECT * FROM tbl_entrega WHERE id_ent = $id_ent";
    $rodar_sql = mysqli_query($conn, $sql);

    $registros_entrega = mysqli_fetch_assoc($rodar_sql);

    if ($registros_entrega['status_ent'] == 0) {

        $msg = '<font color="red">Pendente</font>';

    }elseif ($registros_entrega['status_ent'] == 1) {

        $msg = '<font color="orange">Em Andamento</font>';

    }else {

        $msg = '<font color="green">Finalizado</font>';

    }

    // Verificar se um motoboy já está atribuido ao pedido

    if ($registros_entrega['id_mtboy'] == null){

        $nome_mtboy = '<font color="orange">Nenhum motoboy aceitou a solicitação ainda!</font>';

    }else {

        // Obter Informações do Motoboy

        $id_mtboy = $registros_entrega['id_mtboy'];

        $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
        $rodar_sql = mysqli_query($conn, $sql);

        $registros_mtboy = mysqli_fetch_assoc($rodar_sql);

        $nome_mtboy = $registros_mtboy['nome_user'];
        $foto_mtboy = $registros_mtboy['foto_mtboy'];

    }


?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h5 class="mb-4">Detalhes do Pedido</h5>
                    <dl class="row mb-0">
                        <div class="testimonial-item text-center">
                            <img class="img-fluid rounded-circle mx-auto mb-4" src="../upload/img_mtboy/<?php echo $registros_mtboy['foto_mtboy'] ?>" style="width: 120px; height: 120px;">
                        </div>

                        <dt class="col-sm-4">Motoboy:</dt>
                        <dd class="col-sm-8"><?php echo $nome_mtboy ?></dd>

                        <dt class="col-sm-4">ID do Pedido:</dt>
                        <dd class="col-sm-8"><?php echo $registros_entrega['id_ent'] ?></dd>

                        <dt class="col-sm-4">Endereço de Retirada:</dt>
                        <dd class="col-sm-8"><?php echo $registros_entrega['ende_orig'] ?></dd>

                        <dt class="col-sm-4">Endereço de Entrega:</dt>
                        <dd class="col-sm-8"><?php echo $registros_entrega['ende_dest'] ?></dd>

                        <dt class="col-sm-4 text-truncate">Características do Pacote:</dt>
                        <dd class="col-sm-8"><?php echo $registros_entrega['peso_pac'].'kg - '.$registros_entrega['comp_pac'].'cm x '.$registros_entrega['larg_pac'].'cm'; ?></dd>

                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8">
                            <dl class="row">
                                <dd class="col-sm-8"><?php echo $msg; ?></dd>
                            </dl>
                        </dd>
                    </dl>
                    <?php

                        if ($registros_entrega['status_ent'] == 0){ // Status - Entrega Pendente

                            echo '<div class="pg-bar mb-3">
                                <div class="testimonial-item text-center"><img src="../layout/img/ped_pendente.png" height="200px" width="200px"><br><br></div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;"></div>
                                </div>
                            </div>';

                        }elseif ($registros_entrega['status_ent'] == 1){ // Status - Entrega em Andamento

                            echo '<div class="pg-bar mb-3">
                                <div class="testimonial-item text-center"><img src="../layout/img/ped_andamento.png" height="200px" width="200px"><br><br></div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
                                </div>
                            </div>';

                        }else { // Status - Entrega Finalizada

                            echo '<div class="pg-bar mb-0">
                                <div class="testimonial-item text-center"><img src="../layout/img/ped_finalizado.png" height="200px" width="200px"><br><br></div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                </div>
                            </div>';

                        }

                    ?>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>