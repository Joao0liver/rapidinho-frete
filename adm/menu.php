<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 777){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    $id_user = $_SESSION['id_user'];

    $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

    // Captura os dados do administrador logado
    $sql = "SELECT nome_user FROM tbl_usuario WHERE id_user = $id_user";
    $rodar_sql = mysqli_query($conn, $sql);
    $nome_user = mysqli_fetch_assoc($rodar_sql);

    // Define o fuso horário
    date_default_timezone_set('America/Sao_Paulo');

    // Captura a data atual
    $data_atual = date("Y-m-d");
    list($ano, $mes, $dia) = explode("-", $data_atual);
    $mes--; // Corrige o mes para percorrer na lista

    // Define um padrão inicial para as variáveis
    $msg_dia = 'R$0.00';
    $msg_mes = 'R$0.00';
    $lucro_dia = 'R$0.00';
    $lucro_mes = 'R$0.00';
    $dia_form = '--';
    $mes_form = '--';
    $ano_form = '----';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Captura o dia e mês vindo do formulário select
        $ano_form = $_POST['ano'];
        $mes_form = $_POST['mes'];
        $dia_form = $_POST['dia'];

        $ano_form = tratar_data($ano_form, $conn);
        $mes_form = tratar_data($mes_form, $conn);
        $dia_form = tratar_data($dia_form, $conn);

        if ($ano_form <> -1 && $mes_form <> -1 && $dia_form <> -1){

            // Soma as vendas diárias conforme selecionado no formulário
            $sql = "SELECT SUM(valor_ent) FROM tbl_entrega WHERE YEAR(fim_ent) = $ano_form AND MONTH(fim_ent) = $mes_form AND DAY(fim_ent) = $dia_form";
            $rodar_sql = mysqli_query($conn, $sql);
            $venda_dia = mysqli_fetch_array($rodar_sql)[0];

            if (is_null($venda_dia)){
                $msg_dia = 'R$0.00';
            }else{
                $msg_dia = 'R$'.$venda_dia;
                $lucro_dia = 'R$'.number_format((30/100) * $venda_dia, 2);
            }

            // Soma as vendas mensais conforme selecionado no formulário
            $sql = "SELECT SUM(valor_ent) FROM tbl_entrega WHERE YEAR(fim_ent) = $ano_form AND MONTH(fim_ent) = $mes_form";
            $rodar_sql = mysqli_query($conn, $sql);
            $venda_mes = mysqli_fetch_array($rodar_sql)[0];

            if (is_null($venda_mes)){
                $msg_mes = 'R$0.00';
            }else{
                $msg_mes = 'R$'.$venda_mes;
                $lucro_mes = 'R$'.number_format((30/100) * $venda_mes, 2);
            }

        }

    }


?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                Dados referentes a: <?php echo $dia_form.'/'.$mes_form.'/'.$ano_form; ?>
            </div>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Vendas do Dia</p>
                                <h6 class="mb-0"><?php echo $msg_dia; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Vendas do Mês</p>
                                <h6 class="mb-0"><?php echo $msg_mes; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Lucro do Dia</p>
                                <h6 class="mb-0"><?php echo $lucro_dia; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Lucro do Mês</p>
                                <h6 class="mb-0"><?php echo $lucro_mes; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-4">
                <form action="menu.php" method="post">
                    Ano:
                    <select name="ano" size="1">
                        <?php 
                        
                        for ($i = 2025; $i <= 2099; $i++){

                            if ($ano == $i){
                                echo '<option value="'.($i).'" selected>'.$i.'</option>';
                            }else{
                                echo '<option value="'.($i).'">'.$i.'</option>';
                            }

                        }

                        ?>
                    </select>
                    Mês:
                    <select name="mes" size="1">
                        <?php 
                        
                        for ($i = 0; $i <= 11; $i++){

                            if ($mes == $i){
                                echo '<option value="'.($i + 1).'" selected>'.$meses[$i].'</option>';
                            }else{
                                echo '<option value="'.($i + 1).'">'.$meses[$i].'</option>';
                            }

                        }

                        ?>
                    </select>
                    Dia:
                    <select name="dia" size="1">
                        <?php

                        for ($i = 1; $i <= 31; $i++){

                            if ($dia == $i){
                                echo '<option value="'.$i.'" selected>'.$i.'</option>';
                            }else{
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }

                        }

                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Calcular</button>
                </form>
            </div>
            <div class="container-fluid pt-4 px-4">
                <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
                    <div class="col-md-6 text-center">
                        <h3>Olá, <?php echo $nome_user['nome_user'] ?>...</h3>
                        <h5>Administrador</h5>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>