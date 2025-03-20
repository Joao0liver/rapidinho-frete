<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null){
    
    header('Location: ../index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    function obterRegistros($pagina, $limite){

        $conn = conexao();

        $offset = ($pagina - 1) * $limite;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $busca = $_POST['busca'];
    
            $sql = "SELECT * FROM tbl_distancia WHERE bairro LIKE '$busca%' ORDER BY bairro";
            $rodar_sql = mysqli_query($conn, $sql);
    
        }else{

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

    function contarRegistros(){

        $conn = conexao();

        $sql = "SELECT COUNT(*) AS total FROM tbl_distancia";
        $rodar_sql = mysqli_query($conn, $sql);

        $total = mysqli_fetch_assoc($rodar_sql)['total'];
        mysqli_close($conn);
        return $total;

    }

    $limite = 20;

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $totalRegistros = contarRegistros();

    $registros = obterRegistros($pagina, $limite);

    $totalPaginas = ceil( $totalRegistros / $limite);



?>
<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Tabela de Preços</h6>
                    <form method="post" action="listar_precos_cli.php">
                        <input type="search" name="busca" placeholder="Search"><br><br>
                    </form>
                    <table class="table">
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
                                        <td>'.$registro['valor'].'</td>
                                        </tr>';
                                        

                                }

                            ?>
                        </tbody>
                    </table>
                    <?php

                    if ($pagina > 1){
                        echo '<a href="?page='.($pagina - 1).'">Anterior</a>';
                    }

                    for ($i = 1; $i <= $totalPaginas; $i++){
                        echo '<a href="?page='.$i.'">'.$i.'</a>';
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