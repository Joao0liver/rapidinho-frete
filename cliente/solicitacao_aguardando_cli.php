<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 10){
    
    header('Location: ../forms/index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $msg = '';
    $finalizado = false;

    $id_user = $_POST['id_user'];
    $preco_total = $_POST['valor_ent'];
    $ende_col = $_POST['ende_orig'];
    $ende_dest = $_POST['ende_dest'];
    $peso_pac = $_POST['peso_pac'];
    $larg_pac = $_POST['larg_pac'];
    $comp_pac = $_POST['comp_pac'];

    $ende_col = tratar_input_solicitacao($ende_col, $conn);
    $ende_dest = tratar_input_solicitacao($ende_dest, $conn);
    $peso_pac = tratar_input_solicitacao($peso_pac, $conn);
    $larg_pac = tratar_input_solicitacao($larg_pac, $conn);
    $comp_pac = tratar_input_solicitacao($comp_pac, $conn);

    if ($ende_col <> -1 && $ende_dest <> -1 && $peso_pac <> -1 && $larg_pac <> -1 && $comp_pac <> -1){

        // Inserir no Banco - tbl_entrega

        $sql = "INSERT INTO tbl_entrega (id_cliente, valor_ent, ende_orig, ende_dest, peso_pac, larg_pac, comp_pac) VALUES ($id_user, $preco_total, '$ende_col', '$ende_dest', $peso_pac, $larg_pac, $comp_pac)";
        $rodar_sql = mysqli_query($conn, $sql);
        $msg = '<h4><font color="green">Seu pedido foi criado!</font></h4>
        <h6>Aguarde um de nossos motoboys aceitar a solicitação! Você pode acompanhar o andamento em <a href="listar_solicitacao_cli.php">minhas solicitações</a>.</h6>';
        $finalizado = true;

    }else{
        $msg = '<font color="red">Falha ao finalizar a solicitação! Por favor, revise as informações e tente novamente!</font> <br>';
    }

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <?php

                            if ($finalizado == false) {

                                echo '<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>';

                            }else{
                                echo '<br><br>'.$msg;
                            }
                            
                        ?>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>