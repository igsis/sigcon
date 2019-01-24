<?php
include "includes/menu.php";

$con = bancoMysqli();

    if (isset($_POST['idLicitacao'])) {
        $idLicitacao = $_POST['idLicitacao'];
    }

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Contrato</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Escolha um tipo de pessoa</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-offset-3 col-md-3">
                                <form method="POST" action="?perfil=contratos/pf_pesquisa" role="form">
                                    <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
                                    <button type="submit" name="pessoa_fisica" class="btn btn-block btn-primary btn-lg">Pessoa Física</button>
                                </form>
                            </div>
                            <div class="form-group col-md-3">
                                <form method="POST" action="?perfil=contratos/pj_pesquisa" role="form">
                                    <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
                                    <button type="submit" name="pesquisar_pessoa_juridica" class="btn btn-block btn-primary btn-lg">Pessoa Jurídica</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>