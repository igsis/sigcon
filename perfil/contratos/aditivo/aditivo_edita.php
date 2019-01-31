<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

$idContrato = $_POST['idContrato'];
$sqlAditivo = "SELECT * FROM aditivos WHERE contrato_id = '$idContrato'";
$queryADT = mysqli_query($con, $sqlAditivo);
$num_rows = mysqli_num_rows($queryADT);

    if ($num_rows > 0) {
        $qtde = $num_rows;
    } else {
        $qtde = 0;
    }


    if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
        $inicio_vigencia = $_POST['inicio_vigencia'];
        $fim_vigencia = $_POST['fim_vigencia'];
        $DOU = $_POST['dou'];
        $valor_mensal = $_POST['valor_mensal'];
        $valor_anual = $_POST['valor_anual'];
        $reajuste = $_POST['valor_reajuste'];


        if (isset($_POST['cadastra'])) {

            $sql = "INSERT INTO aditivos 
                                      (contrato_id,
                                      aditivo_numero,
                                      inicio_vigencia, 
                                      fim_vigencia,
                                      DOU,
                                      valor_mensal,
                                      valor_reajuste,
                                      valor_anual,
                                      publicado)
                              VALUES ('$idContrato', 
                                      '++$qtde', 
                                      '$inicio_vigencia',
                                      '$fim_vigencia',
                                      '$DOU', 
                                      '$valor_mensal',
                                      '$reajuste',
                                      '$valor_anual',
                                      '1')";

            if (mysqli_query($con, $sql)) {
                gravarLog($sql);

                $idAditivo = recuperaUltimo("aditivos");

                $mensagem = mensagem("success", "Aditivo cadastrado com sucesso!");

            } else {
                $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");
            }

        }

        if (isset($_POST['edita'])) {

            $sql = "UPDATE aditivos SET 
                                      contrato_id = '$idContrato',
                                      aditivo_numero = '$qtde',
                                      inicio_vigencia = '$inicio_vigencia', 
                                      fim_vigencia = '$fim_vigencia',
                                      DOU = '$DOU',
                                      valor_mensal = '$valor_mensal',
                                      valor_reajuste = '$reajuste',
                                      valor_anual = '$valor_anual'
                                      WHERE id = '$idAditivo'";

            if (mysqli_query($con, $sql)) {
                gravarLog($sql);

                $mensagem = mensagem("success", "Atualizado com sucesso!");

            } else {
                $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
            }
        }
    }

    $aditivos = recuperaDados("aditivos", "id", $idAditivo);


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Aditivo</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Aditivo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos/contrato_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Vigência início</label>
                                    <input type="date" name="vigencia_inicio" id='vigencia_inicio' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Vigência fim</label>
                                    <input type="date" name="vigencia_fim" id='vigencia_fim' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>DOU</label>
                                    <input type="date" name="dou" id='dou' class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="valor_mensal">Valor mensal</label>
                                    <input type="text" id="valor_mensal" name="valor_mensal" class="form-control" placeholder="Valor em formato decimal *">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" placeholder="Valor em formato decimal *">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_reajuste">Valor do reajuste</label>
                                    <input type="text" id="valor_reajuste" name="valor_reajuste" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
                            </div>
                    </form>
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
