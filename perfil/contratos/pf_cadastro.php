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
                                    <input type="text" class="form-control" id="nome_pf" name="nome_pf" maxlength="170">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" data-mask="000.000.000-00" minlength="11" class="form-control" id="cpf" name="cpf">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" minlength="9" data-mask="00000-000">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero">
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
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone fixo *</label>
                                    <input type="text" data-mask="(00) 0000-0000" class="form-control" id="telefone" name="telefone[0]" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Celular *</label>
                                    <input type="text" data-mask="(00) 0.0000-0000" class="form-control" id="celular" name="telefone[1]">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="recado">Recado (opcional) </label>
                                    <input type="text" data-mask="(00) 0000-00000" class="form-control" id="recado" name="telefone[2]">
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