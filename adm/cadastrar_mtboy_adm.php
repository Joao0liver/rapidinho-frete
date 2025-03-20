<?php

    include_once('../conexao.php');
    include_once("../layout/header_adm.php");

    $msg = '<br>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $nome_mtboy = $_POST['nome_mtboy'];
        $email_mtboy = $_POST['email_mtboy'];
        $cpf_mtboy = $_POST['cpf_mtboy'];
        $tel_mtboy = $_POST['tel_mtboy'];
        $placa_mtboy = $_POST['placa_mtboy'];
        $senha_mtboy = $_POST['senha_mtboy'];

        if ($nome_mtboy <> '' or $email_mtboy <> '' or $cpf_mtboy <> '' or $tel_mtboy <> '' or $placa_mtboy <> '' or $senha_mtboy <> ''){

            $senha_cript = hash('sha256', $senha_mtboy);

            $sql = "INSERT INTO tbl_usuario (nome_user, email_user, cpf_user, tel_mtboy, placa_mtboy, senha_user, nivel_user) VALUES ('$nome_mtboy', '$email_mtboy', '$cpf_mtboy', '$tel_mtboy', '$placa_mtboy', '$senha_cript', 100)";
            $rodar_sql = mysqli_query($conn, $sql);

            if($rodar_sql){
                $msg = '<font color="green">Cadastrado com sucesso!</font>';
            }else{
                $msg = '<font color="red">Falha ao cadastrar!</font>';
            }

        }

    }

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Cadastrar Motoboy</h6>
                            <form method="post" action="cadastrar_mtboy_adm.php">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="nome_mtboy" class="form-control" style="width: 700px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_mtboy" class="form-control" style="width: 500px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" name="cpf_mtboy" class="form-control" style="width: 200px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="number" name="tel_mtboy" class="form-control" style="width: 200px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Placa da Moto</label>
                                    <input type="text" name="placa_mtboy" class="form-control" style="width: 150px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Senha</label>
                                    <input type="password" name="senha_mtboy" class="form-control" style="width: 600px;" required>
                                </div>
                                <div class="mb-3">
                                    <?php echo $msg; ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </form>
                        </div>
                    </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");


?>