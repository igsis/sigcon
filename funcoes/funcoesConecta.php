<?php
// Conexão de Banco MySQLi
function bancoMysqli()
{
	$servidor = 'localhost';
	$usuario = 'root';
	$senha = '';
	$banco = 'sigcon';
	$con = mysqli_connect($servidor,$usuario,$senha,$banco);
	mysqli_set_charset($con,"utf8");
	return $con;
}