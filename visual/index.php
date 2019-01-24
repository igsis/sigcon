<?php
//Imprime erros com o banco
@ini_set('display_errors', '1');
error_reporting(E_ALL);

//define a session como 60 min
session_cache_expire(60);

//carrega as funcoes gerais
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

//carrega o cabeçalho
require "cabecalho.php";

// carrega o perfil
$nivelAcesso = $_SESSION['nivelAcesso'];

if($nivelAcesso == 1){
    if(isset($_GET['perfil'])){
        include "../perfil/".$_GET['perfil'].".php";
    }else{
        include "../perfil/administrativo.php";
    }
}
elseif ($nivelAcesso == 2){
    if(isset($_GET['perfil'])){
        include "../perfil/".$_GET['perfil'].".php";
    }else{
        include "../perfil/contratos.php";
    }
}
else{
    if(isset($_GET['perfil'])){
        include "../perfil/".$_GET['perfil'].".php";
    }else{
        include "../perfil/pesquisa.php";
    }
}


//carrega o rodapé
include "rodape.php";