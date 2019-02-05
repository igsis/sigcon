<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn =bancoPDO();

$idContrato = $_POST['idContrato'];
$idPessoa = $_POST['pessoaId'];
$tipoPessoa = $_POST['tipoPessoaId'];

$sql = "SELECT li.numero_processo FROM licitacoes as li INNER JOIN contratos as co on li.id = co.licitacao_id WHERE co.id='$idContrato'";

$numeroProcesso = $conn->query($sql)->fetch()['numero_processo'];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de pagamento</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pagamento</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=pagamentos&sp=pagamento_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nProcessoPagamento">Número do processo de pagamento *</label>
                                    <input type="text" id="nProcessoPagamento" name="nProcessoPagamento" class="form-control" maxlength="19" placeholder="0000.0000/0000000-0" readonly value="<?= $numeroProcesso?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="notaFiscal">Número da nota fiscal *</label>
                                    <input type="text" id="notaFiscal" class="form-control" maxlength="10" name="notaFiscal">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="valor">Valor *</label>
                                    <input type="text" id="valor" class="form-control" placeholder="10,00" name="valor">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mesReferencia">Mês de referência *</label>
                                    <input type="date" class="form-control" name="mesReferencia">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dataRecebimento">Data de recebimento *</label>
                                    <input type="date" name="dataRecebimento" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="dataEncaminhamentoPg">Data de encaminhamento para pagamento *</label>
                                    <input type="date" class="form-control" name="dataEncaminhamento">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dataPagamento">Data do pagamento *</label>
                                    <input type="date" class="form-control" name="dataPagamento">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="observacao">Obsercação:</label>
                                    <textarea class="form-control" maxlength="250" id="observacao" name="observacao"></textarea>
                                </div>
                            </div>
                        </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a class="btn btn-default" onclick="window.history.back()">Voltar</a>
                                <input type="hidden" name="idContrato" value="<?= $idContrato?>">
                                <input type="hidden" name="pessoaId" value="<?= $idPessoa?>">
                                <input type="hidden" name="tipoPessoaId" value="<?= $tipoPessoa?>">
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
