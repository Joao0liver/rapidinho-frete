<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 10){
    
    header('Location: ../forms/index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $msg = "";
    $aviso = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){ // Dados após o usuário editar alguma informação

        // Coleta os novos dados do formulário
        $id_ent = $_POST['id_ent'];
        $status_ent = $_POST['status_ent'];

        $ende_orig = $_POST['ende_orig'];
        $bairro_orig = $_POST['bairro_orig'];

        $ende_dest = $_POST['ende_dest'];
        $bairro_dest = $_POST['bairro_dest'];

        $peso_pac = $_POST['peso_pac'];
        $larg_pac = $_POST['larg_pac'];
        $comp_pac = $_POST['comp_pac'];

        // Concatena o endereço com o bairro separando-os com "|"
        $ende_inicio = $ende_orig.' | '.$bairro_orig;
        $ende_fim = $ende_dest.' | '.$bairro_dest;

        // Trata e filtra as informações antes de entrar no banco
        $ende_inicio = tratar_input_solicitacao($ende_inicio, $conn);
        $ende_fim = tratar_input_solicitacao($ende_fim, $conn);
        $peso_pac = tratar_input_solicitacao($peso_pac, $conn);
        $larg_pac = tratar_input_solicitacao($larg_pac, $conn);
        $comp_pac = tratar_input_solicitacao($comp_pac, $conn);

        // Só permite a atualização se o status for pendente
        if ($status_ent == 0){

            if ($ende_inicio <> -1 && $ende_fim <> -1 && $peso_pac <> -1 && $larg_pac <> -1 && $comp_pac <> -1){ // Só permite a atualização se os dados passaram no tratamento

                $sql = "UPDATE tbl_entrega SET ende_orig='$ende_inicio', ende_dest='$ende_fim', peso_pac=$peso_pac, larg_pac=$larg_pac, comp_pac=$comp_pac WHERE id_ent = $id_ent";
                $rodar_sql = mysqli_query($conn, $sql);

                // Pega os dados atualizados para preencher o form novamente
                $sql_atualizado = mysqli_query($conn, "SELECT * FROM tbl_entrega WHERE id_ent = $id_ent");
                $registros_entrega = mysqli_fetch_array($sql_atualizado);

                // Divide o endereço em um array com "nome da rua" e "bairro" para preecher o form novamente
                $ende_orig = explode('|', $registros_entrega['ende_orig']);
                $ende_dest = explode('|', $registros_entrega['ende_dest']);

                $nome_mtboy = '<font color="orange">Nenhum motoboy aceitou a solicitação ainda!</font>';
                $msg = '<font color="red">Pendente</font>';

            }else{
                $aviso = '<font color="red">Falha ao atualizar a solicitação! Por favor, revise as informações e tente novamente!</font> <br>';
            }

        }else{
            $aviso = '<font color="red">Falha ao atualizar a solicitação! Parece que ela não está mais pendente!</font> <br>';
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){ // Dados quando o usuário clica na edição presente na listagem

        // Obter Registros/Informações de Entrega

        $id_ent = $_GET['id_ent'];

        $sql = "SELECT * FROM tbl_entrega WHERE id_ent = $id_ent";
        $rodar_sql = mysqli_query($conn, $sql);

        $registros_entrega = mysqli_fetch_assoc($rodar_sql);

        if ($registros_entrega['status_ent'] == 0) {

            $msg = '<font color="red">Pendente</font>';

        }elseif ($registros_entrega['status_ent'] == 1) {

            $msg = '<font color="orange">Em Andamento</font>';

        }elseif ($registros_entrega['status_ent'] == 2) {

            $msg = '<font color="green">Finalizado</font>';

        }else{

            $msg = '<font color="gray">Cancelado</font>';

        }

        // Retira o separador "|" para colocar o "endereço" no input de endereço e o "bairro" no select de bairro
        $ende_orig = explode('|', $registros_entrega['ende_orig']);
        $ende_dest = explode('|', $registros_entrega['ende_dest']);

        // Verificar se um motoboy já está atribuido ao pedido

        if ($registros_entrega['id_mtboy'] == null){

            $nome_mtboy = '<font color="orange">Nenhum motoboy aceitou a solicitação ainda!</font>';

        }else {

            // Obter Informações do Motoboy

            $id_mtboy = $registros_entrega['id_mtboy'];

            $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_mtboy";
            $rodar_sql = mysqli_query($conn, $sql);

            $registros_mtboy = mysqli_fetch_assoc($rodar_sql);

            $nome_mtboy = $registros_mtboy['nome_user'];
            $foto_mtboy = $registros_mtboy['foto_mtboy'];

        }

    }   


?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h5 class="mb-4">Detalhes do Pedido</h5>
                    <dl class="row mb-0">
                        <?php

                            if ($registros_entrega['id_mtboy'] == null){

                                echo "";

                            }else {

                                echo '<div class="testimonial-item text-center">
                                    <img class="img-fluid rounded-circle mx-auto mb-4" src="../upload/img_mtboy/'.$registros_mtboy["foto_mtboy"].'" alt="Sem foto" style="width: 120px; height: 120px;">
                                </div>';

                            }

                        ?>

                            <form method="post" action="detalhes_solicitacao_cliente.php">
                                <input type="hidden" name="id_ent" value="<?php echo $registros_entrega['id_ent'] ?>">
                                <input type="hidden" name="status_ent" value="<?php echo $registros_entrega['status_ent'] ?>">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Motoboy:</strong> <?php echo $nome_mtboy ?></label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>ID do Pedido:</strong> <?php echo $registros_entrega['id_ent']; ?></label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Endereço de Origem</strong></label>
                                    <input type="text" name="ende_orig" value="<?php echo $ende_orig[0]; ?>" class="form-control" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                    <select name="bairro_orig" id="bairro_col" class="form-select mb-3" style="width: 200px;" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                        <?php echo '<option>'.$ende_orig[1].'</option>';?>
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
                                    <div id="emailHelp" class="form-text">*Onde o pacote será coletado
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Endereço de Entrega</strong></label>
                                    <input type="text" name="ende_dest" value="<?php echo $ende_dest[0]; ?>" class="form-control" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                    <select name="bairro_dest" id="bairro_col" class="form-select mb-3" style="width: 200px;" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                        <?php echo '<option>'.$ende_dest[1].'</option>';?>
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
                                    <div id="emailHelp" class="form-text">*Fretes realizados apenas dentro do perímetro urbano de Juíz de Fora - MG
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Características do Pacote</strong></label>
                                    <input type="number" pattern="[0-9]{2}" step="0.01" name="peso_pac" style="width: 200px;" value="<?php echo $registros_entrega['peso_pac']; ?>" class="form-control" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                    <input type="number" pattern="[0-9]{2}" step="0.01" name="larg_pac" style="width: 200px;" value="<?php echo $registros_entrega['larg_pac']; ?>" class="form-control" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                    <input type="number" pattern="[0-9]{2}" step="0.01" name="comp_pac" style="width: 200px;" value="<?php echo $registros_entrega['comp_pac']; ?>" class="form-control" <?php if ($registros_entrega['status_ent'] <> 0){ echo "disabled"; }; ?>>
                                    <div id="emailHelp" class="form-text">*Limite de peso do pacote = 12kg
                                    </div>
                                    <?php echo $aviso; ?>
                                </div>
                                <?php

                                    if ($registros_entrega['status_ent'] == 0){

                                        echo '<button type="submit" class="btn btn-primary">Atualizar</button>';

                                    }

                                ?>
                            </form>
                    </dl>
                    <div class="mb-3">
                        <?php echo '<br>'.$msg; ?>
                    </div>
                    <?php

                       progresso_entrega($registros_entrega['status_ent']);

                    ?>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>