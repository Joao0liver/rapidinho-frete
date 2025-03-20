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

    $id_user = $_SESSION['id_user'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $ende_col = $_POST['ende_col'];
        $bairro_col = $_POST['bairro_col'];
        //$cep_col = $_POST['cep_col'];

        $ende_dest = $_POST['ende_dest'];
        $bairro_dest = $_POST['bairro_dest'];
        //$cep_dest = $_POST['cep_dest'];
        $nome_dest = $_POST['nome_dest'];

        $peso_pac = $_POST['peso_pac'];
        $larg_pac = $_POST['larg_pac'];
        $comp_pac = $_POST['comp_pac'];

        // Calcúlo de Valor Total

        if ($peso_pac < 1) { /* Início da Comparação do Peso do Pacote com o Valor da Tabela */

            $sql = "SELECT menor_1kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);
            $preco_peso_int = (int)$preco_peso['menor_1kg']; // Transforma o array associativo que vem do SQL em inteiro

        }else if ($peso_pac >= 1 && $peso_pac < 3){

            $sql = "SELECT 1kg_3kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);
            $preco_peso_int = (int)$preco_peso['1kg_3kg']; // Transforma o array associativo que vem do SQL em inteiro

        }else if ($peso_pac >= 3 && $peso_pac < 8){

            $sql = "SELECT 3kg_8kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);
            $preco_peso_int = (int)$preco_peso['3kg_8kg']; // Transforma o array associativo que vem do SQL em inteiro

        }else if ($peso_pac >= 8 && $peso_pac <= 12){

            $sql = "SELECT 8kg_12kg FROM tbl_precos";
            $rodar_sql = mysqli_query($conn, $sql);
            $preco_peso = mysqli_fetch_assoc($rodar_sql);
            $preco_peso_int = (int)$preco_peso['8kg_12kg']; // Transforma o array associativo que vem do SQL em inteiro

        }else{

            $msg = "Peso não compatível!";

        } /* Fim da Comparação do Peso do Pacote com o Valor da Tabela */

        // Valor do frete pelo bairro - tbl_distancia

        $sql = "SELECT valor FROM tbl_distancia WHERE bairro = '$bairro_dest'";
        $rodar_sql = mysqli_query($conn, $sql);
        $preco_dist = mysqli_fetch_assoc($rodar_sql);

        $preco_dist_int = (int)$preco_dist['valor'];

        $preco_total = $preco_dist_int + $preco_peso_int; // Valor total da Solitação de Frete

        // Puxar nome do solicitante

        $sql = "SELECT nome_user FROM tbl_usuario WHERE id_user = $id_user";
        $rodar_sql = mysqli_query($conn, $sql);
        $nome_user = mysqli_fetch_assoc($rodar_sql);

        // Concatenar Endereços com os respectivos Bairros

        $ende_inicio = $ende_col.', '.$bairro_col;
        $ende_fim = $ende_dest.', '.$bairro_dest;

    }

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Resumo da Solicitação</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent"><b>Nome do solicitante:</b> <?php  echo $nome_user['nome_user']?></li>
                        <li class="list-group-item bg-transparent"><b>Endereço de coleta:</b> <?php  echo $ende_col?>, <?php  echo $bairro_col?></li>
                        <li class="list-group-item bg-transparent"><b>Nome do Destinatário:</b> <?php  echo $nome_dest?></li>
                        <li class="list-group-item bg-transparent"><b>Endereço de entrega:</b> <?php  echo $ende_dest?>, <?php  echo $bairro_dest?></li>
                        <div class="border rounded p-4 pb-0 mb-4">
                                <figure>
                                    <p class="h6">Informações do Pacote</p>
                                    <figcaption class="blockquote-form">
                                        <p>Peso: <?php echo $peso_pac.'kg'; ?><br>Largura: <?php echo $larg_pac.'cm'; ?><br>Comprimento: <?php echo $comp_pac.'cm'; ?><br><br>Valor do pacote: <?php echo 'R$'.$preco_peso_int; ?></p>
                                    </figcaption>
                                </figure>
                        </div>
                        <li class="list-group-item bg-transparent"><p class="h4">Valor: <font color="green">R$<?php  echo $preco_total?></font></p></li>
                    </ul>
                    <p><img src="../layout/img/bandeiras_cartao.png" width="35%" height="35%"><div id="emailHelp" class="form-text"><font color="red">*Pagamento no ato da coleta</font></div></p>
                    <form method="post" action="solicitacao_aguardando_cli.php">
                        <input type="hidden" name="id_user" value="<?php echo $id_user?>">
                        <input type="hidden" name="valor_ent" value="<?php echo $preco_total?>">
                        <input type="hidden" name="ende_orig" value="<?php echo $ende_inicio?>">
                        <input type="hidden" name="ende_dest" value="<?php echo $ende_fim?>">
                        <input type="hidden" name="peso_pac" value="<?php echo $peso_pac?>">
                        <input type="hidden" name="larg_pac" value="<?php echo $larg_pac?>">
                        <input type="hidden" name="comp_pac" value="<?php echo $comp_pac?>">
                        <button class="btn btn-primary w-100 m-2" type="submit">Finalizar</button>
                    </form>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>