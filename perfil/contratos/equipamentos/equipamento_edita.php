<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

if(isset($_POST['cadastra'])){
    $equipamentoId = $_POST['equipamento'];
    $idContrato = $_POST['idContrato'];

    $sql = "INSERT INTO contrato_equipamento (contrato_id, equipamento_id) VALUES ('$idContrato', '$equipamentoId')";

    if(mysqli_query($con, $sql)){

        gravarLog($sql);

        $idContratoEquipamento = recuperaUltimo('contrato_equipamento');

        $mensagem = mensagem("success", "Gravado com sucesso!");

    } else {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
    }
}

    if(isset($_POST['altera'])){
        $idContratoEquipamento = $_POST['idContratoEquipamento'];
    }



   if (isset($_POST['edita'])){

    $equipamentoId = $_POST['equipamento'];
    $idContratoEquipamento = $_POST['idContratoEquipamento'];

    $sql = "UPDATE contrato_equipamento SET 
                                      equipamento_id = '$equipamentoId'
                                      WHERE id = '$idContratoEquipamento'";

    if (mysqli_query($con, $sql)) {

        gravarLog($sql);

        $mensagem = mensagem("success", "Atualizado com sucesso!");

    } else {
        $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
    }

}

$contratoEquipamento = recuperaDados('contrato_equipamento', 'id', $idContratoEquipamento);
$equipamento = recuperaDados('equipamentos', 'id', $contratoEquipamento['equipamento_id']);
$contrato = recuperaDados('contratos', 'id', $contratoEquipamento['contrato_id']);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Equipamento</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">

                        </h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos&p=equipamentos&sp=equipamento_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="equipamento">Equipamento: </label>
                                    <select name="equipamento" id="equipamento" class="form-control">
                                        <?php
                                            geraOpcaoEquipamento($contrato['unidade_id'], $equipamento['id']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="idContratoEquipamento" value="<?= $idContratoEquipamento ?>">
                            <button type="submit" name="edita" class="btn btn-primary pull-right">Salvar</button>
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

<script>

</script>
