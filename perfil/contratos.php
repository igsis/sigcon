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
include "contratos/".$p.".php";
include "contratos/includes/menu.php";