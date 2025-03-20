<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null){
    
    header('Location: ../index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $msg = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $ende_col = $_POST['ende_col'];
        $bairro_col = $_POST['bairro_col'];
        $cep_col = $_POST['cep_col'];

        $ende_dest = $_POST['ende_dest'];
        $bairro_dest = strtolower($_POST['bairro_dest']);
        $cep_dest = $_POST['cep_dest'];
        $nome_dest = $_POST['nome_dest'];

        $peso_pac = $_POST['peso_pac'];
        $larg_pac = $_POST['larg_pac'];
        $comp_pac = $_POST['comp_pac'];

        if ($peso_pac < 1) { /* Início da Comparação do Peso do Pacote com o Valor da Tabela */

            $sql = "SELECT menor_1kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);

        }else if ($peso_pac >= 1 || $peso_pac < 3){

            $sql = "SELECT 1kg_3kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql); 

        }else if ($peso_pac >= 3 || $peso_pac < 8){

            $sql = "SELECT 3kg_8kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);
            print_r($preco_peso);

        }else if ($peso_pac >= 8 || $peso_pac <= 12){

            $sql = "SELECT 8kg_12kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);

        } /* Fim da Comparação do Peso do Pacote com o Valor da Tabela */

        $sql = "SELECT valor FROM tbl_distancia WHERE bairro = '$bairro_dest'";
        $rodar_sql = mysqli_query($conn, $sql);

        if (mysqli_num_rows($rodar_sql) > 0) {

            $preco_bairro = mysqli_fetch_assoc($rodar_sql);

        }else{

            $msg = "Bairro não encontrado! Por favor, revise o nome e tente novamente.";

        }

        $preco_total = $preco_bairro;

    }

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>This is blank page</h3>
                        <?php

                            echo $msg;
                            print_r($preco_total);

                        ?>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>