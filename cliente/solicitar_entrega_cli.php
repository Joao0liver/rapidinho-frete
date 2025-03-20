<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null){
    
    header('Location: ../index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Solicitar Frete</h6>
                    <form method="post" action="calculo_entrega_cli.php">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Endereço de Coleta <font color="red" size="2">*Obrigatório</font></label>
                            <input name="ende_col" type="text" class="form-control" id="exampleInputPassword1" placeholder="Endereço" style="width: 700px;" required>
                            <input name="bairro_col" type="text" class="form-control" id="exampleInputPassword1" placeholder="Bairro" style="width: 250px;" required>
                            <input name="cep_col" type="number" class="form-control" id="exampleInputPassword1" placeholder="CEP" style="width: 150px;">
                            <div id="emailHelp" class="form-text">*Onde o pacote será coletado
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Endereço de Destino <font color="red" size="2">*Obrigatório</font></label>
                            <input name="ende_dest" type="text" class="form-control" id="exampleInputPassword1" placeholder="Endereço" style="width: 700px;" required>
                            <input name="bairro_dest" type="text" class="form-control" id="exampleInputPassword1" placeholder="Bairro" style="width: 250px;" required>
                            <input name="cep_dest" type="number" class="form-control" id="exampleInputPassword1" placeholder="CEP" style="width: 150px;">
                            <input name="nome_dest" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nome do Destinatário" style="width: 500px;" required>
                            <div id="emailHelp" class="form-text">*Fretes realizados apenas dentro do perímetro urbano de Juíz de Fora - MG
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Informações do Pacote</label>
                            <input name="peso_pac" type="number" step="0.01" class="form-control" id="exampleInputPassword1" placeholder="Peso" style="width: 200px;" required>
                            <input name="larg_pac" type="number" step="0.01" class="form-control" id="exampleInputPassword1" placeholder="Largura" style="width: 200px;" required>
                            <input name="comp_pac" type="number" step="0.01" class="form-control" id="exampleInputPassword1" placeholder="Comprimento" style="width: 200px;" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Calcular</button>
                    </form>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>