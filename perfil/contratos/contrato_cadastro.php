<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

    if (isset($_POST['idLicitacao'])) {
        $idLicitacao = $_POST['idLicitacao'];
        $licitacao = recuperaDados("licitacoes", "id", $idLicitacao);
    }

    if (isset($_POST['idPf'])) {
        $tipoPessoa = 1;
        $idPessoa = $_POST['idPf'];

        $pessoa_fisica = recuperaDados("pessoa_fisicas", "id", $idPessoa)['cpf'];

    } elseif (isset($_POST['idPj'])) {
        $tipoPessoa = 2;
        $idPessoa = $_POST['idPj'];

        $pessoa_juridica = recuperaDados("pessoa_juridicas", "id", $idPessoa)['cnpj'];
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
                                                    <option value="">Selecione...</option>
                                                    <?php
                                                    geraOpcao("equipamentos")
                                                    ?>
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
                                    <input type="text" id="valor_mensal" name="valor_mensal" class="form-control" placeholder="Valor em formato decimal *">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" placeholder="Valor em formato decimal *">
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
                                <div class="form-group col-md-6">
                                    <label for="observacao">Observação *</label>
                                    <textarea type="text" id="observacao" name="observacao" class="form-control" maxlength="250" rows="3" required></textarea>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 25px">
                                    <label for="vencimento">Vencimento</label>
                                    <input type="date" id="vencimento" name="vencimento" class="form-control" maxlength="60" readonly>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 25px">
                                    <label for="status">Status *</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("contrato_status")
                                        ?>
                                    </select>
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


</script>
