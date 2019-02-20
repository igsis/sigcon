<?php

$con = bancoMysqli();
$conn = bancoPDO();

$url = 'http://'.$_SERVER['HTTP_HOST'].'/sigcon/funcoes/api_equipamentos.php';


if (isset($_POST['selecionar'])) {

    if (isset($_POST['idPf'])) {
        $tipoPessoa = 1;
        $idPessoa = $_POST['idPf'];


    } elseif (isset($_POST['idPj'])) {
        $tipoPessoa = 2;
        $idPessoa = $_POST['idPj'];
    }

}


if(isset($_POST['carregar'])){
    $idContrato = $_POST['idContrato'];
    $contrato = recuperaDados('contratos', 'id', $idContrato);
    $idPessoa = $contrato['pessoa_id'];
    $tipoPessoa = $contrato['tipo_pessoa_id'];

    $idLicitacao = $contrato['licitacao_id'];
    $licitacao = recuperaDados('licitacoes', 'id', $idLicitacao);

    if ($tipoPessoa == 1) {
        $pessoa_fisica = recuperaDados("pessoa_fisicas", "id", $idPessoa)['cpf'];

    }else {
        $pessoa_juridica = recuperaDados("pessoa_juridicas", "id", $idPessoa)['cnpj'];
    }

}


