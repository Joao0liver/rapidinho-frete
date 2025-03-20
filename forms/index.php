<?php

include_once("../layout/header_index.php");
include_once("../conexao.php");

$msg = '';

// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM tbl_usuario WHERE email_user = '$user'";
   

    $rodasql = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($rodasql); 

    $cript_senha_form = hash('sha256',$senha);

    if ($result['senha_user'] == $cript_senha_form) {    // as senhas conferem!

        session_start();

        $_SESSION['id_user'] = $result['id_user'];
        $_SESSION['email_user'] = $result['email_user'];
        echo 'entrou';
        header('Location: cliente/menu.php');
        exit();
    } else {
        $msg = '<div class="alert alert-error">
        <button class="close" data-dismiss="alert">×</button>
        <strong>Erro!</strong> Login ou senha inválida.
      </div>';
    }
}
?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-4 bg-light rounded p-4 shadow-lg" style="background-color: #f2f2f2; border-radius: 15px;">
            <h6 class="mb-4"> Bem vindo ao Rapidinho Frete</h6>
            <?php echo $msg; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="login" class="form-label">Email</label>
                    <input type="email" class="form-control" name="login" id="login" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Nunca compartilharemos seu email com ninguém.</div>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Verificar</label>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </div>
</div>
<!-- Form End -->

<!-- Footer Start -->
<div class="fixed-bottom text-center">
    <?php include_once("../layout/footer.php"); ?>
</div>
<!-- Footer End -->
