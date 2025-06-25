<?php

function status($valor){ // Converte o valor do status no banco em texto para as listagens de usuário

    if ($valor == 1){
        $st_txt = '<font color="green">Ativo</font>';
    }else{
        $st_txt = '<font color="red">Inativo</font>';
    }

    return $st_txt;

}

function status_entrega($valor){ // Converte o valor do status de entrega no banco em texto para as listagens de entrega

    if ($valor == 0){
        $st_txt = '<font color="red">Pendente</font>';
    }elseif ($valor == 1){
        $st_txt = '<font color="orange">Em andamento</font>';
    }elseif ($valor == 2){
        $st_txt = '<font color="green">Finalizado</font>';
    }else{
        $st_txt = '<font color="gray">Cancelado</font>';
    }

    return $st_txt;

}

function progresso_entrega($valor){ // Define a barra de andamento da entrega para os detalhes

    if ($valor == 0){ // Status - Entrega Pendente

        echo '<div class="pg-bar mb-3">
            <div class="testimonial-item text-center"><img src="../layout/img/ped_pendente.png" height="200px" width="200px"><br><br></div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;"></div>
            </div>
        </div>';

    }elseif ($valor == 1){ // Status - Entrega em Andamento

        echo '<div class="pg-bar mb-3">
            <div class="testimonial-item text-center"><img src="../layout/img/ped_andamento.png" height="200px" width="200px"><br><br></div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
            </div>
        </div>';

    }elseif ($valor == 2) { // Status - Entrega Finalizada

        echo '<div class="pg-bar mb-0">
            <div class="testimonial-item text-center"><img src="../layout/img/ped_finalizado.png" height="200px" width="200px"><br><br></div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>';

    }else { // Status - Entrega Cancelada

        echo '<div class="pg-bar mb-0">
            <div class="testimonial-item text-center"><img src="../layout/img/ped_cancelado.png" height="200px" width="200px"><br><br></div>
        </div>';

    }

}

function conexao(){ // Função de conexão usada internamente em algumas estruturas condicionais

    // Define o servidor e o banco de dados que será utilizado
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'rapidinho_teste';

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn){
        die();
    }

    return $conn;
    
}

function tratar_input($input, $conn){ // Trata e filtra os inputs de usuário (cadastro e edição)

    if (filter_var($input, FILTER_VALIDATE_INT)){ // Se o input for do tipo inteiro, sendo CPF ou Telefone

        if (!preg_match("/^[0-9]{11}+$/", $input)) {
            return -1;
        }else{
            $input = mysqli_real_escape_string($conn, $input);
            return $input;
        }

    }elseif (filter_var($input, FILTER_VALIDATE_EMAIL)){ // Se o input for do tipo E-mail

        return $input;

    }elseif (gettype($input) == 'string'){  // Se o input for do tipo String

        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/", $input) && !preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ0-9,\s]+$/", $input)) {
            return -1;
        }else{
            $input = filter_var($input, FILTER_SANITIZE_STRING);
            $input = mysqli_real_escape_string($conn, $input);
            return $input;
        }

    }else{

        return -1;

    }

}

function tratar_input_solicitacao($input, $conn){ // Trata e filtra os inputs de solicitação e entrega

    if (filter_var($input, FILTER_VALIDATE_INT)){

        if (!preg_match("/^\d+(\.\d{1,2})?$/", $input)) {
            return -1;
        }else{
            $input = mysqli_real_escape_string($conn,$input);
            return $input;
        }

    }elseif (filter_var($input, FILTER_VALIDATE_FLOAT)){

        if (!preg_match("/^\d+(\.\d{1,2})?$/", $input)) {
            return -1;
        }else{
            $input = mysqli_real_escape_string($conn,$input);
            return $input;
        }

    }elseif (gettype($input) == "string"){

        $input = filter_var($input, FILTER_SANITIZE_STRING);
        $input = mysqli_real_escape_string($conn, $input);
        return $input;
        
    }else{

        return -1;
        
    }

}

function tratar_senha($input, $conn){ // Trata, filtra e exige um formato específico de senha (min. 8 caracteres, incluindo letras, números e um caractere especial)

    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $input)){
        return -1;
    }else{
        $input = filter_var($input, FILTER_SANITIZE_STRING);
        $input = mysqli_real_escape_string($conn, $input);
        return $input;
    }

}

function verificar_imagem($foto){

    $verificado = false;
    $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];

    foreach ($extensoesPermitidas as $frmt ){
        if ($extensao == $frmt){
            $verificado = true;
            break;
        }else{
            $verificado = false;
        }
    }

    if ($verificado == true){
        return 1;
    }else{
        return -1;
    }

}

?>