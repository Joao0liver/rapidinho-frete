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

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        // Captura os dados dos inputs
        $nome_adm = $_POST['nome_adm'];
        $email_adm = $_POST['email_adm'];
        $cpf_adm = $_POST['cpf_adm'];
        $senha_adm = $_POST['senha_adm'];

        // Trata e filtra os dados para entrar no banco
        $nome_adm = tratar_input($nome_adm, $conn);
        $email_adm = tratar_input($email_adm, $conn);
        $cpf_adm = tratar_input($cpf_adm, $conn);

        if ($nome_adm <> '' || $email_adm <> '' || $cpf_adm <> '' || $senha_adm <> ''){ // Se os campos estiverem preenchidos

            if ($nome_adm <> -1 && $email_adm <> -1 && $cpf_adm <> -1){ // Se os dados passaram no tratamento
            
                $senha_cript = hash('sha256', $senha_adm); // Criptografa a senha

                // Cadastra novo administrador
                $sql = "INSERT INTO tbl_usuario (nome_user, email_user, cpf_user, senha_user, nivel_user) VALUES ('$nome_adm', '$email_adm', '$cpf_adm', '$senha_cript', 777)";
                $rodar_sql = mysqli_query($conn, $sql);

                if($rodar_sql){
                    $msg = '<font color="green">Cadastrado com sucesso!</font>';
                }else{
                 $msg = '<font color="red">Falha ao cadastrar!</font>';
                }

            }else{
                $msg = '<font color="red">Erro ao cadastrar! Por favor, revise as informações e tente novamente!</font>';
            }

        }

    }

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Cadastrar Novo Administrador</h6>
                            <form method="post" action="cadastrar_novo_adm.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" name="nome_adm" class="form-control" style="width: 700px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_adm" class="form-control" style="width: 500px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" pattern="[0-9]{11}" name="cpf_adm" class="form-control" style="width: 200px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Senha</label>
                                    <input type="password" name="senha_adm" class="form-control" style="width: 600px;" required>
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
}

?>