if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idLicitacao = $_POST['idLicitacao'];
    $licitacao = recuperaDados("licitacoes", "id", $idLicitacao);

    $idContrato = $_POST['idContrato'] ?? NULL;
    $tipoPessoa = $_POST['tipoPessoa'] ?? NULL;
    $idPessoa = $_POST['idPessoa'] ?? NULL;
    $termo_contrato = $_POST['termo_contrato'] ?? NULL;
    $tipo_servico = $_POST['tipo_servico'] ?? NULL;
    $objeto = $_POST['objeto'] ?? NULL;
    $idUnidade = $_POST['unidade'] ?? NULL;
    $equipamentos = $_POST['equipamento'] ?? NULL;
    $fiscal = $_POST['fiscal'] ?? NULL;
    $contatoFiscal = $_POST['fiscal_contato'] ?? NULL;
    $suplente = $_POST['suplente'] ?? NULL;
    $contatoSuplente = $_POST['suplente_contato'] ?? NULL;
    $garantia = $_POST['garantia'] ?? NULL;
    $inicio_vigencia = $_POST['inicio_vigencia'] ?? NULL;
    $fim_vigencia = $_POST['fim_vigencia'] ?? NULL;
    $DOU = $_POST['dou'] ?? NULL;
    $valor_mensal = dinheiroDeBr($_POST['valor_mensal']) ?? NULL;
    $valor_anual = dinheiroDeBr($_POST['valor_anual']) ?? NULL;
    $negociacoes_reajustes = $_POST['negociacoes_reajustes'] ?? NULL;
    $nivel_risco = $_POST['nivel_risco'] ?? NULL;
    $observacao = $_POST['observacao'] ?? NULL;
    $vencimento = $fim_vigencia;
    $status = $_POST['status'] ?? NULL;

    if(isset($_POST['cadastra'])) {

        $sqlFiscal = "INSERT INTO fiscais (nome_fiscal, 
                                           contato_fiscal, 
                                           publicado)
                                  VALUES  ('$fiscal', 
                                           '$contatoFiscal',
                                           '1');";

        $sqlSuplente = "INSERT INTO suplentes (nome_suplente, 
                                           contato_suplente, 
                                           publicado)
                                  VALUES  ('$suplente', 
                                           '$contatoSuplente',
                                           '1');";

        if (mysqli_query($con, $sqlSuplente) && mysqli_query($con, $sqlFiscal)) {

            gravarLog($sqlFiscal);
            $idFiscal = recuperaUltimo("fiscais");

            gravarLog($sqlSuplente);
            $idSuplente = recuperaUltimo("suplentes");

            $sqlContrato = "INSERT INTO contratos (licitacao_id, 
                                                       termo_contrato, 
                                                       tipo_servico,
                                                       tipo_pessoa_id,
                                                       pessoa_id,
                                                       unidade_id,
                                                       fiscal_id,
                                                       suplente_id,
                                                       garantia, 
                                                       vencimento,
                                                       negociacoes_reajustes,
                                                       nivel_de_risco,
                                                       observacao,
                                                       contrato_status_id,
                                                       publicado)
                                             VALUES   ('$idLicitacao', 
                                                       '$termo_contrato',
                                                       '$tipo_servico',
                                                       '$tipoPessoa', 
                                                       '$idPessoa',
                                                       '$idUnidade',
                                                       '$idFiscal',
                                                       '$idSuplente',
                                                       '$garantia',
                                                       '$vencimento',
                                                       '$negociacoes_reajustes',
                                                       '$nivel_risco',
                                                       '$observacao',
                                                       '1',                                                       
                                                       '1')";

            if (mysqli_query($con, $sqlContrato)) {

                gravarLog($sqlContrato);
                $idContrato = recuperaUltimo("contratos");

                foreach ($equipamentos as $equipamento) {

                    $sqlEquipamentos = "INSERT INTO contrato_equipamento  
                                                    (contrato_id, 
                                                     equipamento_id)
                                       VALUES       ('$idContrato',
                                                     '$equipamento')";

                    mysqli_query($con, $sqlEquipamentos);
                    gravarLog($sqlEquipamentos);
                }

                $sqlInfo = "INSERT INTO informacoes_do_contrato (contrato_id, 
                                                       inicio_vigencia, 
                                                       fim_vigencia,
                                                       DOU,
                                                       valor_mensal,
                                                       valor_anual)
                                             VALUES   ('$idContrato', 
                                                       '$inicio_vigencia',
                                                       '$fim_vigencia',
                                                       '$DOU',
                                                       '$valor_mensal',
                                                       '$valor_anual')";

                if (mysqli_query($con, $sqlInfo)) {

                    gravarLog($sqlInfo);
                    $mensagem = mensagem("success", "Cadastrado com sucesso!");
                }
            } else {
                $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");
            }
        }
    }


    if (isset($_POST['edita'])){

        $sqlInfo = "UPDATE informacoes_do_contrato SET 
                                          inicio_vigencia = '$inicio_vigencia',
                                          fim_vigencia = '$fim_vigencia',
                                          DOU = '$DOU',
                                          valor_mensal = '$valor_mensal',
                                          valor_anual =  '$valor_anual'
                                    WHERE contrato_id = '$idContrato'";

            mysqli_query($con, $sqlInfo);
            gravarLog($sqlInfo);
            $vencimento = recuperaDados("informacoes_do_contrato", "contrato_id", $idContrato)['fim_vigencia'];

            $sqlContrato = "UPDATE contratos SET 
                                          termo_contrato = '$termo_contrato', 
                                          tipo_servico = '$tipo_servico',
                                          tipo_pessoa_id = '$tipoPessoa',
                                          pessoa_id = '$idPessoa',
                                          unidade_id = '$idUnidade',
                                          garantia =  '$garantia',
                                          vencimento = '$vencimento',
                                          negociacoes_reajustes =  '$negociacoes_reajustes',
                                          nivel_de_risco = '$nivel_risco',
                                          observacao = '$observacao',
                                          contrato_status_id = '$status'
                                  WHERE id = '$idContrato'";

                    gravarLog($sqlContrato);
                    $contrato = recuperaDados("contratos", "id", $idContrato);

                    $idFiscal = $contrato['fiscal_id'];
                    $idSuplente = $contrato['suplente_id'];

                    $sqlFiscal = "UPDATE fiscais SET 
                                          nome_fiscal = '$fiscal', 
                                          contato_fiscal = '$contatoFiscal'
                                      WHERE id = '$idFiscal'";

                    gravarLog($sqlFiscal);

                    $sqlSuplente = "UPDATE suplentes SET 
                                                nome_suplente = '$suplente', 
                                                contato_suplente = '$contatoSuplente'
                                      WHERE id = '$idSuplente'";

                    gravarLog($sqlSuplente);

                    if (mysqli_query($con, $sqlContrato) || mysqli_query($con, $sqlFiscal) || mysqli_query($con, $sqlSuplente)) {

                        $mensagem = mensagem("success", "Atualizado com sucesso!");

                    } else {
                        $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
                    }
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

$sqlEquips = "SELECT * FROM contrato_equipamento WHERE contrato_id = '$idContrato'";
$queryEquips = mysqli_query($con, $sqlEquips);
$numEquips = mysqli_num_rows($queryEquips);

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
                        <h3 class="box-title">
                            <?= "Número do processo administrativo: " . $licitacao['numero_processo']?>
                        </h3>
                        <div class="box-tools pull-right">
                            <form method="POST" action="?perfil=contratos&p=pesquisa&sp=pesquisa_contrato_equipamentos"
                                  role="form">
                                <div class="form-group"><input type="hidden" name="idContrato" value="<?= $idContrato ?>">
                                    <button type="submit" name="listaEquipamentos" class="btn btn-primary">
                                        Listar Equipamentos
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos&p=contrato_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="num_processo">Número do processo administrativo</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" maxlength="20" value="<?= $licitacao['numero_processo'];  ?>" readonly>
                                </div>
                                <?php

                                if ($tipoPessoa == 1) {

                                    ?>

                                    <div class="form-group col-md-3">
                                        <label for="cpf">CPF: </label>
                                        <input type="text" data-mask="000.000.000-00" id="cpf" name="cpf"
                                               class="form-control" value="<?= $pessoa_fisica ?>" readonly>
                                    </div>

                                    <?php

                                }elseif ($tipoPessoa == 2) {

                                    ?>

                                    <div class="form-group col-md-3">
                                        <label for="cnpj">CNPJ: </label>
                                        <input type="text" data-mask="00.000.000/0000-00" id="cnpj" name="cnpj"
                                               class="form-control" value="<?= $pessoa_juridica ?>" readonly>
                                    </div>

                                    <?php
                                }

                                ?>
                                <div class="form-group col-md-6">
                                    <label for="objeto">Objeto *</label>
                                    <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" value="<?= $licitacao['objeto']; ?>" readonly>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="termo_contrato">Termo de contrato *</label>
                                    <input type="text" id="termo_contrato" name="termo_contrato" class="form-control" maxlength="100" value="<?= $contrato['termo_contrato'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tipo_servico">Tipo de serviço *</label>
                                    <input type="text" id="tipo_servico" name="tipo_servico" class="form-control" maxlength="80" value="<?= $contrato['tipo_servico'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade">Unidade *</label>
                                    <select class="form-control" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades", $contrato['unidade_id'])
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="fiscal">Fiscal</label>
                                    <input type="text" id="fiscal" name="fiscal" class="form-control" maxlength="60" value="<?= $fiscal['nome_fiscal'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="fiscal_contato">Contato do fiscal</label>
                                    <input type="text" id="fiscal_contato" name="fiscal_contato" class="form-control" maxlength="60" value="<?= $fiscal['contato_fiscal'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suplente">Suplente</label>
                                    <input type="text" id="suplente" name="suplente" class="form-control" maxlength="60" value="<?= $suplente['nome_suplente'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suplente_contato">Contato do suplente</label>
                                    <input type="text" id="suplente_contato" name="suplente_contato" class="form-control" maxlength="60" value="<?= $suplente['contato_suplente'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12" align="center" style="margin-top: 10px">
                                    <label for="garantia">Garatia? </label> <br>
                                    <label><input type="radio" name="garantia" value="1" <?= $contrato['garantia'] == 1 ? 'checked' : NULL ?>> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="garantia" value="0" <?= $contrato['garantia'] == 0 ? 'checked' : NULL ?>> Não </label>
                                </div>
                            </div>

                            <hr />

                            <div align="center">
                                <h2>Informações do contrato</h2>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="inicio_vigencia">Vigência início</label>
                                    <input type="date" name="inicio_vigencia" id='inicio_vigencia' class="form-control" value="<?= $informacoes['inicio_vigencia'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="fim_vigencia">Vigência fim</label>
                                    <input type="date" name="fim_vigencia" id='fim_vigencia' class="form-control" value="<?= $informacoes['fim_vigencia'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="dou">DOU</label>
                                    <input type="date" name="dou" id='dou' class="form-control" value="<?= $informacoes['DOU'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_mensal">Valor mensal</label>
                                    <input type="text" id="valor_mensal" name="valor_mensal" class="form-control" value="<?= dinheiroParaBr($informacoes['valor_mensal']) ?>" onKeyPress="return(moeda(this,'.',',',event))">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" value="<?= dinheiroParaBr($informacoes['valor_anual']) ?>" onKeyPress="return(moeda(this,'.',',',event))">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="negociacoes_reajustes">Negociações / Reajuste</label>
                                    <textarea id="negociacoes_reajustes" name="negociacoes_reajustes" class="form-control" rows="3" maxlength="125"><?= $contrato['negociacoes_reajustes'] ?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nivel_risco">Nível de risco</label>
                                    <textarea id="nivel_risco" name="nivel_risco" class="form-control" maxlength="250" rows="3"><?= $contrato['nivel_de_risco'] ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="observacao">Observação *</label>
                                    <textarea id="observacao" name="observacao" class="form-control" maxlength="250" rows="3"><?= $contrato['observacao'] ?></textarea>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 25px">
                                    <label for="vencimento">Vencimento</label>
                                    <input type="text" id="vencimento" name="vencimento" class="form-control" maxlength="60" readonly value="<?= exibirDataBr($contrato['vencimento']) ?>">
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 25px">
                                    <label for="status">Status *</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("contrato_status", $contrato['contrato_status_id'])
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="?perfil=contratos&p=pesquisa&sp=pesquisa_contratos" class="btn btn-default">Voltar a Pesquisa</a>
                            <input type="hidden" name="idContrato" value="<?= $idContrato ?>">
                            <input type="hidden" name="tipoPessoa" value="<?= $tipoPessoa ?>">
                            <input type="hidden" name="idPessoa" value="<?= $idPessoa ?>">
                            <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
                            <button type="submit" name="edita" class="btn btn-primary pull-right">Editar</button>
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
    $('#num_processo').mask('0000.0000/0000000-0', {reverse: true});


    function habilitaCampo(id) {
        if(document.getElementById(id).disabled==true){document.getElementById(id).disabled=false}
    }

    function desabilitarCampo(id){
        if(document.getElementById(id).disabled==false){document.getElementById(id).disabled=true}
    }

    /* function habilitarRadio (valor) {
         if (valor == 2) {
             document.status.disabled = false;
         } else {
             document.status.disabled = true;
         }
     }*/




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
