<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();

if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idEquipamento = $_POST['idEquipamento'] ?? NULL;
    $equip_nome = $_POST['equip_nome'];
    $unidade_id = $_POST['unidade_id'];

    if (isset($_POST['cadastra'])) {

        $sql = "INSERT INTO equipamentos (nome,  
                                          unidade_id) 
                                  VALUES ('$equip_nome',
                                          '$unidade_id')";

        if (mysqli_query($con, $sql)) {

            $idEquipamento = recuperaUltimo("equipamentos");
            $mensagem = mensagem("success", "Equipamento cadastrado com sucesso!");

        } else {
            $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
        }
    }

    if (isset($_POST['edita'])) {

        $sql = "UPDATE equipamentos SET
                                    nome = '$equip_nome', 
                                    unidade_id = '$unidade_id'
                              WHERE id = '$idEquipamento'";

        if (mysqli_query($con, $sql)) {

            $mensagem = mensagem("successs", "Dados atualizados com sucesso!");

        } else {
            $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
        }
    }
}


$equipamento = recuperaDados("equipamentos", "id", $idEquipamento);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Equipamento</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= "Nome do equipamento: " . $equipamento['nome'];  ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=equipamentos&sp=equipamento_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="equip_nome">Nome do Equipamento *</label>
                                    <input type="text" id="equip_nome" name="equip_nome" class="form-control" maxlength="60" value="<?= $equipamento['nome'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade">Unidade a qual pertence *</label>
                                    <select class="form-control" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades", $equipamento['unidade_id']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="hidden" name="idEquipamento" value="<?= $idEquipamento ?>">
                                <button type="submit" name="edita" class="btn btn-primary pull-right">Editar</button>
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
