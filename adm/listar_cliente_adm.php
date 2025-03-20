<?php

include_once("../conexao.php");
include_once("../funcoes.php");
include_once("../layout/header_adm.php");

$sql = mysqli_query($conn, 'SELECT * FROM tbl_usuario');

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">    
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Registro de Clientes</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Senha</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    while ($row = mysqli_fetch_array($sql)){
                                        echo '<tr>
                                        <th scope="row">'.$row['id_user'].'</th>
                                        <td>'.$row['nome_user'].'</td>
                                        <td>'.$row['email_user'].'</td>
                                        <td>'.$row['cpf_user'].'</td>
                                        <td>'.$row['ende_user'].'</td>
                                        <td>'.$row['senha_user'].'</td>
                                        <td>'.status($row['status_user']).'</td>
                                    </tr>';
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