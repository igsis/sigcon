<?php
//include para contratos
if(isset($_GET['p']))
{
    if(isset($_GET['sp']))
    {
        $p = $_GET['p'];
        $sp = $_GET['sp'];
        include "administrativo/".$p."/".$sp.".php";
    }
}
else
{
    $p = "inicio";
    include "administrativo/".$p.".php";
}

include "administrativo/includes/menu.php";