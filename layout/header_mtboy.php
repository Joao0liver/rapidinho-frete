<?php

include_once("../conexao.php");

$id_mtboy = $_SESSION['id_user'];

$sql = mysqli_query($conn, "SELECT nome_user, foto_mtboy FROM tbl_usuario WHERE id_user = $id_mtboy");
$mtboy = mysqli_fetch_array($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Motoboy - Rapidinho Fretes</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../layout/img/rapidinho.ico" rel="icon">

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


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="../motoboy/menu.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><img src="../layout/img/logo.png" height="50px" width="50px" style="margin-right: 10px;">RAPIDINHO</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../upload/img_mtboy/<?php echo $mtboy['foto_mtboy']?>" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $mtboy['nome_user']; ?></h6>
                        <span>Motoboy</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="../motoboy/solicitacoes_mtboy.php" class="nav-item nav-link"><i class="far fa-file-alt me-2"></i>Solicitações</a>
                    <a href="../motoboy/minhas_entregas_mtboy.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Entregas Pendentes</a>
                    <a href="../motoboy/historico_mtboy.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Histórico</a>
                    <a href="../forms/logout.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><img src="../layout/img/logo.png" height="45px" width="45px"></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-inline-flex"><?php echo $mtboy['nome_user']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="../motoboy/meu_perfil_mtboy.php" class="dropdown-item">Meu Perfil</a>
                            <a href="../forms/logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->