<?php
//include para contratos
if(isset($_GET['p']))
{
    if(isset($_GET['sp']))
    {
        $p = $_GET['p'];
        $sp = $_GET['sp'];
        include "contratos/".$p."/".$sp.".php";
    }
}
else
{
    $p = "inicio";
    include "contratos/".$p.".php";
}

include "contratos/includes/menu.php";