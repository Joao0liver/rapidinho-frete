<?php

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    $sql = mysqli_query($conn, 'SELECT * FROM tbl_usuario');

    function obterRegistros($pagina, $limite){

        $conn = conexao();

        $offset = ($pagina - 1) * $limite;
        
        $sql = "SELECT * FROM tbl_usuario ORDER BY bairro LIMIT $limite OFFSET $offset";
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

                            echo "</div>";

                        ?>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");

?>