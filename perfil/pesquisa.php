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
include "pesquisa/".$p.".php";

include "../perfil/menu.php";