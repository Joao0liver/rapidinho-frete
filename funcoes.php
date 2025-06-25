<?php

function status($valor){

    if ($valor == 1){
        $st_txt = '<font color="green">Ativo</font>';
    }else{
        $st_txt = '<font color="red">Inativo</font>';
    }

    return $st_txt;

}

function status_entrega($valor){

    if ($valor == 0){
        $st_txt = '<font color="red">Pendente</font>';
    }elseif ($valor == 1){
        $st_txt = '<font color="orange">Em andamento</font>';
    }else{
        $st_txt = '<font color="green">Finalizado</font>';
    }

    return $st_txt;

}

function conexao(){

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

function tratar_input($input, $conn){

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

        if (!preg_match("/^[A-Za-z\s]+$/", $input)) {
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

function tratar_input_solicitacao($input, $conn){

    if (filter_var($input, FILTER_VALIDATE_INT)){

        if (!preg_match("/^[0-9]{2}+$/", $input)) {
            return -1;
        }else{
            $input = mysqli_real_escape_string($conn,$input);
            return $input;
        }

    }elseif (filter_var($input, FILTER_VALIDATE_FLOAT)){

        if (!preg_match("/^[0-9]{3}+$/", $input)) {
            return -1;
        }

    }

}

?>