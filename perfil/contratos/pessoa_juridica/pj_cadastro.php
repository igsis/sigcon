<?php

if (isset($_POST['documentacao'])) {
    $cnpj = $_POST['documentacao'];
}


?>
<script language="JavaScript" >
    $("#cep").mask('00000-000', {reverse: true});
</script>

<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Cadastro Pessoa Jurídica</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informações Pessoa Jurídica</h3>
                    </div>

                    <form method="POST" action="?perfil=contratos&p=pesquisa&sp=pj_pesquisa" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="razao_social">Razão Social *</label>
                                    <input type="text" class="form-control" id="razao_social" name="razao_social" maxlength="170" required>
                                </div>
                                <div class="form-group col-md-3 has-feedback" id="divCNPJ">
                                    <label for="cnpj">CNPJ *</label>
                                    <input type="text" data-mask="00.000.000/0000-00" minlength="18" class="form-control" id="cnpj" name="cnpj" value="<?= isset($cnpj) ? $cnpj : NULL?>" required onblur="validacao()">
                                    <span class="help-block" id="spanHelp"></span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" minlength="9" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="rua">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="logradouro" maxlength="200" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="uf" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1 * </label>
                                    <input type="text" data-mask="(00) 0000-0000" class="form-control" id="telefone" name="telefone[0]" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Telefone #2 </label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="celular" name="telefone[1]">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="recado">Telefone #3 </label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="recado" name="telefone[2]">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="contato">Contato na empresa *</label>
                                    <input type="text" class="form-control" id="contato" name="contato" maxlength="150" required>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary pull-right" disabled="true"> Cadastrar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function validarCNPJ(cnpj) {
        if (cnpj.length !== 14)
        {
            return false;
        }
        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }

    function validacao(){
        var divCNPJ = document.querySelector('#divCNPJ');
        var cnpj = document.querySelector('#cnpj').value;

        // tira os pontos do valor, ficando apenas os numeros
        cnpj = cnpj.replace(/[^\d]+/g,'');

        var validado = validarCNPJ(cnpj);

        if(!validado){
            divCNPJ.classList.add('has-error');
            document.getElementById("spanHelp").innerHTML = "CNPJ Inválido";
            document.querySelector("#cadastra").disabled = true;
        }else if(validado){
            divCNPJ.classList.remove('has-error');
            document.getElementById("spanHelp").innerHTML = "";
            document.querySelector("#cadastra").disabled = false;
        }
    }


</script>