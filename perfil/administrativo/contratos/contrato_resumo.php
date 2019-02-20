<?php

$con = bancoMysqli();
$conn = bancoPDO();

$url = 'http://'.$_SERVER['HTTP_HOST'].'/sigcon/funcoes/api_equipamentos.php';

if(isset($_POST['carregar'])){
    $idContrato = $_POST['idContrato'];
    $contrato = recuperaDados('contratos', 'id', $idContrato);
    $idPessoa = $contrato['pessoa_id'];
    $tipoPessoa = $contrato['tipo_pessoa_id'];

    $idLicitacao = $contrato['licitacao_id'];
    $licitacao = recuperaDados('licitacoes', 'id', $idLicitacao);

    if ($tipoPessoa == 1) {
        $pessoa_fisica = recuperaDados("pessoa_fisicas", "id", $idPessoa)['cpf'];

    } else {
        $pessoa_juridica = recuperaDados("pessoa_juridicas", "id", $idPessoa)['cnpj'];
    }

}

$pessoa_fisica = recuperaDados("pessoa_fisicas", "id", $idPessoa)['cpf'];
$pessoa_juridica = recuperaDados("pessoa_juridicas", "id", $idPessoa)['cnpj'];

$contrato = recuperaDados("contratos", "id", $idContrato);
$idFiscal = $contrato['fiscal_id'];
$idSuplente = $contrato['suplente_id'];

$fiscal = recuperaDados("fiscais", "id", $idFiscal);
$suplente = recuperaDados("suplentes", "id", $idSuplente);

$informacoes = recuperaDados("informacoes_do_contrato", "contrato_id", $idContrato);

$unidade = recuperaDados("unidades", "id", $contrato['unidade_id'])['nome'];
$status = recuperaDados("contrato_status", "id", $contrato['contrato_status_id'])['status'];

$sqlEquips = "SELECT
          ce.id,
          equipamento.nome,
          unidade.nome AS unidade_nome
        FROM contrato_equipamento AS ce
          INNER JOIN equipamentos equipamento ON ce.equipamento_id = equipamento.id
          INNER JOIN unidades unidade ON equipamento.unidade_id = unidade.id
        WHERE ce.publicado = 1 AND ce.contrato_id = '$idContrato'";
