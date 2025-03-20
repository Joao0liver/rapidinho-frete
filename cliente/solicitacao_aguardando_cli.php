<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null){
    
    header('Location: ../index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $id_user = $_POST['id_user'];
    $preco_total = $_POST['valor_ent'];
    $ende_col = $_POST['ende_orig'];
    $ende_dest = $_POST['ende_dest'];
    $peso_pac = $_POST['peso_pac'];
    $larg_pac = $_POST['larg_pac'];
    $comp_pac = $_POST['comp_pac'];

    // Inserir no Banco - tbl_entrega

    $sql = "INSERT INTO tbl_entrega (id_user, valor_ent, ende_orig, ende_dest, peso_pac, larg_pac, comp_pac) VALUES ($id_user, $preco_total, '$ende_col', '$ende_dest', $peso_pac, $larg_pac, $comp_pac)";
    $rodar_sql = mysqli_query($conn, $sql);


?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>This is blank page</h3>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>