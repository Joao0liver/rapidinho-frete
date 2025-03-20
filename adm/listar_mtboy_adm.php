<?php

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    $sql = mysqli_query($conn, 'SELECT * FROM tbl_motoboy');

    function contarRegistros(){

    $conn = conexao();

    $sql = "SELECT COUNT(*) AS total FROM tbl_motoboy";
    $rodar_sql = mysqli_query($conn, $sql);

    $total = mysqli_fetch_assoc($rodar_sql)['total'];
    mysqli_close($conn);

    return $total;

    }

    function obterRegistros($pagina, $limite){
        
    $conn = conexao();

    $offset = ($pagina - 1) * $limite;
    $sql = "SELECT * FROM tbl_motoboy LIMIT $limite OFFSET $offset";
    $rodar_sql = mysqli_query($conn, $sql);

    $registros = [];

    while($registro = mysqli_fetch_assoc($rodar_sql)){
        $registros[] = $registro;
    }

    mysqli_close($conn);

    return $registros;

    }

    $limite = 5;

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $totalRegistros = contarRegistros();

    $totalPaginas = ceil($totalRegistros / $limite);

    $registros = obterRegistros($pagina, $limite);

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">    
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Registro de Motoboys</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <script>

                                function confirmaDel(event, id) {

                                    event.preventDefault();

                                    const confirmacao = confirm("Deseja deletar?");

                                    if (confirmacao){
                                        
                                        window.location.href = `excluir_mtboy_adm.php?id_mtboy=${id}`;
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
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Placa</th>
                                    <th scope="col">Score</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    foreach ($registros as $registro){

                                        echo '<tr>
                                        <th scope="row">'.$registro['id_mtboy'].'</th>
                                        <td>'.$registro['nome_mtboy'].'</td>
                                        <td>'.$registro['email_mtboy'].'</td>
                                        <td>'.$registro['cpf_mtboy'].'</td>
                                        <td>'.$registro['tel_mtboy'].'</td>
                                        <td>'.$registro['placa_mtboy'].'</td>
                                        <td>'.$registro['score_mtboy'].'</td>
                                        <td>'.status($registro['status_mtboy']).'</td>
                                        <td>
                                        <a href="editar_mtboy_adm.php?id_mtboy='.$registro['id_mtboy'].'"><img src="../layout/img/lapis.png" height="18px" width="18px" style="margin-right: 8px;"></a>';
                                        if ($registro['status_mtboy'] == 1){
                                        echo '<a href="excluir_mtboy_adm.php?id_mtboy='.$registro['id_mtboy'].'" onclick="confirmaDel(event, '.$registro['id_mtboy'].')"><img src="../layout/img/lixo.png" height="18px" width="18px"></a>
                                        </td>
                                        </tr>';
                                        
                                    }
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
    echo '<a href="?page='.($pagina + 1).'">Proximo</a>';
}

?>

                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");

?>