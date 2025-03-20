<?php

include_once("../conexao.php");
include_once("../funcoes.php");
include_once("../layout/header_adm.php");

$sql = mysqli_query($conn, 'SELECT * FROM tbl_motoboy');

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

                                    while ($row = mysqli_fetch_array($sql)){
                                        echo '<tr>
                                        <th scope="row">'.$row['id_mtboy'].'</th>
                                        <td>'.$row['nome_mtboy'].'</td>
                                        <td>'.$row['email_mtboy'].'</td>
                                        <td>'.$row['cpf_mtboy'].'</td>
                                        <td>'.$row['tel_mtboy'].'</td>
                                        <td>'.$row['placa_mtboy'].'</td>
                                        <td>'.$row['score_mtboy'].'</td>
                                        <td>'.status($row['status_mtboy']).'</td>
                                        <td>
                                        <a href="editar_mtboy_adm.php?id_mtboy='.$row['id_mtboy'].'"><img src="../layout/img/lapis.png" height="18px" width="18px" style="margin-right: 8px;"></a>';
                                        if ($row['status_mtboy'] == 1){
                                        echo '<a href="excluir_mtboy_adm.php?id_mtboy='.$row['id_mtboy'].'" onclick="confirmaDel(event, '.$row['id_mtboy'].')"><img src="../layout/img/lixo.png" height="18px" width="18px"></a>
                                        </td>
                                        </tr>';
                                        }
                                    }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");

?>