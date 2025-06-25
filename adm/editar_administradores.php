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

        $id_adm = $_POST['id_adm'];

        $nome_adm = $_POST['nome_adm'];
        $email_adm = $_POST['email_adm'];
        $cpf_adm = $_POST['cpf_adm'];

        $nome_adm = tratar_input($nome_adm, $conn);
        $email_adm = tratar_input($email_adm, $conn);
        $cpf_adm = tratar_input($cpf_adm, $conn);

        if ($nome_adm <> -1 && $email_adm <> -1 && $cpf_adm <> -1){

            $sql = "UPDATE tbl_usuario SET nome_user='$nome_adm', email_user='$email_adm', cpf_user='$cpf_adm' WHERE id_user = $id_adm";
            $rodar_sql = mysqli_query($conn, $sql);

            if ($rodar_sql){
                $msg = '<font color="green">Atualizado com sucesso!</font>';
            }else{
                $msg = '<font color="red">Erro ao atualizar administrador!</font>';
            }
            
            $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_usuario WHERE id_user = $id_adm");
            $admin = mysqli_fetch_array($sql_atualizado);

        }else{
            $msg = '<font color="red">Erro ao editar informações! Por favor, revise as informações e tente novamente!</font>';

            $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_adm";
            $result = mysqli_query($conn, $sql);
            $admin = mysqli_fetch_array($result);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){

        $id_adm = $_GET['id_adm'];

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