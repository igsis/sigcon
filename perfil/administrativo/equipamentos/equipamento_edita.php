<?php
$con = bancoMysqli();
$idEquipamento = $_POST['idEquipamento'] ?? NULL;

if (isset($_POST['editar'])) {
    $idEquipamento = $_POST['idEquipamento'] ?? NULL;
    $equip_nome = $_POST['equip_nome'];
    $unidade_id = $_POST['unidade_id'];
    
    $sql = "UPDATE equipamentos SET nome = '$equip_nome', unidade_id = '$unidade_id' WHERE id = '$idEquipamento'";

    if ($con->query($sql))
    {
        gravarLog($sql);
        $mensagem = mensagem("success", "Equipamento atualizado com sucesso!");
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
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
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
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
                                    <select class="form-control" id="unidade_id" name="unidade_id">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades", $equipamento['unidade_id']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a href="?perfil=administrativo&p=pesquisa&sp=pesquisa_equipamento" class="btn btn-default">Voltar a Pesquisa</a>
                                <input type="hidden" name="idEquipamento" value="<?= $idEquipamento ?>">
                                <button type="submit" name="editar" class="btn btn-primary pull-right">Editar</button>
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
