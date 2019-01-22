<?php
include "../perfil/includes/menu.php";

?>
<script language="JavaScript" >
    $("#cep").mask('00000-000', {reverse: true});
</script>

<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Cadastro Pessoa Física</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informações Pessoa Física</h3>
                    </div>

                    <form method="POST" action="?perfil=contratos/pf_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nome_pf">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome_pf" name="nome_pf" maxlength="170" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" data-mask="000.000.000-00" class="form-control" id="cpf" name="cpf" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="logradouro">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="logradouro" maxlength="200" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="uf">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="uf" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone # * </label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="telefone" name="telefone[]" required>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="">&emsp;</label>
                                    <a class="btn btn-info btn-block" href="#void" id="addInput"><strong>&plus;</strong></a>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Cancelar</button>
                                <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary pull-right"> Cadastrar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" >
    $('#addInput').on('click', function(e) {
        let i = $('#telefone').length;
        $('#telefone').first().clone().find("input").attr('name', function(idx, attrVal) {
            return attrVal.replace('[0]','')+'['+i+']';
        }).removeAttr('checked').end().find("input[type=text]").val('').end().insertBefore('.botoes');
    });

    $('#remInput').on('click', function(e) {
        let i = $('#telefone').length;
        if (i > 1){
            $('#telefone').last().remove();
        }
    });
</script>