$queryEquips = mysqli_query($con, $sqlEquips);
$numEquips = mysqli_num_rows($queryEquips);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Informações do Contrato</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?= "Número do processo administrativo: " . $licitacao['numero_processo']?>
                        </h3>
                    </div>

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="num_processo">Número do processo administrativo</label>
                                <input readonly type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" maxlength="20" value="<?= $licitacao['numero_processo'];  ?>" readonly>
                            </div>
                            <?php

                            if ($tipoPessoa == 1) {

                                ?>

                                <div class="form-group col-md-3">
                                    <label for="cpf">CPF: </label>
                                    <input readonly type="text" data-mask="000.000.000-00" id="cpf" name="cpf"
                                           class="form-control" value="<?= $pessoa_fisica ?>" readonly>
                                </div>

                                <?php

                            }elseif ($tipoPessoa == 2) {

                                ?>

                                <div class="form-group col-md-3">
                                    <label for="cnpj">CNPJ: </label>
                                    <input readonly type="text" data-mask="00.000.000/0000-00" id="cnpj" name="cnpj"
                                           class="form-control" value="<?= $pessoa_juridica ?>" readonly>
                                </div>

                                <?php
                            }

                            ?>
                            <div class="form-group col-md-6">
                                <label for="objeto">Objeto *</label>
                                <input readonly type="text" id="objeto" name="objeto" class="form-control" maxlength="100" value="<?= $licitacao['objeto']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="termo_contrato">Termo de contrato *</label>
                                <input readonly type="text" id="termo_contrato" name="termo_contrato" class="form-control" maxlength="100" value="<?= $contrato['termo_contrato'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tipo_servico">Tipo de serviço *</label>
                                <input readonly type="text" id="tipo_servico" name="tipo_servico" class="form-control" maxlength="80" value="<?= $contrato['tipo_servico'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="unidade">Unidade *</label>
                                <input readonly class="form-control" type="text" name="unidade" id="unidade" value="<?=$unidade?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="fiscal">Fiscal</label>
                                <input readonly type="text" id="fiscal" name="fiscal" class="form-control" maxlength="60" value="<?= $fiscal['nome_fiscal'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fiscal_contato">Contato do fiscal</label>
                                <input readonly type="text" id="fiscal_contato" name="fiscal_contato" class="form-control" maxlength="60" value="<?= $fiscal['contato_fiscal'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="suplente">Suplente</label>
                                <input readonly type="text" id="suplente" name="suplente" class="form-control" maxlength="60" value="<?= $suplente['nome_suplente'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="suplente_contato">Contato do suplente</label>
                                <input readonly type="text" id="suplente_contato" name="suplente_contato" class="form-control" maxlength="60" value="<?= $suplente['contato_suplente'] ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-offset-5 col-md-2" align="center" style="margin-top: 10px">
                                <label for="garantia">Garatia? </label> <br>
                                <input readonly class="form-control text-center" type="text" name="garantia" id="garantia" value="<?= $contrato['garantia'] == 1 ? 'SIM' : "NÃO" ?>">
                            </div>
                        </div>

                        <hr />

                        <div align="center">
                            <h2>Informações do contrato</h2>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="inicio_vigencia">Vigência início</label>
                                <input readonly type="date" name="inicio_vigencia" id='inicio_vigencia' class="form-control" value="<?= $informacoes['inicio_vigencia'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fim_vigencia">Vigência fim</label>
                                <input readonly type="date" name="fim_vigencia" id='fim_vigencia' class="form-control" value="<?= $informacoes['fim_vigencia'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="dou">DOU</label>
                                <input readonly type="date" name="dou" id='dou' class="form-control" value="<?= $informacoes['DOU'] ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="valor_mensal">Valor mensal</label>
                                <input readonly type="text" id="valor_mensal" name="valor_mensal" class="form-control" value="<?= dinheiroParaBr($informacoes['valor_mensal']) ?>" onKeyPress="return(moeda(this,'.',',',event))">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="valor_anual">Valor anual</label>
                                <input readonly type="text" id="valor_anual" name="valor_anual" class="form-control" value="<?= dinheiroParaBr($informacoes['valor_anual']) ?>" onKeyPress="return(moeda(this,'.',',',event))">
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="negociacoes_reajustes">Negociações / Reajuste</label>
                                <textarea readonly id="negociacoes_reajustes" name="negociacoes_reajustes" class="form-control" rows="3" maxlength="125"><?= $contrato['negociacoes_reajustes'] ?></textarea readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nivel_risco">Nível de risco</label>
                                <textarea readonly id="nivel_risco" name="nivel_risco" class="form-control" maxlength="250" rows="3"><?= $contrato['nivel_de_risco'] ?></textarea readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="observacao">Observação *</label>
                                <textarea readonly id="observacao" name="observacao" class="form-control" maxlength="250" rows="3"><?= $contrato['observacao'] ?></textarea readonly>
                            </div>
                            <div class="form-group col-md-3" style="margin-top: 25px">
                                <label for="vencimento">Vencimento</label>
                                <input readonly type="text" id="vencimento" name="vencimento" class="form-control" maxlength="60" readonly value="<?= exibirDataBr($contrato['vencimento']) ?>">
                            </div>
                            <div class="form-group col-md-3" style="margin-top: 25px">
                                <label for="status">Status *</label>
                                <input readonly class="form-control" type="text" name="status" id="status" value="<?= $status ?>">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Equipamentos vinculados a este contrato
                        </h3>
                        <div class="box-body">
                            <table id="tblLicitacao" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Equipamento</th>
                                    <th>Unidade</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($queryEquips as $equip) {
                                    ?>
                                    <tr>
                                            <td><?= $equip['nome'] ?></td>
                                            <td><?= $equip['unidade_nome'] ?></td>

                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <a href="?perfil=contratos&p=pesquisa&sp=pesquisa_contratos" class="btn btn-default">Voltar a Pesquisa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<script>
    $('#num_processo').mask('0000.0000/0000000-0', {reverse: true});

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
