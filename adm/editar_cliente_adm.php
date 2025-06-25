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

        $id_cliente = $_POST['id_cliente'];

        $nome_cliente = $_POST['nome_cliente'];
        $email_cliente = $_POST['email_cliente'];
        $cpf_cliente = $_POST['cpf_cliente'];
        $ende_cliente = $_POST['ende_cliente'];

        $nome_cliente = tratar_input($nome_cliente, $conn);
        $email_cliente = tratar_input($email_cliente, $conn);
        $cpf_cliente = tratar_input($cpf_cliente, $conn);
        $ende_cliente = tratar_input($ende_cliente, $conn);

        if (isset($_POST['senha_cliente'])){ // Caso o campo de senha esteja preenchido

            $senha_cliente = $_POST['senha_cliente'];
            $senha_cliente = tratar_senha($senha_cliente, $conn);
            $senha_cript = hash('sha256', $senha_cliente);

            if ($nome_cliente <> -1 && $email_cliente <> -1 && $cpf_cliente <> -1 && $senha_cliente <> -1){

                $sql = "UPDATE tbl_usuario SET nome_user='$nome_cliente', email_user='$email_cliente', cpf_user='$cpf_cliente', ende_user='$ende_cliente', senha_user='$senha_cript' WHERE id_user = $id_cliente";
                $rodar_sql = mysqli_query($conn, $sql);

                if ($rodar_sql){
                    $msg = '<font color="green">Atualizado com sucesso!</font>';
                }else{
                    $msg = '<font color="red">Erro ao atualizar cliente!</font>';
                }
                
                $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_cliente");
                $cliente = mysqli_fetch_array($sql_atualizado);

            }else{
                $msg = '<font color="red">Erro ao editar informações! Por favor, revise as informações e tente novamente!</font>';

                $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_cliente";
                $result = mysqli_query($conn, $sql);
                $cliente = mysqli_fetch_array($result);
            }

        }else{ // Caso o campo de senha não esteja preenchido

            if ($nome_cliente <> -1 && $email_cliente <> -1 && $cpf_cliente <> -1){

                $sql = "UPDATE tbl_usuario SET nome_user='$nome_cliente', email_user='$email_cliente', cpf_user='$cpf_cliente', ende_user='$ende_cliente' WHERE id_user = $id_cliente";
                $rodar_sql = mysqli_query($conn, $sql);

                if ($rodar_sql){
                    $msg = '<font color="green">Atualizado com sucesso!</font>';
                }else{
                    $msg = '<font color="red">Erro ao atualizar cliente!</font>';
                }
                
                $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_cliente");
                $cliente = mysqli_fetch_array($sql_atualizado);

            }else{
                $msg = '<font color="red">Erro ao editar informações! Por favor, revise as informações e tente novamente!</font>';

                $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_cliente";
                $result = mysqli_query($conn, $sql);
                $cliente = mysqli_fetch_array($result);
            }

        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){

        $id_cliente = $_GET['id_cliente'];

        $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_cliente";
        $result = mysqli_query($conn, $sql);
        $cliente = mysqli_fetch_array($result);

    }

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Editar cliente</h6>
                            <form method="post" action="editar_cliente_adm.php">
                                <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_user'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" name="nome_cliente" style="width: 700px;" value="<?php echo $cliente['nome_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_cliente" style="width: 500px;" value="<?php echo $cliente['email_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" pattern="[0-9]{11}" name="cpf_cliente" style="width: 200px;" value="<?php echo $cliente['cpf_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Endereço</label>
                                    <input type="text" pattern="[A-Za-zÀ-ÖØ-öø-ÿ0-9,\s]+" name="ende_cliente" style="width: 700px;" value="<?php echo $cliente['ende_user'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nova Senha</label>
                                    <input type="password" name="senha_cliente" class="form-control">
                                </div>
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