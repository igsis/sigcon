<?php
require_once 'funcoesConecta.php';
// require "../funcoes/";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

$conn = bancoPDO();

if(isset($_GET['unidade_id'])){
    $id = $_GET['unidade_id'];

    $sql = "SELECT id, nome FROM equipamentos WHERE unidade_id = :unidade order by nome";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':unidade', $id);
    $stmt->execute();
    $res = $stmt->fetchAll();

    $equipamentos =  json_encode($res);

    print_r($equipamentos);

}
