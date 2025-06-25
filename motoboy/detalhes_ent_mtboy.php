<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 100){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_mtboy.php");

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

    }

?>

<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                <script>

                        function confirmaDel(event, id) {

                            event.preventDefault();

                            const confirmacao = confirm("Deseja finalizar?");

                            if (confirmacao){
                                
                                window.location.href = `finalizar_ent_mtboy.php?id_ent=${id}`;
                                alert("Finalizado com sucesso!");

                            }else{

                                alert("Ação cancelada!");

                            }

                        }

                    </script>
                    <h5 class="mb-4">Detalhes do Pedido</h5>
                    <dl class="row mb-0">
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
                        <dt class="col-sm-4">Valor total:</dt>
                        <dd class="col-sm-8">R$<?php echo $registros_entrega['valor_ent'] ?></dd>
                        <dt class="col-sm-4"><h5>Valor a receber:</h5></dt>
                        <dd class="col-sm-8"><h5><font color="green">R$<?php echo number_format((70/100) * $registros_entrega['valor_ent'], 2) ?></font></h5></dd> <!-- number_format = limita as casas decimais -->
                    </dl>
                    <?php

                        if ($registros_entrega['status_ent'] == 1){ // Se o status da entrega for "em andamento", imprime o botão para finalizar a entrega

                            echo '<button class="btn btn-primary w-100 m-2" type="button" onclick="confirmaDel(event, '.$registros_entrega['id_ent'].')">Finalizar Entrega</button>';

                        }

                    ?>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>