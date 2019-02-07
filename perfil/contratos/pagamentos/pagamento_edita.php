<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$coon = bancoPDO();

if (isset($_POST['cadastrar']) || isset($_POST['editar'])){
    $idContrato = $_POST['idContrato'];
    $numeroProcesso = $_POST['nProcessoPagamento'] ;
    $notaFiscal = $_POST['notaFiscal'];
    $valor = $_POST['valor'];
    $mesReferencia = $_POST['mesReferencia'];
    $dataRecebimento = $_POST['dataRecebimento'];
    $dataEmcaminhamento = $_POST['dataEncaminhamento'];
    $dataPagamento = $_POST['dataPagamento'];
    $observacao = $_POST['observacao'];

    if(isset($_POST['cadastrar'])){
        $idPessoa = $_POST['pessoaId'];
        $tipoPessoa = $_POST['tipoPessoaId'];

        $sql = "INSERT INTO pagamentos(contrato_id, tipo_pessoa_id, pessoa_id, numero_processo_pagamento, numero_nota_fiscal, valor, mes_referencia, data_recebimento, encaminhado_para_pagamento, data_pagamento, observacao) values ('$idContrato','$tipoPessoa','$idPessoa','$numeroProcesso','$notaFiscal','$valor','$mesReferencia','$dataRecebimento','$dataEmcaminhamento','$dataPagamento','$observacao')";

        if (mysqli_query($con,$sql)){
            $mensagem = mensagem("success","Pagamento cadastrado com sucesso.");
        }else{
            $mensagem = mensagem("danger","Erro ao cadastrar dados.");
        }
    }

    if (isset($_POST['editar'])){

        $sql = "UPDATE pagamentos SET numero_nota_fiscal ='$notaFiscal',valor = '$valor',mes_referencia = '$mesReferencia',data_recebimento = '$dataRecebimento', encaminhado_para_pagamento = '$dataEmcaminhamento', data_pagamento ='$dataPagamento',observacao = '$observacao' WHERE contrato_id='$idContrato'";

        if (mysqli_query($con,$sql)){
            $mensagem = mensagem("success","Alteração realizada com sucesso.");
        }else{
            $mensagem = mensagem("danger","Erro ao alterar os dados.");
        }

    }

}

if (isset($_POST['visualizar'])){
    $idPagamento = $_POST['idPagamento'];

    $pagamento = recuperaDados("pagamentos","id",$idPagamento);

    $idContrato = $pagamento['contrato_id'];
    $numeroProcesso = $pagamento['numero_processo_pagamento'] ;
    $notaFiscal = $pagamento['numero_nota_fiscal'];
    $valor = $pagamento['valor'];
    $mesReferencia = $pagamento['mes_referencia'];
    $dataRecebimento = $pagamento['data_recebimento'];
    $dataEmcaminhamento = $pagamento['encaminhado_para_pagamento'];
    $dataPagamento = $pagamento['data_pagamento'];
    $observacao = $pagamento['observacao'];
}

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
                    <?php
                        if (isset($mensagem)){
                            echo $mensagem;
                        }

                    ?>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos&p=pagamentos&sp=pagamento_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nProcessoPagamento">Número do processo de pagamento *</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="nProcessoPagamento" name="nProcessoPagamento" class="form-control" maxlength="19" placeholder="0000.0000/0000000-0" value="<?= $numeroProcesso?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="notaFiscal">Número da nota fiscal *</label>
                                    <input type="text" id="notaFiscal" class="form-control" maxlength="10" name="notaFiscal" value="<?= $notaFiscal?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="valor">Valor *</label>
                                    <input type="text" id="valor" class="form-control" placeholder="10,00" name="valor" value="<?= $valor?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mesReferencia">Mês de referência *</label>
                                    <input type="date" class="form-control" name="mesReferencia" value="<?= $mesReferencia?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dataRecebimento">Data de recebimento *</label>
                                    <input type="date" name="dataRecebimento" class="form-control" value="<?= $dataRecebimento?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="dataEncaminhamentoPg">Data de encaminhamento para pagamento *</label>
                                    <input type="date" class="form-control" name="dataEncaminhamento" value="<?= $dataEmcaminhamento?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dataPagamento">Data do pagamento *</label>
                                    <input type="date" class="form-control" name="dataPagamento" value="<?= $dataPagamento?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="observacao">Obsercação:</label>
                                    <textarea class="form-control" maxlength="250" id="observacao" name="observacao"><?= $observacao?></textarea>
                                </div>
                            </div>
                        </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a class="btn btn-default" onclick="window.history.back()">Voltar</a>
                                <input type="hidden" name="idContrato" value="<?= $idContrato ?>">
                                <button type="submit" name="editar" class="btn btn-primary pull-right">Atualizar</button>
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
