<?php

include_once("../conexao.php");
include_once("../layout/header_adm.php");

$msg = '<br>';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_mtboy = $_POST['id_mtboy'];

    $nome_mtboy = $_POST['nome_mtboy'];
    $email_mtboy = $_POST['email_mtboy'];
    $cpf_mtboy = $_POST['cpf_mtboy'];
    $tel_mtboy = $_POST['tel_mtboy'];
    $placa_mtboy = $_POST['placa_mtboy'];

    $sql = "UPDATE tbl_motoboy SET nome_mtboy='$nome_mtboy', email_mtboy='$email_mtboy', cpf_mtboy='$cpf_mtboy', tel_mtboy='$tel_mtboy', placa_mtboy='$placa_mtboy' WHERE id_mtboy = $id_mtboy";
    $rodar_sql = mysqli_query($conn, $sql);

    if ($rodar_sql){
        $msg = '<font color="green">Atualizado com sucesso!</font>';
    }else{
        $msg = '<font color="red">Erro ao atualizar motoboy!</font>';
    }
    
    $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_motoboy WHERE id_mtboy = $id_mtboy");
    $motoboy = mysqli_fetch_array($sql_atualizado);

}

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    $id_mtboy = $_GET['id_mtboy'];

    $sql = "SELECT * FROM tbl_motoboy WHERE id_mtboy = $id_mtboy";
    $result = mysqli_query($conn, $sql);
    $motoboy = mysqli_fetch_array($result);

}

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Editar Motoboy</h6>
                            <form method="post" action="editar_mtboy_adm.php">
                                <input type="hidden" name="id_mtboy" value="<?php echo $motoboy['id_mtboy'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="nome_mtboy" style="width: 700px;" value="<?php echo $motoboy['nome_mtboy'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_mtboy" style="width: 500px;" value="<?php echo $motoboy['email_mtboy'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="number" name="cpf_mtboy" style="width: 200px;" value="<?php echo $motoboy['cpf_mtboy'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" name="tel_mtboy" style="width: 200px;" value="<?php echo $motoboy['tel_mtboy'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Placa da Moto</label>
                                    <input type="text" name="placa_mtboy" style="width: 150px;" value="<?php echo $motoboy['placa_mtboy'] ?>" class="form-control">
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

?>