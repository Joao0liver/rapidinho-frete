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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem'])){

        $nome_mtboy = $_POST['nome_mtboy'];
        $foto_mtboy = $_FILES['imagem'];
        $email_mtboy = $_POST['email_mtboy'];
        $cpf_mtboy = $_POST['cpf_mtboy'];
        $tel_mtboy = $_POST['tel_mtboy'];
        $placa_mtboy = $_POST['placa_mtboy'];
        $senha_mtboy = $_POST['senha_mtboy'];

        $nome_mtboy = tratar_input($nome_mtboy, $conn);
        $email_mtboy = tratar_input($email_mtboy, $conn);
        $cpf_mtboy = tratar_input($cpf_mtboy, $conn);
        $tel_mtboy = tratar_input($tel_mtboy, $conn);

        if ($nome_mtboy <> '' || $foto_mtboy <> '' || $email_mtboy <> '' || $cpf_mtboy <> '' || $tel_mtboy <> '' || $placa_mtboy <> '' || $senha_mtboy <> ''){

            if ($nome_mtboy <> -1 && $email_mtboy <> -1 && $cpf_mtboy <> -1 && $tel_mtboy <> -1){

                $senha_cript = hash('sha256', $senha_mtboy);

                $sql = "INSERT INTO tbl_usuario (nome_user, email_user, cpf_user, tel_mtboy, placa_mtboy, senha_user, nivel_user) VALUES ('$nome_mtboy', '$email_mtboy', '$cpf_mtboy', '$tel_mtboy', '$placa_mtboy', '$senha_cript', 100)";
                $rodar_sql = mysqli_query($conn, $sql);

                if($rodar_sql){
                    $msg = '<font color="green">Cadastrado com sucesso!</font>';
                }else{
                    $msg = '<font color="red">Falha ao cadastrar!</font>';
                }

                // Pegar ID do Cadastro

                $sql = "SELECT id_user FROM tbl_usuario WHERE cpf_user = $cpf_mtboy";
                $rodar_sql = mysqli_query($conn, $sql);
                $result = mysqli_fetch_assoc($rodar_sql);

                $id_mtboy = $result['id_user'];

                // UPLOAD IMAGEM ------------------------------------------------------------------------

                // Diretório onde as imagens serão armazenadas
                $diretorioDestino = '../upload/img_mtboy/';

                // Obtém o arquivo enviado
                $imagem = $_FILES['imagem'];
                
                // Verifica se houve algum erro no upload
                if ($imagem['error'] != UPLOAD_ERR_OK) {
                    die("Erro no upload da imagem.");
                }

                // Obtém a extensão do arquivo
                $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);

                // Extensões permitidas
                $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

                // Converte a extensão para minúscula para comparar
                $extensao = strtolower($extensao);

                // Verifica se a extensão do arquivo é válida
                if (!in_array($extensao, $extensoesPermitidas)) {
                    die("Tipo de arquivo inválido. Somente imagens JPG, JPEG e PNG são permitidas.");
                }

                // Obtém o caminho completo do arquivo temporário
                $caminhoTemporario = $imagem['tmp_name'];

                // Gera o hash SHA-256 do arquivo
                $novoNome = hash('sha256', time().$token = bin2hex(random_bytes(32)));

                // Nome final do arquivo, com a extensão
                $novoCaminho = $diretorioDestino . $novoNome . '.' . $extensao;

                $nome_banco = $novoNome . '.' . $extensao;

                // Move o arquivo para o diretório de destino com o novo nome
                if (move_uploaded_file($caminhoTemporario, $novoCaminho)) {

                    include_once('../conexao.php');

                    $sql = "UPDATE tbl_usuario SET foto_mtboy = '$nome_banco' WHERE id_user = $id_mtboy";
                    $roda_sql = mysqli_query($conn, $sql);

                } else {
                    echo "Erro ao mover o arquivo para o diretório final.";
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
                            <h6 class="mb-4">Cadastrar Motoboy</h6>
                            <form method="post" action="cadastrar_mtboy_adm.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" name="nome_mtboy" class="form-control" style="width: 700px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="imagem">Foto de Perfil:</label>
                                    <input type="file" name="imagem" id="imagem" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_mtboy" class="form-control" style="width: 500px;" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" pattern="[0-9]{11}" name="cpf_mtboy" class="form-control" style="width: 200px;" placeholder="XXXXXXXXXXX" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="tel" pattern="[0-9]{11}" name="tel_mtboy" class="form-control" style="width: 200px;" placeholder="XXXXXXXXXXX" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Placa da Moto</label>
                                    <input type="text" name="placa_mtboy" class="form-control" style="width: 150px;" placeholder="XXXXXXX" required>
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
}

?>