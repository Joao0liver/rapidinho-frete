<?php

include_once('../conexao.php');
include_once('../funcoes.php');

$msg = '';
$msgS= '<div id="emailHelp" class="form-text">*A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial.</div> <br>';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $verificado = false;

    // Captura os dados dos inputs
    $nome_user = $_POST['nome_user'];
    $email_user = $_POST['email_user'];
    $cpf_user = $_POST['cpf_user'];
    $ende_user = $_POST['ende_user'];
    $bairro_user = $_POST['bairro_user'];
    $senha_user = $_POST['senha_user'];

    // Trata e filtra as informações utilizando as respecticas funções para entrar no banco
    $nome_user = tratar_input($nome_user, $conn);
    $ende_user = tratar_input($ende_user, $conn);
    $email_user = tratar_input($email_user, $conn);
    $cpf_user = tratar_input($cpf_user, $conn);
    $senha_user = tratar_senha($senha_user, $conn);

    if ($nome_user <> '' or $email_user <> '' or $cpf_user <> '' or $ende_user <> '' or $senha_user <> ''){ // Se os inputs não estiverem vazios

        if ($nome_user <> -1 && $ende_user <> -1 && $email_user <> -1 && $cpf_user <> -1){ // Se o tratamento dos dados ficou correspondente com o desejado

            // Verifica se o E-mail ou CPF já estão cadastrados no sistema
            $sql = "SELECT * FROM tbl_usuario";
            $rodar_sql = mysqli_query($conn, $sql);

            $registros = [];
            while ($registro = mysqli_fetch_assoc($rodar_sql)){
                $registros[] = $registro;
            }

            foreach ($registros as $registro){

                if($email_user == $registro['email_user'] || $cpf_user == $registro['cpf_user']){ // Um ou outro
                    $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';
                    $verificado = false;
                    break;
                }else{
                    $verificado = true;
                }

            }

            if ($verificado == true){ // Se o E-mail e CPF não foram cadastrados no sistema

                if ($senha_user <> -1){ // Se a senha estiver no formato correto

                    $senha_cript = hash('sha256', $senha_user); // Criptografa a senha

                    $sql = "INSERT INTO tbl_usuario (nome_user, email_user, cpf_user, ende_user, bairro_user, senha_user) VALUES ('$nome_user', '$email_user', '$cpf_user', '$ende_user', '$bairro_user', '$senha_cript')";
                    $rodar_sql = mysqli_query($conn, $sql);

                    if($rodar_sql){
                        $msg = '<font color="green">Cadastrado com sucesso!</font> <br>';
                    }else{
                        $msg = '<font color="red">Falha ao cadastrar! Por favor, revise as informações e tente novamente!</font> <br>';
                    }

                }else{
                    $msgS = '<div id="emailHelp" class="form-text"><font color="red">*A senha deve ter pelo menos 8 caracteres, incluindo letras, números e um caractere especial.</font></div> <br>';
                }

            }else{ // Se o E-mail e CPF já estão presentes no Banco de Dados
                $msg = '<font color="red">E-mail ou CPF já cadastrados no sistema!</font> <br>';
            }

        }else{
            $msg = '<font color="red">Falha ao cadastrar! Por favor, revise as informações e tente novamente!</font> <br>';
        }

    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastrar-se - Rapidinho Frete</title>
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


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="../layout/index.html" class="">
                                <h3 class="text-primary"><img src="../layout/img/logo.png" height="50px" width="50px" style="margin-right: 10px;">Cadastro</h3>
                            </a>
                        </div>
                        <form method="post" action="cadastro_user.php">
                            <div class="form-floating mb-3">
                                <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" name="nome_user" class="form-control" id="floatingText" required>
                                <label for="floatingText">Nome</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email_user" class="form-control" id="floatingInput" required>
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="number" pattern="[0-9]{11}" name="cpf_user" class="form-control" id="floatingPassword" required>
                                <label for="floatingPassword">CPF</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ0-9,\s]+" name="ende_user" class="form-control" id="floatingInput" required>
                                <label for="floatingInput">Endereço</label>
                            </div>
                            <div class="">
                                <select name="bairro_user" id="bairro_user" class="form-select mb-3" style="width: 150px;" required>
                                    <option value="" disabled selected>Bairro</option>
                                    <option>Aeroporto</option>
                                    <option>Adolfo Vireque</option>
                                    <option>Alto Grajau</option>
                                    <option>Alto dos Passos</option>
                                    <option>Alto dos Pinheiros</option>
                                    <option>Amazonia</option>
                                    <option>Araujo</option>
                                    <option>Aracy</option>
                                    <option>Arco Iris</option>
                                    <option>Bairu</option>
                                    <option>Bandeirantes</option>
                                    <option>Barbosa Lage</option>
                                    <option>Barreira do Triunfo</option>
                                    <option>Bela Aurora</option>
                                    <option>Benfica</option>
                                    <option>Boa Vista</option>
                                    <option>Bom Clima</option>
                                    <option>Bom Jardim</option>
                                    <option>Bom Pastor</option>
                                    <option>Bonfim</option>
                                    <option>Borboleta</option>
                                    <option>Borborema</option>
                                    <option>Bosque do Imperador</option>
                                    <option>Bosque dos Pinheiros</option>
                                    <option>Caete</option>
                                    <option>Caicaras</option>
                                    <option>Carlos Chagas</option>
                                    <option>Cascatinha</option>
                                    <option>Ceramica</option>
                                    <option>Cidade do Sol</option>
                                    <option>Cidade Jardim</option>
                                    <option>Cidade Nova</option>
                                    <option>Cidade Universitaria</option>
                                    <option>Costa Carvalho</option>
                                    <option>Cruzeiro do Sul</option>
                                    <option>Democrata</option>
                                    <option>Dias Tavares</option>
                                    <option>Distrito Industrial</option>
                                    <option>Dom Bosco</option>
                                    <option>Dom Orione</option>
                                    <option>Eldorado</option>
                                    <option>Encosta do Sol</option>
                                    <option>Esplanada</option>
                                    <option>Estadio</option>
                                    <option>Estrela Sul</option>
                                    <option>Fabrica</option>
                                    <option>Filgueiras</option>
                                    <option>Floresta</option>
                                    <option>Fontesville</option>
                                    <option>Francisco Bernardino</option>
                                    <option>Furtado de Menezes</option>
                                    <option>Graminha</option>
                                    <option>Granbery</option>
                                    <option>Granjas Betania</option>
                                    <option>Granville</option>
                                    <option>Grajau</option>
                                    <option>Grama</option>
                                    <option>Igrejinha</option>
                                    <option>Industrial</option>
                                    <option>Ipiranga</option>
                                    <option>Jardim Da Serra</option>
                                    <option>Jardim De Ala</option>
                                    <option>Jardim Do Sol</option>
                                    <option>Jardim Gaucho</option>
                                    <option>Jardim Gloria</option>
                                    <option>Jardim Laranjeiras</option>
                                    <option>Jardim Marajoara</option>
                                    <option>Jardim Natal</option>
                                    <option>Jardim Santa Izabel</option>
                                    <option>Jardim Saudade</option>
                                    <option>Jardim dos Alfineiros</option>
                                    <option>JK</option>
                                    <option>Jockey 1, 2 e 3</option>
                                    <option>Ladeira</option>
                                    <option>Linhares</option>
                                    <option>Lourdes</option>
                                    <option>Manoel Honorio</option>
                                    <option>Mariano Procopio</option>
                                    <option>Marilandia</option>
                                    <option>Marumbi</option>
                                    <option>Milho Branco</option>
                                    <option>Monte Castelo</option>
                                    <option>Morada do Serro</option>
                                    <option>Morro do Imperador</option>
                                    <option>Mundo Novo</option>
                                    <option>Matias Barbosa</option>
                                    <option>Nossa Senhora Aparecida</option>
                                    <option>Nossa Senhora das Gracas</option>
                                    <option>Nossa Senhora de Fatima</option>
                                    <option>Nova Benfica</option>
                                    <option>Nova California</option>
                                    <option>Nova Era</option>
                                    <option>Nova Suica</option>
                                    <option>Novo horizonte</option>
                                    <option>Olavo Costa</option>
                                    <option>Parque Burnier</option>
                                    <option>Parque das Torres</option>
                                    <option>Parque Guarani</option>
                                    <option>Parque Imperial</option>
                                    <option>Parque Serra Verde</option>
                                    <option>Parque Sul</option>
                                    <option>Paineiras</option>
                                    <option>Pio XII</option>
                                    <option>Poco Rico</option>
                                    <option>Ponte Preta</option>
                                    <option>Previdenciarios</option>
                                    <option>Progresso</option>
                                    <option>Recanto Dos Lagos</option>
                                    <option>Renascenca</option>
                                    <option>Retiro</option>
                                    <option>Rodoviaria</option>
                                    <option>Quintas da Avenida</option>
                                    <option>Sagrado</option>
                                    <option>Santos Anjos</option>
                                    <option>Santos Dumont</option>
                                    <option>Sao Benedito</option>
                                    <option>Sao Bernardo</option>
                                    <option>Sao Conrado</option>
                                    <option>Sao Damiao</option>
                                    <option>Sao Dimas</option>
                                    <option>Sao Francisco de Paula</option>
                                    <option>Sao Geraldo</option>
                                    <option>Sao Judas Tadeu</option>
                                    <option>Sao Mateus</option>
                                    <option>Sao Pedro</option>
                                    <option>Sao Sebastiao</option>
                                    <option>Sao Terezinha</option>
                                    <option>Santa Amelia</option>
                                    <option>Santa Candida</option>
                                    <option>Santa Catarina</option>
                                    <option>Santa Cecilia</option>
                                    <option>Santa Cruz</option>
                                    <option>Santa Efigenia</option>
                                    <option>Santa Helena</option>
                                    <option>Santa Lucia</option>
                                    <option>Santa Luzia</option>
                                    <option>Santa Maria</option>
                                    <option>Santa Paula</option>
                                    <option>Santa Rita de Cassia</option>
                                    <option>Santa Tereza</option>
                                    <option>Santo Antonio</option>
                                    <option>Serro Azul</option>
                                    <option>Shop Independencia</option>
                                    <option>Solidariedade</option>
                                    <option>Spina Ville</option>
                                    <option>Teixeiras</option>
                                    <option>Terras Altas</option>
                                    <option>Tiguera</option>
                                    <option>Tres Moinhos</option>
                                    <option>Tupa</option>
                                    <option>UFJF</option>
                                    <option>Usina Quatro</option>
                                    <option>Vale do Ipe</option>
                                    <option>Vale Verde</option>
                                    <option>Vila Alpina</option>
                                    <option>Vila Ideal</option>
                                    <option>Vila Montanhesa</option>
                                    <option>Vila Olavo Costa</option>
                                    <option>Vila Ozanan</option>
                                    <option>Vila Sao Jose</option>
                                    <option>Vina Del Mar</option>
                                    <option>Vivendas da Serra</option>
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="senha_user" class="form-control" id="floatingInput" required>
                                <label for="floatingInput">Senha</label>
                            </div>
                            <?php echo $msgS; ?>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a href="">Esqueci a senha</a>
                            </div>
                            <?php echo $msg.'<br>'; ?>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Cadastrar-se</button>
                        </form>
                        <p class="text-center mb-0">Já tem uma conta? <a href="index.php">Faça login</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
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