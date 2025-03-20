<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 10){
    
    header('Location: ../forms/index.php');
    exit();

}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_cliente.php");

    $id_user = $_SESSION['id_user'];

    $sql = "SELECT * FROM tbl_usuario WHERE id_user = $id_user";
    $rodar_sql = mysqli_query($conn, $sql);

    $result = mysqli_fetch_assoc($rodar_sql);

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Solicitar Frete</h6>
                    <form method="post" action="calculo_entrega_cli.php">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Endereço de Coleta <font color="red" size="2">*Obrigatório</font></label>
                            <input name="ende_col" type="text" class="form-control mb-3" id="exampleInputPassword1" placeholder="Endereço" value="<?php echo $result['ende_user'] ?>" required>
                            <select name="bairro_col" id="bairro_col" class="form-select mb-3" style="width: 200px;" required>
                                <?php echo '<option>'.$result['bairro_user'].'</option>';?>
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
                            <!--<input name="cep_col" type="number" class="form-control" id="exampleInputPassword1" placeholder="CEP" style="width: 150px;">-->
                            <div id="emailHelp" class="form-text">*Onde o pacote será coletado
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Endereço de Destino <font color="red" size="2">*Obrigatório</font></label>
                            <input name="ende_dest" type="text" class="form-control mb-3" id="exampleInputPassword1" placeholder="Endereço" required>
                            <select name="bairro_dest" id="bairro_dest" class="form-select mb-3" style="width: 200px;" required>
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
                            <input name="nome_dest" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nome do Destinatário" required>
                            <div id="emailHelp" class="form-text">*Fretes realizados apenas dentro do perímetro urbano de Juíz de Fora - MG
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Informações do Pacote</label>
                            <input name="peso_pac" type="number" step="0.01" class="form-control mb-3" id="exampleInputPassword1" placeholder="Peso" style="width: 200px;" required>
                            <input name="larg_pac" type="number" step="0.01" class="form-control mb-3" id="exampleInputPassword1" placeholder="Largura" style="width: 200px;" required>
                            <input name="comp_pac" type="number" step="0.01" class="form-control mb-3" id="exampleInputPassword1" placeholder="Comprimento" style="width: 200px;" required>
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