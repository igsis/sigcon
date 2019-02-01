<?php
//include para contratos
if(isset($_GET['p']))
{
    $p = $_GET['p'];

    if(isset($_GET['sp']))
    {
        $sp = $_GET['sp'];
        include "contratos/".$p."/".$sp.".php";
    } else {
        include "contratos/" . $p . ".php";
    }
}
else
{
    $p = "inicio";
    include "contratos/".$p.".php";
}

include "contratos/includes/menu.php";