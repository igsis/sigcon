<?php
include "includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

$url = 'http://'.$_SERVER['HTTP_HOST'].'/sigcon/funcoes/api_equipamentos.php';

    if (isset($_POST['idLicitacao'])) {
        $idLicitacao = $_POST['idLicitacao'];
        $licitacao = recuperaDados("licitacoes", "id", $idLicitacao);
    }

    if (isset($_POST['idPf'])) {
        $tipoPessoa = 1;
        $idPessoa = $_POST['idPf'];

        $pessoa_fisica = recuperaDados("pessoa_fisicas", "id", $idPessoa)['cpf'];

        $_SESSION['tipoPessoa'] = $tipoPessoa;
        $_SESSION['idPessoa'] = $idPessoa;

    } elseif (isset($_POST['idPj'])) {
        $tipoPessoa = 2;
        $idPessoa = $_POST['idPj'];

        $pessoa_juridica = recuperaDados("pessoa_juridicas", "id", $idPessoa)['cnpj'];


        $_SESSION['tipoPessoa'] = $tipoPessoa;
        $_SESSION['idPessoa'] = $idPessoa;
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
                        <h3 class="box-title">Cadastro de Contrato</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos/contrato_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="num_processo">Número do processo administrativo</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" maxlength="20" value="<?= $licitacao['numero_processo'] ?>" readonly>
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

                                }else {

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
                                    <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" value="<?= $licitacao['objeto'] ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="termo_contrato">Termo de contrato *</label>
                                    <input type="text" id="termo_contrato" name="termo_contrato" class="form-control" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tipo_servico">Tipo de serviço *</label>
                                    <input type="text" id="tipo_servico" name="tipo_servico" class="form-control" maxlength="80" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade">Unidade *</label>
                                    <select class="form-control" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades")
                                        ?>
                                    </select>
                                </div>
                            </div>


                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="equipamentos">
                                                <hr>
                                                <!-- Campo populado de acordo com a escolha da unidade -->
                                                <label for="equipamento">Equipamentos atendidos</label> <br>
                                                <select class="form-control" id="equipamento" name="equipamento[0]" required>
                                                    <!-- Populando por js -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <hr class="botoes">
                            <div class="row">
                                <div class="form-group col-md-offset-2 col-md-4">
                                    <a class="btn btn-info btn-block" href="#void" id="addInput">Adicionar Equipamento</a>
                                </div>
                                <div class="form-group col-md-4">
                                    <a class="btn btn-info btn-block" href="#void" id="remInput">Remover Ultimo Equipamento</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="fiscal">Fiscal</label>
                                    <input type="text" id="fiscal" name="fiscal" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="fiscal_contato">Contato do fiscal</label>
                                    <input type="text" id="fiscal_contato" name="fiscal_contato" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suplente">Suplente</label>
                                    <input type="text" id="suplente" name="suplente" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suplente_contato">Contato do suplente</label>
                                    <input type="text" id="suplente_contato" name="suplente_contato" class="form-control" maxlength="60">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12" align="center" style="margin-top: 10px">
                                    <label for="garantia">Garatia? </label> <br>
                                    <label><input type="radio" name="garantia" value="1"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="garantia" value="0"> Não </label>
                                </div>
                            </div>

                            <hr />
                                <div align="center">
                                    <h2>Informações do contrato</h2>
                                </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Vigência início</label>
                                    <input type="date" name="inicio_vigencia" id='inicio_vigencia' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Vigência fim</label>
                                    <input type="date" name="fim_vigencia" id='fim_vigencia' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>DOU</label>
                                    <input type="date" name="dou" id='dou' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_mensal">Valor mensal</label>
                                    <input type="text" id="valor_mensal" name="valor_mensal" class="form-control" onKeyPress="return(moeda(this,'.',',',event))">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" onKeyPress="return(moeda(this,'.',',',event))">
                                </div>
                            </div>

                            <hr/>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="negociacoes_reajustes">Negociações / Reajuste</label>
                                    <textarea type="text" id="negociacoes_reajustes" name="negociacoes_reajustes" class="form-control" rows="3" maxlength="125" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nivel_risco">Nível de risco</label>
                                    <textarea type="text" id="nivel_risco" name="nivel_risco" class="form-control" maxlength="250" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observacao">Observação *</label>
                                    <textarea type="text" id="observacao" name="observacao" class="form-control" maxlength="250" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="tipoPessoa" value="<?= $tipoPessoa ?>">
                            <input type="hidden" name="idPessoa" value="<?= $idPessoa ?>">
                            <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
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

<script>

    $('#addInput').on('click', function(e) {
        let i = $('.equipamentos').length;
        $('.equipamentos').first().clone().find("select").attr('name', function(idx, attrVal) {
            return attrVal.replace('[0]','')+'['+i+']';
        }).end().insertBefore('.botoes');
    });

    $('#remInput').on('click', function(e) {
        let i = $('.equipamentos').length;
        if (i > 1){
            $('.equipamentos').last().remove();
        }
    });

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


    const url = `<?=$url?>`;

    let unidade = document.querySelector("#unidade");

    unidade.addEventListener('change', async e => {
        let idUnidade = $('#unidade option:checked').val();
        getEquipamento(idUnidade, '')

        let i = $('.equipamentos').length;
        do{
            if (i > 1){
                $('.equipamentos').last().remove();
                i--;
            }
        }while(i > 1)

        fetch(`${url}?unidade_id=${idUnidade}`)
            .then(response => response.json())
            .then(equipamentos => {
                $('#equipamento option').remove();
                $('#equipamento').append('<option value="">Selecione... </option>');

                for (const equipamento of equipamentos) {
                    $('#equipamento').append(`<option value='${equipamento.id}'>${equipamento.nome}</option>`).focus();;
                }
            })
    })

    function getEquipamento(idUnidade, selectedId){
        fetch(`${url}?unidade_id=${idUnidade}`)
            .then(response => response.json())
            .then(equipamentos => {
                $('#equipamento option').remove();

                for (const equipamento of equipamentos) {
                    if(selectedId == equipamento.id){
                        $('#equipamento').append(`<option value='${equipamento.id}' selected>${equipamento.nome}</option>`).focus();;
                    }else{
                        $('#equipamento').append(`<option value='${equipamento.id}'>${equipamento.nome}</option>`).focus();;
                    }
                }
            })
    }
</script>
