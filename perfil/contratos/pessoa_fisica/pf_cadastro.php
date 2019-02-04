<?php

if (isset($_POST['documentacao'])) {
    $cpf = $_POST['documentacao'];
}

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

                    <form method="POST" action="?perfil=contratos&p=pesquisa&sp=pf_pesquisa" role="form">
                        <div class="box-body">
                            <div class="row has-feedback">
                                <div class="form-group col-md-4">
                                    <label for="nome_pf">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome_pf" name="nome_pf" maxlength="170" required>
                                </div>
                                <div class="form-group col-md-2 has-feedback" id="divCPF">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" data-mask="000.000.000-00" minlength="14" class="form-control" onblur="validacao()" id="cpf" name="cpf" value="<?= isset($cpf) ? $cpf : NULL ?>" required>
                                    <span class="help-block" id="spanHelp"></span>
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
                                    <label for="telefone">Telefone fixo *</label>
                                    <input type="text" data-mask="(00) 0000-0000" class="form-control" id="telefone" name="telefone[0]" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Celular *</label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="celular" name="telefone[1]" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="recado">Recado (opcional) </label>
                                    <input type="text" data-mask="(00) 0000-00000" class="form-control" id="recado" name="telefone[2]">
                                </div>
                            </div>
                            <div class="box-footer">
                                <a href="?perfil=contratos&p=pesquisa&sp=pf_pesquisa" class="btn btn-default">Voltar a Pesquisa</a>
                                <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-primary pull-right" disabled="true"> Cadastrar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

    function TestaCPF(cpf) {
        var Soma;
        var Resto;
        var strCPF = cpf;
        Soma = 0;

        if (strCPF == "00000000000" ||
            strCPF == "11111111111" ||
            strCPF == "22222222222" ||
            strCPF == "33333333333" ||
            strCPF == "44444444444" ||
            strCPF == "55555555555" ||
            strCPF == "66666666666" ||
            strCPF == "77777777777" ||
            strCPF == "88888888888" ||
            strCPF == "99999999999")
            return false;

        for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
        return true;
    }

    function validacao(){
        var divCPF = document.querySelector('#divCPF');
        var strCPF = document.querySelector('#cpf').value;

        // tira os pontos do valor, ficando apenas os numeros
        strCPF = strCPF.replace(/[^0-9]/g, '');

        //console.log(strCPF);

        var validado = TestaCPF(strCPF);

        //console.log(teste);

        // document.querySelector('#validado').value = teste;

        if(!validado){
            divCPF.classList.add("has-error");
            document.getElementById("spanHelp").innerHTML = "CPF Inválido";
            document.querySelector("#cadastrar").disabled = true;
        }else if(validado){
            divCPF.classList.remove("has-error");
            document.getElementById("spanHelp").innerHTML = "";
            document.querySelector("#cadastrar").disabled = false;
        }
    }

</script>