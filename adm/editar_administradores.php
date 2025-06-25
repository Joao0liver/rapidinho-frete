<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 777){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    $msg = '<br>';
    $msgS = '<div id="emailHelp" class="form-text">*A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial.</div>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $verificado = false;

        // Captura os dados para edição
        $id_adm = $_POST['id_adm'];

        $nome_adm = $_POST['nome_adm'];
        $email_adm = $_POST['email_adm'];
        $cpf_adm = $_POST['cpf_adm'];

        // Trata e filtra os dados para entrar no Banco
        $nome_adm = tratar_input($nome_adm, $conn);
        $email_adm = tratar_input($email_adm, $conn);
        $cpf_adm = tratar_input($cpf_adm, $conn);

        if ($_POST['senha_adm'] <> ""){ // Se a senha estiver preenchida, realiza um método de UPDATE diferente

            // Captura, trata, filtra e criptografa a senha
            $senha_adm = $_POST['senha_adm'];
            $senha_adm = tratar_senha($senha_adm, $conn);
            $senha_cript = hash('sha256', $senha_adm);

            if ($nome_adm <> -1 && $email_adm <> -1 && $cpf_adm <> -1){ // Se os dados passaram no tratamento

                if ($senha_adm <> -1){ // Se a senha passar no tratamento (formato exigido)

                    // Verifica se o E-mail ou CPF já estão cadastrados no sistema
                    $sql = "SELECT email_user, cpf_user, senha_user FROM tbl_usuario";
                    $rodar_sql = mysqli_query($conn, $sql);

                    $registros = [];
                    while ($registro = mysqli_fetch_assoc($rodar_sql)){
                        $registros[] = $registro;
                    }

                    foreach ($registros as $registro){

                        if($email_adm == $registro['email_user'] && $cpf_adm == $registro['cpf_user'] && $senha_cript == $registro['senha_user']){ // Um e outro
                            $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';
                            $verificado = false;
                            break;
                        }else{
                            $verificado = true;
                        }

                    }

                    if ($verificado == true){ // Se o E-mail e CPF não foram cadastrados no sistema

                        // Edita os dados do administrador com a senha
                        $sql = "UPDATE tbl_usuario SET nome_user='$nome_adm', email_user='$email_adm', cpf_user='$cpf_adm', senha_user = '$senha_cript' WHERE id_user = $id_adm";
                        $rodar_sql = mysqli_query($conn, $sql);

                        if ($rodar_sql){
                            $msg = '<font color="green">Atualizado com sucesso!</font>';
                        }else{
                            $msg = '<font color="red">Erro ao atualizar administrador!</font>';
                        }
                        
                        $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_adm");
                        $admin = mysqli_fetch_array($sql_atualizado);

                    }else{ // Se o E-mail e CPF já estão presentes no Banco de Dados
                        $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';

                        $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
                        $result = mysqli_query($conn, $sql);
                        $admin = mysqli_fetch_array($result);
                    }

                }else{
                    $msgS = '<div id="emailHelp" class="form-text"><font color="red">*A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial.</font></div>';

                    $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
                    $result = mysqli_query($conn, $sql);
                    $admin = mysqli_fetch_array($result);
                }

            }else{
                $msgS = '<font color="red">Erro ao editar informações! Revise-as e tente novamente!</font>';

                $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
                $result = mysqli_query($conn, $sql);
                $admin = mysqli_fetch_array($result);
            }

        }else{ // Se a senha não estiver preenchida, realiza um método de UPDATE diferente

            if ($nome_adm <> -1 && $email_adm <> -1 && $cpf_adm <> -1){ // Se os dados passaram no tratamento

                // Verifica se o E-mail ou CPF já estão cadastrados no sistema
                $sql = "SELECT email_user, cpf_user FROM tbl_usuario";
                $rodar_sql = mysqli_query($conn, $sql);

                $registros = [];
                while ($registro = mysqli_fetch_assoc($rodar_sql)){
                    $registros[] = $registro;
                }

                foreach ($registros as $registro){

                    if($email_adm == $registro['email_user'] && $cpf_adm == $registro['cpf_user']){ // Um e outro
                        $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';
                        $verificado = false;
                        break;
                    }else{
                        $verificado = true;
                    }

                }

                if ($verificado == true){ // Se o E-mail e CPF não foram cadastrados no sistema

                    // Edita os dados do administrador sem a senha
                    $sql = "UPDATE tbl_usuario SET nome_user='$nome_adm', email_user='$email_adm', cpf_user='$cpf_adm' WHERE id_user = $id_adm";
                    $rodar_sql = mysqli_query($conn, $sql);

                    if ($rodar_sql){
                        $msg = '<font color="green">Atualizado com sucesso!</font>';
                    }else{
                        $msg = '<font color="red">Erro ao atualizar administrador!</font>';
                    }
                    
                    $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_adm");
                    $admin = mysqli_fetch_array($sql_atualizado);

                }else{ // Se o E-mail e CPF já estão presentes no Banco de Dados
                    $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';

                    $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
                    $result = mysqli_query($conn, $sql);
                    $admin = mysqli_fetch_array($result);
                }

            }else{
                $msg = '<font color="red">Erro ao editar informações! Revise-as e tente novamente!</font>';

                $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
                $result = mysqli_query($conn, $sql);
                $admin = mysqli_fetch_array($result);
            }

        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){

        $id_adm = $_GET['id_adm'];

        // Captura os dados selecionar a edição na listagem
        $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
        $result = mysqli_query($conn, $sql);
        $admin = mysqli_fetch_array($result);

    }

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Editar administrador</h6>
                            <form method="post" action="editar_administradores.php">
                                <input type="hidden" name="id_adm" value="<?php echo $admin['id_user'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" name="nome_adm" style="width: 700px;" value="<?php echo $admin['nome_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_adm" style="width: 500px;" value="<?php echo $admin['email_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" pattern="[0-9]{11}" name="cpf_adm" style="width: 200px;" value="<?php echo $admin['cpf_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nova Senha</label>
                                    <input type="password" name="senha_adm" class="form-control">
                                </div>
                                <?php echo $msgS; ?>
                                <div class="mb-3">
                                    <?php echo $msg; ?>
                                </div>
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </form>
                        </div>
                    </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>