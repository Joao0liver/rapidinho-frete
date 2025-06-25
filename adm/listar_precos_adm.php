<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 777){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    function obterRegistros($pagina, $limite){ // Obtém os registros da tabela de preços por bairro

        $conn = conexao();

        $offset = ($pagina - 1) * $limite; // Define o offset

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Caso o usuário realize uma busca de bairro

            $busca = $_POST['busca'];
    
            $sql = "SELECT * FROM tbl_distancia WHERE bairro LIKE '$busca%' ORDER BY bairro";
            $rodar_sql = mysqli_query($conn, $sql);
    
        }else{ // Caso não realize uma busca

            $sql = "SELECT * FROM tbl_distancia ORDER BY bairro LIMIT $limite OFFSET $offset";
            $rodar_sql = mysqli_query($conn, $sql);

        }

        $registros = [];
        while ($registro = mysqli_fetch_assoc($rodar_sql)){
            $registros[] = $registro;
        }

        mysqli_close($conn);
        return $registros;

    }

    function contarRegistros(){ // Conta os registros para fazer paginação da Lista

        $conn = conexao();

        // Faz uma consulta com contagem dos registros da tabela de preços por bairro
        $sql = "SELECT COUNT(*) AS total FROM tbl_distancia";
        $rodar_sql = mysqli_query($conn, $sql);

        $total = mysqli_fetch_assoc($rodar_sql)['total'];
        mysqli_close($conn);
        return $total;

    }

    $limite = 20; // Limite de registros por página

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página atual

    $totalRegistros = contarRegistros();

    $registros = obterRegistros($pagina, $limite);

    $totalPaginas = ceil( $totalRegistros / $limite);

    // Limitação da quantidade de links visíveis da paginação V

    $maxLinks = 5; // Número de links de página visíveis

    // Garante que o valor não seja inferior a 1
    $inicio = max(1, $pagina - floor($maxLinks / 2));

    // Garante que o valor não ultrapasse o total de páginas
    $fim = min($totalPaginas, $inicio + $maxLinks - 1);


?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Tabela de Preços</h6>
                    <form method="post" action="listar_precos_cli.php">
                        <input type="search" name="busca" placeholder="Pesquisar"><br><br>
                    </form>
                    <div class="table-responsive">
                    <table class="table" style="color: #003879">
                        <thead>
                            <tr>
                                <th scope="col">Bairro</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($registros as $registro){

                                    echo '<tr>
                                        <th scope="row">'.$registro['bairro'].'</th>
                                        <td>R$'.$registro['valor'].'</td>
                                        <td><a href="editar_preco_adm.php?id_dist='.$registro['id_dist'].'"><img src="../layout/img/lapis.png" height="18px" width="18px" style="margin-right: 8px;"></a></td>
                                        </tr>';
                                        

                                }

                            ?>
                        </tbody>
                    </table>
                    </div>
                    <?php

                        if ($pagina > 1){
                            echo '<a href="?page='.($pagina - 1).'">Anterior</a>';
                        }

                        for ($i = $inicio; $i <= $fim; $i++){
                            if ($i == $pagina){

                                echo "<b>$i</b>";

                            }else{

                                echo '<a href="?page='.$i.'">'.$i.'</a>';

                            }
                        }

                        if ($pagina < $totalPaginas){
                            echo '<a href="?page='.($pagina + 1).'">Próximo</a>';
                        }

                    ?>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>