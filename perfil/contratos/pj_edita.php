<?php
include "../perfil/includes/menu.php";


if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $razao_social = addslashes($_POST['razao_social']);
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $recado = $_POST['recado'];
    $contato = $_POST['contato'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? NULL;
    $uf = $_POST['uf'];
    $cidade = $_POST['cidade'];

}

if (isset($_POST['cadastra'])) {
    $ultima_atualizacao = date('Y-m-d H:i:s');
    $sql = "INSERT INTO pessoa_juridicas 
                                (razao_social,
                                 cnpj, 
                                 ccm,
                                 email,
                                 ultima_atualizacao) 
                          VALUES ('$razao_social',
                                  '$cnpj',
                                  '$ccm',
                                  '$email',
                                  '$ultima_atualizacao')";

    if (mysqli_query($con, $sql)) {
        $idPessoaJuridica = recuperaUltimo('pessoa_juridicas');
        $_SESSION['idPessoaJuridica'] = $idPessoaJuridica;
        $_SESSION['idPj_pedido']  = $idPessoaJuridica;


        // cadastrar o telefone de pj
        $sqlTelefone = "INSERT INTO pj_telefones
                                                (pessoa_juridica_id,
                                                 telefone) 
                                          VALUES ('$idPessoaJuridica',
                                                  '$telefone')";
        mysqli_query($con, $sqlTelefone);

        // cadastrar endereco de pj
        $sqlEndereco = "INSERT INTO pj_enderecos
                                                (pessoa_juridica_id,
                                                 logradouro,
                                                 numero,
                                                 complemento,
                                                 bairro,
                                                 cidade,
                                                 uf,
                                                 cep)
                                          VALUES ('$idPessoaJuridica',
                                                  '$logradouro',
                                                  '$numero',
                                                  '$complemento',
                                                  '$bairro',
                                                  '$cidade',
                                                  '$uf',
                                                  '$cep')";

        mysqli_query($con, $sqlEndereco);

        $mensagem = mensagem("success", "Cadastrado com sucesso!");
        //gravarLog($sql);
    } else {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
        //gravarLog($sql);
    }
}

if (isset($_POST['edita'])) {
    $ultima_atualizacao = date('Y-m-d H:i:s');
    $idPessoaJuridica = $_POST['idPessoaJuridica'];
    $sql = "UPDATE pessoa_juridicas SET
                              razao_social = '$razao_social',
                              cnpj = '$cnpj', 
                              ccm = '$ccm',
                              email = '$email',
                              ultima_atualizacao = '$ultima_atualizacao'
                              WHERE id = '$idPessoaJuridica'";

    $sqlTelefone = "UPDATE pj_telefones SET
                                          telefone = '$telefone'
                                          WHERE pessoa_juridica_id = '$idPessoaJuridica'";

    $sqlEndereco = "UPDATE pj_enderecos SET
                                          cep = '$cep',
                                          logradouro = '$logradouro',
                                          uf = '$uf',
                                          cidade = '$cidade',
                                          bairro = '$bairro',
                                          numero = '$numero',
                                          complemento = '$complemento'
                                          WHERE pessoa_juridica_id = '$idPessoaJuridica'";

    If (mysqli_query($con, $sql) && mysqli_query($con, $sqlTelefone) && mysqli_query($con, $sqlEndereco)) {
        $mensagem = mensagem("success", "Atualizado com sucesso!");
        //gravarLog($sql);
    } else {
        $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
        //gravarLog($sql);
    }
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

                    <form method="POST" action="?perfil=contratos/pj_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="razao_social">Razão Social *</label>
                                    <input type="text" class="form-control" id="razao_social" name="razao_social" maxlength="170" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cnpj">CNPJ *</label>
                                    <input type="text" data-mask="00.000.000/0000-00" class="form-control" id="cnpj" name="cnpj" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="logradouro">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="logradouro" maxlength="200" readonly>
                                </div>

                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-5">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="complemento">Complemento *</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Celular * </label>
                                    <input type="text" data-mask="(00) 0.0000-0000" class="form-control" id="telefone" name="telefone" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone fixo * </label>
                                    <input type="text" data-mask="(00) 0000-0000" class="form-control" id="telefone" name="telefone" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="telefone">Recado (opcional) </label>
                                    <input type="text" data-mask="(00) 0000-00000" class="form-control" id="telefone" name="telefone" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contato">Contato na empresa: </label>
                                    <input type="text" class="form-control" id="contato" name="contato" maxlength="150" required>
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