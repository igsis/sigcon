<?php

$con = bancoMysqli();

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
                        <h3 class="box-title">Equipamentos</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=pesquisa&sp=pesquisa_equipamento" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="equip_nome">Nome do Equipamento *</label>
                                    <input type="text" id="equip_nome" name="equip_nome" class="form-control" maxlength="60" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade_id">Unidade a qual pertence *</label>
                                    <select class="form-control" id="unidade_id" name="unidade_id">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades")
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a href="?perfil=administrativo&p=pesquisa&sp=pesquisa_equipamento" class="btn btn-default">Voltar a Pesquisa</a>
                                <button type="submit" name="cadastrar" class="btn btn-primary pull-right">Cadastrar</button>
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
