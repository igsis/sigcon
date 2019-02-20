<?php

$con = bancoMysqli();
$conn = bancoPDO();

$idContrato = $_POST['idContrato'];
$idPessoa = $_POST['pessoaId'];
$tipoPessoa = $_POST['tipoPessoaId'];

$idLicitacao = recuperaDados("contratos", "id", $idContrato)['licitacao_id'];
$licitacao = recuperaDados("licitacoes", "id", $idLicitacao);

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
                    <form method="POST" action="?perfil=contratos&p=pagamentos&sp=pagamento_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nProcessoPagamento">Número do processo de pagamento</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="nProcessoPagamento" name="nProcessoPagamento" class="form-control" readonly value="<?= $licitacao['numero_processo'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="notaFiscal">Número da nota fiscal *</label>
                                    <input type="text" id="notaFiscal" class="form-control" maxlength="10" name="notaFiscal" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="valor">Valor *</label>
                                    <input type="text" id="valor" class="form-control" placeholder="10,00" name="valor" onKeyPress="return(moeda(this,'.',',',event))">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mesReferencia">Mês de referência *</label>
                                    <input type="date" class="form-control" name="mesReferencia" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dataRecebimento">Data de recebimento *</label>
                                    <input type="date" name="dataRecebimento" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="dataEncaminhamentoPg">Data de encaminhamento para pagamento *</label>
                                    <input type="date" class="form-control" name="dataEncaminhamento" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dataPagamento">Data do pagamento *</label>
                                    <input type="date" class="form-control" name="dataPagamento" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label for="observacao">Observação:</label>
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

    <script>
        function moeda(a, e, r, t) {
            let n = ""
                , h = j = 0
                , u = tamanho2 = 0
                , l = ajd2 = ""
                , o = window.Event ? t.which : t.keyCode;
            if (13 == o || 8 == o)
                return !0;
            if (n = String.fromCharCode(o),
            -1 == "0123456789".indexOf(n))
                return !1;
            for (u = a.value.length,
                     h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
                ;
            for (l = ""; h < u; h++)
                -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
            if (l += n,
            0 == (u = l.length) && (a.value = ""),
            1 == u && (a.value = "0" + r + "0" + l),
            2 == u && (a.value = "0" + r + l),
            u > 2) {
                for (ajd2 = "",
                         j = 0,
                         h = u - 3; h >= 0; h--)
                    3 == j && (ajd2 += e,
                        j = 0),
                        ajd2 += l.charAt(h),
                        j++;
                for (a.value = "",
                         tamanho2 = ajd2.length,
                         h = tamanho2 - 1; h >= 0; h--)
                    a.value += ajd2.charAt(h);
                a.value += r + l.substr(u - 2, u)
            }
            return !1
        }
    </script>
</div>
