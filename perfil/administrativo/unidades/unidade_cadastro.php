<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Unidade</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Unidades</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=unidades&sp=unidade_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="un_nome">Nome da Unidade *</label>
                                    <input type="text" id="un_nome" name="un_nome" class="form-control" maxlength="60" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="un_sigla">Sigla *</label>
                                    <input type="text" id="un_sigla" name="un_sigla" class="form-control" maxlength="10" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="un_orcamentaria">Unidade Orçamentária *</label>
                                    <input type="text" id="un_orcamentaria" name="un_orcamentaria" class="form-control"  data-mask="00.00" required>
                                </div>
                            </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="cadastra" class="btn btn-primary pull-right">Cadastrar</button>
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
