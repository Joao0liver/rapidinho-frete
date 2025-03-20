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

    if ($result['senha_user'] == $cript_senha_form and $result['status_user'] == 1) {    // as senhas conferem! - status (ativo/inativo) do usuário!

        if ($result['nivel_user'] == 10){

            session_start();

            $_SESSION['id_user'] = $result['id_user'];
            $_SESSION['email_user'] = $result['email_user'];
            $_SESSION['nivel_user'] = $result['nivel_user'];
            header('Location: ../cliente/menu.php');
            exit();

        }elseif ($result['nivel_user'] == 100){

            session_start();

            $_SESSION['id_user'] = $result['id_user'];
            $_SESSION['email_user'] = $result['email_user'];
            $_SESSION['nivel_user'] = $result['nivel_user'];
            header('Location: ../motoboy/menu.php');
            exit();

        }elseif ($result['nivel_user'] == 777){

            session_start();

            $_SESSION['id_user'] = $result['id_user'];
            $_SESSION['email_user'] = $result['email_user'];
            $_SESSION['nivel_user'] = $result['nivel_user'];
            header('Location: ../adm/menu.php');
            exit();

        }

    } else {
        $msg = '<font color="red">E-mail ou senha inválidos!</font>';
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../layout/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../layout/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../layout/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../layout/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../layout/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.php" class="">
                                <h3 class="text-primary"><img src="../layout/img/logo.png" height="50px" width="50px" style="margin-right: 10px;"></i>Rapidinho Fretes</h3>
                            </a>
                        </div>
                        <form method="post" action="index.php">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="login" placeholder="name@example.com">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Password">
                                <label for="floatingPassword">Senha</label>
                                <?php echo '<br>'.$msg; ?>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a href="">Esqueci minha senha</a>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Login</button>
                        </form>
                        <p class="text-center mb-0">Não tem uma conta? <a href="cadastro_user.php">Crie agora</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../layout/lib/chart/chart.min.js"></script>
    <script src="../layout/lib/easing/easing.min.js"></script>
    <script src="../layout/lib/waypoints/waypoints.min.js"></script>
    <script src="../layout/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../layout/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../layout/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../layout/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../layout/js/main.js"></script>
</body>

</html>
