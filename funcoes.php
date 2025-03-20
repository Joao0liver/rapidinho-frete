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
        $st_txt = '<font color="yellow">Em andamento</font>';
    }else{
        $st_txt = '<font color="green">Finalizado</font>';
    }

    return $st_txt;

}

?>