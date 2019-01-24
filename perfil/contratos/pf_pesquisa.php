<?php

$con = bancoMysqli();
include "includes/menu.php";

if (isset($_POST['idLicitacao'])) {
    $idLicitacao = $_POST['idLicitacao'];
}

$exibir = ' ';
$resultado = "<td></td>";

if (isset($_POST['procurar'])){

    $cpf = $_POST['procurar'] ?? NULL;

    if ($cpf != NULL ) {

        $queryCPF = "SELECT id, nome, cpf, email
                         FROM pessoas_fisicas
                         WHERE cpf = '$cpf'";

        if ($result = mysqli_query($con,$queryCPF)) {

            $resultCPF = mysqli_num_rows($result);

            if ($resultCPF > 0){

                $exibir = true;
                $resultado = "";

                foreach($result as $pessoa){

                    $resultado .= "<tr>";
                    $resultado .= "<td>".$pessoa['nome']."</td>";
                    $resultado .= "<td>".$pessoa['cpf']."</td>";
                    $resultado .= "<td>".$pessoa['email']."</td>";
                    $resultado .= "<td>
                                     <form action='?perfil=contratos/contrato_cadastro' method='post'>
                                        <input type='hidden' name='idPf' value='".$pessoa['id']."'>
                                        <input type='hidden' name='idLicitacao' value='".$idLicitacao."'>
                                        <input type='submit' name='carregar' class='btn btn-primary' name='selecionar' value='Selecionar'>
                                     </form>
                               </td>";
                    $resultado .= "</tr>";
                }
            }else {

                $exibir = false;
                $resultado = "<td colspan='4'>
                        <span style='margin: 50% 40%;'>Sem resultados</span>
                      </td>
                      <td>
                        <form method='post' action='?perfil=contratos/pf_cadastro'>
                            <input type='hidden' name='documentacao' value='$cpf'>
                            <button class=\"btn btn-primary\" name='adicionar' type='submit'>
                                <i class=\"glyphicon glyphicon-plus\">        
                                </i>Adicionar
                            </button>
                        </form>
                      </td>";

            }
        }
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Contratos</h2>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Procurar pessoa fisica</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="?perfil=contratos/pf_pesquisa" method="post">
                            <div class="form-group">
                                <label for="procurar">Pesquisar por CPF:</label>
                                <div class="input-group">
                                    <input type="text" data-mask="000.000.000-00" class="form-control" minlength=14 name="procurar" id="cpf" value="<?= isset($cpf) ? $cpf : NULL?>" >
                                    <input type='hidden' name='idLicitacao' value="<?= $idLicitacao ?>">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Procurar</button>
                                    </span>
                                </div>
                            </div>
                        </form>

                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <!-- Table -->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>E-mail</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($exibir){
                                    echo $resultado;
                                }elseif(!$exibir){
                                    echo $resultado;
                                }else{
                                    echo $resultado;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END ACCORDION & CAROUSEL-->
    </section>
    <!-- /.content -->
</div>
