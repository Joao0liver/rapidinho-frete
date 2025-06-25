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
        $id_mtboy = $_POST['id_mtboy'];

        $nome_mtboy = $_POST['nome_mtboy'];
        $email_mtboy = $_POST['email_mtboy'];
        $cpf_mtboy = $_POST['cpf_mtboy'];
        $tel_mtboy = $_POST['tel_mtboy'];
        $placa_mtboy = $_POST['placa_mtboy'];

        // Trata e filtra os dados para entrar no Banco
        $nome_mtboy = tratar_input($nome_mtboy, $conn);
        $email_mtboy = tratar_input($email_mtboy, $conn);
        $cpf_mtboy = tratar_input($cpf_mtboy, $conn);
        $tel_mtboy = tratar_input($tel_mtboy, $conn);

        if ($_POST['senha_mtboy'] <> ""){ // Se a senha estiver preenchida, realiza um método de UPDATE diferente

            // Captura, trata, filtra e criptografa a senha
            $senha_mtboy = $_POST['senha_mtboy'];
            $senha_mtboy = tratar_senha($senha_mtboy, $conn);
            $senha_cript = hash('sha256', $senha_mtboy);

            if ($nome_mtboy <> -1 && $email_mtboy <> -1 && $cpf_mtboy <> -1 && $tel_mtboy <> -1){ // Se os dados passaram no tratamento

                if ($senha_mtboy <> -1){ // Se a senha passar no tratamento (formato exigido)

                    // Verifica se o E-mail ou CPF já estão cadastrados no sistema
                    $sql = "SELECT email_user, cpf_user, senha_user FROM tbl_usuario";
                    $rodar_sql = mysqli_query($conn, $sql);

                    $registros = [];
                    while ($registro = mysqli_fetch_assoc($rodar_sql)){
                        $registros[] = $registro;
                    }

                    foreach ($registros as $registro){

                        if($email_mtboy == $registro['email_user'] && $cpf_mtboy == $registro['cpf_user'] && $senha_cript == $registro['senha_user']){ // Um e outro
                            $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';
                            $verificado = false;
                            break;
                        }else{
                            $verificado = true;
                        }

                    }

                    if ($verificado == true){ // Se o E-mail e CPF não foram cadastrados no sistema

                        // Edita os dados do motoboy com a senha
                        $sql = "UPDATE tbl_usuario SET nome_user='$nome_mtboy', email_user='$email_mtboy', cpf_user='$cpf_mtboy', tel_mtboy='$tel_mtboy', placa_mtboy='$placa_mtboy', senha_user = '$senha_cript' WHERE id_user = $id_mtboy";
                        $rodar_sql = mysqli_query($conn, $sql);

                        if ($rodar_sql){
                            $msg = '<font color="green">Atualizado com sucesso!</font>';
                        }else{
                            $msg = '<font color="red">Erro ao atualizar motoboy!</font>';
                        }
                        
                        $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy");
                        $motoboy = mysqli_fetch_array($sql_atualizado);

                    }else{ // Se o E-mail e CPF já estão presentes no Banco de Dados
                        $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';

                        $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
                        $result = mysqli_query($conn, $sql);
                        $motoboy = mysqli_fetch_array($result);
                    }

                }else{
                    $msgS = '<div id="emailHelp" class="form-text"><font color="red">*A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial. Verifique também as informações.</font></div>';

                    $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
                    $result = mysqli_query($conn, $sql);
                    $motoboy = mysqli_fetch_array($result);
                }

            }else{

                $msgS = '<font color="red">Erro ao editar informações! Revise-as e tente novamente!</font>';
                
                $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
                $result = mysqli_query($conn, $sql);
                $motoboy = mysqli_fetch_array($result);

            }

        }else{ // Se a senha não estiver preenchida, realiza um método de UPDATE diferente

            if ($nome_mtboy <> -1 && $email_mtboy <> -1 && $cpf_mtboy <> -1 && $tel_mtboy <> -1){ // Se os dados passaram no tratamento

                // Verifica se o E-mail ou CPF já estão cadastrados no sistema
                $sql = "SELECT email_user, cpf_user, senha_user FROM tbl_usuario";
                $rodar_sql = mysqli_query($conn, $sql);

                $registros = [];
                while ($registro = mysqli_fetch_assoc($rodar_sql)){
                    $registros[] = $registro;
                }

                foreach ($registros as $registro){

                    if($email_mtboy == $registro['email_user'] && $cpf_mtboy == $registro['cpf_user']){ // Um e outro
                        $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';
                        $verificado = false;
                        break;
                    }else{
                        $verificado = true;
                    }

                }

                if ($verificado == true){ // Se o E-mail e CPF não foram cadastrados no sistema

                    // Edita os dados do motoboy com a senha
                    $sql = "UPDATE tbl_usuario SET nome_user='$nome_mtboy', email_user='$email_mtboy', cpf_user='$cpf_mtboy', tel_mtboy='$tel_mtboy', placa_mtboy='$placa_mtboy' WHERE id_user = $id_mtboy";
                    $rodar_sql = mysqli_query($conn, $sql);

                    if ($rodar_sql){
                        $msg = '<font color="green">Atualizado com sucesso!</font>';
                    }else{
                        $msg = '<font color="red">Erro ao atualizar motoboy!</font>';
                    }
                    
                    $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy");
                    $motoboy = mysqli_fetch_array($sql_atualizado);

                }else{ // Se o E-mail e CPF já estão presentes no Banco de Dados
                    $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';

                    $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
                    $result = mysqli_query($conn, $sql);
                    $motoboy = mysqli_fetch_array($result);
                }

            }else{

                $msg = '<font color="red">Erro ao editar informações! Revise-as e tente novamente!</font>';
                
                $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
                $result = mysqli_query($conn, $sql);
                $motoboy = mysqli_fetch_array($result);

            }

        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){

        // Captura os dados selecionar a edição na listagem
        $id_mtboy = $_GET['id_user'];

        $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
        $result = mysqli_query($conn, $sql);
        $motoboy = mysqli_fetch_array($result);

    }

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Editar Motoboy</h6>
                            <form method="post" action="editar_mtboy_adm.php">
                                <input type="hidden" name="id_mtboy" value="<?php echo $motoboy['id_user'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" name="nome_mtboy" style="width: 700px;" value="<?php echo $motoboy['nome_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_mtboy" style="width: 500px;" value="<?php echo $motoboy['email_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" pattern="[0-9]{11}" name="cpf_mtboy" style="width: 200px;" value="<?php echo $motoboy['cpf_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" pattern="[0-9]{11}" name="tel_mtboy" style="width: 200px;" value="<?php echo $motoboy['tel_mtboy'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Placa da Moto</label>
                                    <input type="text" name="placa_mtboy" style="width: 150px;" value="<?php echo $motoboy['placa_mtboy'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nova Senha</label>
                                    <input type="password" name="senha_mtboy" class="form-control">
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