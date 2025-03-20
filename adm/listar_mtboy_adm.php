<?php

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    $sql = mysqli_query($conn, 'SELECT * FROM tbl_usuario');

    function contarRegistros(){

    $conn = conexao();

    $sql = "SELECT COUNT(*) AS total FROM tbl_usuario WHERE nivel_user = 100";
    $rodar_sql = mysqli_query($conn, $sql);

    $total = mysqli_fetch_assoc($rodar_sql)['total'];
    mysqli_close($conn);

    return $total;

    }

    function obterRegistros($pagina, $limite){
        
    $conn = conexao();

    $offset = ($pagina - 1) * $limite;
    $sql = "SELECT * FROM tbl_usuario WHERE nivel_user = 100 LIMIT $limite OFFSET $offset";
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
                    <h6 class="mb-4">Registro de Motoboys</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <script>

                                function confirmaDel(event, id) {

                                    event.preventDefault();

                                    const confirmacao = confirm("Deseja deletar?");

                                    if (confirmacao){
                                        
                                        window.location.href = `excluir_mtboy_adm.php?id_user=${id}`;
                                        alert("Deletado com sucesso!");

                                    }else{

                                        alert("Ação cancelada!");

                                    }

                                }

                            </script>
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Placa</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    foreach ($registros as $registro){

                                        echo '<tr>
                                        <th scope="row">'.$registro['id_user'].'</th>
                                        <td><img src="../upload/img_mtboy/'.$registro['foto_mtboy'].'" height="50px" width="50px"></td>
                                        <td>'.$registro['nome_user'].'</td>
                                        <td>'.$registro['email_user'].'</td>
                                        <td>'.$registro['cpf_user'].'</td>
                                        <td>'.$registro['tel_mtboy'].'</td>
                                        <td>'.$registro['placa_mtboy'].'</td>
                                        <td>'.status($registro['status_user']).'</td>
                                        <td>
                                        <a href="editar_mtboy_adm.php?id_user='.$registro['id_user'].'"><img src="../layout/img/lapis.png" height="18px" width="18px" style="margin-right: 8px;"></a>';
                                        if ($registro['status_user'] == 1){
                                        echo '<a href="excluir_mtboy_adm.php?id_user='.$registro['id_user'].'" onclick="confirmaDel(event, '.$registro['id_user'].')"><img src="../layout/img/lixo.png" height="18px" width="18px"></a>
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
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");

?>