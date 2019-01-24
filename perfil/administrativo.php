<?php
//include para contratos
if(isset($_GET['p']))
{
    $p = $_GET['p'];
}
else
{
    $p = "inicio";
}
include "administrativo/".$p.".php";
include "administrativo/includes/menu.php";