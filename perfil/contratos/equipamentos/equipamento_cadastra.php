<?php

$idContrato = $_POST['idContrato'];

$contrato = recuperaDados('contratos', 'id', $idContrato);
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
                            Cadastrar Equipamento
                        </h3>
                    </div>
                </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos&p=equipamentos&sp=equipamento_edita" role="form">
                            <div class="form-group col-md-6">
                                <label for="equipamento">Equipamento: </label>
                                <select name="equipamento" id="equipamento" class="form-control">
                                    <?php
                                    geraOpcaoEquipamento($contrato['unidade_id'], '1');
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="idContrato" value="<?= $idContrato ?>">
                            <button type="submit" name="cadastra" class="btn btn-primary pull-right">Gravar</button>
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
