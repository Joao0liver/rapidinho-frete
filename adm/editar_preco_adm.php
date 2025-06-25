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

        $id_dist = $_POST['id_dist'];

        $valor = $_POST['valor'];

        $valor = tratar_input_solicitacao($valor, $conn);

        if ($valor <> -1){

            $sql = "UPDATE tbl_distancia SET valor=$valor WHERE id_dist = $id_dist";
            $rodar_sql = mysqli_query($conn, $sql);

            if ($rodar_sql){
                $msg = '<font color="green">Atualizado com sucesso!</font>';
            }else{
                $msg = '<font color="red">Erro ao atualizar preço!</font>';
            }

        }else{
            $msg = '<font color="red">Erro ao atualizar preço!</font>';
        }
        
        $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_distancia WHERE id_dist = $id_dist");
        $distancia = mysqli_fetch_array($sql_atualizado);

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){

        $id_dist = $_GET['id_dist'];

        $sql = "SELECT * FROM tbl_distancia WHERE id_dist = $id_dist";
        $result = mysqli_query($conn, $sql);
        $distancia = mysqli_fetch_array($result);

    }

?>

<!-- Blank Start -->
                    <div class="container-fluid pt-4 px-4"> 
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Editar cliente</h6>
                            <form method="post" action="editar_preco_adm.php">
                                <input type="hidden" name="id_dist" value="<?php echo $distancia['id_dist'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Bairro</label>
                                    <input type="text" pattern="[A-Za-z\s]+" name="bairro" style="width: 700px;" value="<?php echo $distancia['bairro'] ?>" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Valor</label>
                                    <input type="number" pattern="\d+(\.\d{1,2})?" step="0.01" name="valor" style="width: 500px;" value="<?php echo $distancia['valor'] ?>" class="form-control">
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