<?php
    include "../perfil/includes/menu.php";

    $con = bancoMysqli();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Unidade</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Unidades</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo/unidades/unidade_edita" role="form">
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
                            <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                    <hr/>

                    <div class="box">
                        <div class="box-header with-border text-center">
                            <h3 class="box-title text-bold">Editar unidades existentes</h3>
                        </div>
                        <form  method="POST" action="?perfil=administrativo/unidades/unidade_edita" role="form">
                            <div class="row">
                                <div class="form-group col-md-12 text-center">
                                    <label for="procurar">Buscar por nome</label>
                                </div>
                                <div class="form-group col-md-offset-3 col-md-6 text-center">
                                    <input type="text" id="un_nome" name="un_nome" class="form-control" width="100px" required>
                                </div>
                                <div class="form-group col-md-offset-3 col-md-6 text-center">
                                    <input type="submit" id="procurar" name="procurar" class="btn btn-info btn-primary" value="Procurar" href="?perfil=administrativo/unidades/unidade_edita">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-12 text-center">
                                    <label for="listar_todas">Listar todas as unidades cadastradas</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4  col-md-offset-4 text-center">
                                    <input type="submit" id="listar_todas" name="listar_todas" class="btn btn-info  btn-primary " value="Listar" href="?perfil=administrativo/unidades/unidade_edita">
                                </div>
                            </div>
                        </form>


                    </div>
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
