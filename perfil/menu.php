<?php
switch ($_SESSION['nivelAcesso'])
{
    case 1:
    include "../perfil/administrativo/includes/menu.php";
    break;

    case 2:
    include "../perfil/contratos/includes/menu.php";
    break;

    case 3:
    include "../perfil/pesquisa/includes/menu.php";
    break;

    default:
    include "../perfil/pesquisa/includes/menu.php";
    break;
}