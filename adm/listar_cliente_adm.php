<?php

include_once("../conexao.php");
include_once("../funcoes.php");
include_once("../layout/header_adm.php");

$sql = mysqli_query($conn, 'SELECT * FROM tbl_usuario');

function obterRegistros($pagina, $limite){

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'rapidinho_teste';

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn){
        die();
    }

    $offset = ($pagina - 1) * $limite;
    
    $sql = "SELECT * FROM tbl_usuario LIMIT $limite OFFSET $offset";
    $rodar_sql = mysqli_query($conn, $sql);

    $registros = [];
    while ($registro = mysqli_fetch_assoc($rodar_sql)){
        $registros[] = $registro;
    }

    mysqli_close($conn);
    return $registros;

}
function contarRegistros(){

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'rapidinho_teste';

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn){
        die();
    }

    $sql = "SELECT COUNT(*) AS total FROM tbl_usuario";
    $rodar_sql = mysqli_query($conn, $sql);

    $total = mysqli_fetch_assoc($rodar_sql)['total'];
    mysqli_close($conn);
    return $total;

}

$limite = 5;

$pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$totalRegistros = contarRegistros();

$registros = obterRegistros($pagina, $limite);

$totalPagina = ceil($totalRegistros / $limite);

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">    
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Registro de Clientes</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <script>

                                function confirmaDel(event, id) {

                                    event.preventDefault();

                                    const confirmacao = confirm("Deseja deletar?");

                                    if (confirmacao){
                                        
                                        window.location.href = `excluir_cliente_adm.php?id_cliente=${id}`;
                                        alert("Deletado com sucesso!");

                                    }else{

                                        alert("Ação cancelada!");

                                    }

                                }

                            </script>
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    foreach ($registros as $registro) {

                                        echo '<tr>
                                        <th scope="row">'.$registro['id_user'].'</th>
                                        <td>'.$registro['nome_user'].'</td>
                                        <td>'.$registro['email_user'].'</td>
                                        <td>'.$registro['cpf_user'].'</td>
                                        <td>'.$registro['ende_user'].'</td>
                                        <td>'.status($registro['status_user']).'</td>
                                        <td>
                                        <a href="editar_cliente_adm.php?id_cliente='.$registro['id_user'].'"><img src="../layout/img/lapis.png" height="18px" width="18px" style="margin-right: 8px;"></a>';
                                        if ($registro['status_user'] == 1){
                                        echo '<a href="excluir_cliente_adm.php?id_cliente='.$registro['id_user'].'" onclick="confirmaDel(event, '.$registro['id_user'].')"><img src="../layout/img/lixo.png" height="18px" width="18px"></a>
                                        </td>
                                        </tr>';
                                        }


                                    }

                                ?>

                            </tbody>
                        </table>
                        <?php

                            echo "<div>";

                            if ($pagina > 1){
                                echo '<a href="?page='.($pagina - 1).'">Anterior</a>';
                            }

                            for ($i = 1; $i <= $totalPagina; $i++) {

                                echo '<a href="?page='.$i.'">'.$i.'</a>';

                            }

                            if ($pagina < $totalPagina) {
                                echo '<a href="?page='.($pagina + 1).'">Próxima</a>';
                            }

                            echo "</div>";

                        ?>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");

?>