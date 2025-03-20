<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null){
    
    header('Location: ../index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    function obterRegistros($pagina, $limite) {

        $conn = conexao();

        $id_user = $_SESSION['id_user'];

        $offset = ($pagina - 1) * $limite;

        $sql = "SELECT * FROM tbl_entrega WHERE id_user = $id_user LIMIT $limite OFFSET $offset";
        $rodar_sql = mysqli_query($conn, $sql);

        $registros = [];
        while ($registro = mysqli_fetch_assoc($rodar_sql)){
            $registros[] = $registro;
        }

        mysqli_close($conn);
        return $registros;

    }
    function contarRegistros(){

        $conn = conexao();

        $id_user = $_SESSION['id_user'];

        $sql = "SELECT COUNT(*) AS total FROM tbl_entrega WHERE id_user = $id_user";
        $rodar_sql = mysqli_query($conn, $sql);

        $total = mysqli_fetch_assoc($rodar_sql)['total'];

        mysqli_close($conn);
        return $total;


    }

    $limite = 5;

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $totalRegistros = contarRegistros();

    $registros = obterRegistros($pagina, $limite);

    $totalPaginas = ceil($totalRegistros/ $limite);

?>
<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Solicitações</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Motoboy</th>
                                <th scope="col">Início</th>
                                <th scope="col">Fim</th>
                                <th scope="col">Origem</th>
                                <th scope="col">Destino</th>
                                <th scope="col">Status</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach ($registros as $registro){

                                    echo '<tr>
                                        <th scope="row">'.$registro['id_ent'].'</th>
                                        <td>'.$registro['id_mtboy'].'</td>
                                        <td>'.$registro['inicio_ent'].'</td>
                                        <td>'.$registro['fim_ent'].'</td>
                                        <td>'.$registro['ende_orig'].'</td>
                                        <td>'.$registro['ende_dest'].'</td>
                                        <td>'.status_entrega($registro['status_ent']).'</td>
                                        <td>'.$registro['valor_ent'].'</td>
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