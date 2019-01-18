<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();


if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idPessoaJuridica = $_POST['idPessoaJuridica'] ?? NULL;
    $razao_social = addslashes($_POST['razao_social']);
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $outro = $_POST['recado'];
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
    $sql = "INSERT INTO pessoas_juridicas 
                                (razao_social,
                                 CNPJ,
                                 email,
                                 contato,
                                 publicado) 
                          VALUES ('$razao_social',
                                  '$cnpj',
                                  '$email',
                                  '$contato',
                                  '1')";

    if (mysqli_query($con, $sql)) {
        $idPessoaJuridica = recuperaUltimo('pessoas_juridicas');

        // cadastrar o telefone de pj
        $sqlTelefone = "INSERT INTO pj_telefones
                                                (pessoa_juridica_id,
                                                 telefone,
                                                 celular,
                                                 outro) 
                                          VALUES ('$idPessoaJuridica',
                                                  '$telefone',
                                                  '$celular', 
                                                  '$outro')";
        mysqli_query($con, $sqlTelefone);

        // cadastrar endereco de pj
        $sqlEndereco = "INSERT INTO pj_enderecos
                                                (pessoa_juridica_id,
                                                 cep,
                                                 logradouro,
                                                 bairro,
                                                 cidade,
                                                 estado,
                                                 numero,
                                                 complemento)
                                          VALUES ('$idPessoaJuridica',
                                                  '$cep',
                                                  '$bairro',
                                                  '$cidade',
                                                  '$uf',
                                                  '$logradouro',
                                                  '$numero',
                                                  '$complemento')";

        mysqli_query($con, $sqlEndereco);

        $mensagem = mensagem("success", "Cadastrado com sucesso!");
        //gravarLog($sql);
    } else {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
        //gravarLog($sql);
    }
}

if (isset($_POST['edita'])) {
    $sql = "UPDATE pessoas_juridicas SET
                              razao_social = '$razao_social', 
                                 CNPJ = '$cnpj',
                                 email = '$email',
                                 contato = '$contato',                                  
                          WHERE id = '$idPessoaJuridica'";

    $sqlTelefone = "UPDATE pj_telefones SET
                                          telefone = '$telefone'
                                          celular = '$celular';
                                          outro = '$outro'
                                          WHERE pessoa_juridica_id = '$idPessoaJuridica'";

    $sqlEndereco = "UPDATE pj_enderecos SET
                                          cep = '$cep',
                                          logradouro = '$logradouro',
                                          estado= '$uf',
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


$pessoa_juridica = recuperaDados("pessoas_juridicas", "id", $idPessoaJuridica);
$pj_telefone = recuperaDados("pj_telefones", "pessoa_juridica_id", $idPessoaJuridica);
$pj_endereco = recuperaDados("pj_enderecos", "pessoa_juridica_id", $idPessoaJuridica);

?>
<script language="JavaScript" >
    $("#cep").mask('00000-000', {reverse: true});
</script>

<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Edição de Pessoa Jurídica</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Razão Social: <?= $pessoa_juridica['razao_social'] ?></h3>
                    </div>

                    <form method="POST" action="?perfil=contratos/pj_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="razao_social">Razão Social *</label>
                                    <input type="text" class="form-control" id="razao_social" name="razao_social" maxlength="170" value="<?= $pessoa_juridica['razao_social'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cnpj">CNPJ *</label>
                                    <input type="text" data-mask="00.000.000/0000-00" class="form-control" id="cnpj" name="cnpj" value="<?= $pessoa_juridica['CNPJ'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" maxlength="100" value="<?= $pj_endereco['cep'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" value="<?= $pj_endereco['numero'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="logradouro">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="logradouro" maxlength="200" readonly value="<?= $pj_endereco['logradouro'] ?>">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" readonly value="<?= $pj_endereco['bairro'] ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="uf">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="uf" readonly value="<?= $pj_endereco['estado'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" readonly value="<?= $pj_endereco['cidade'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" value="<?= $pessoa_juridica['email'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="complemento">Complemento *</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25" value="<?= $pj_endereco['complemento'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Celular * </label>
                                    <input type="text" data-mask="(00) 0.0000-0000" class="form-control" id="celular" name="celular" value="<?= $pj_telefone['celular'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone fixo * </label>
                                    <input type="text" data-mask="(00) 0000-0000" class="form-control" id="telefone" name="telefone" value="<?= $pj_telefone['telefone'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="recado">Recado (opcional) </label>
                                    <input type="text" data-mask="(00) 0000-00000" class="form-control" id="recado" name="recado" value="<?= $pj_telefone['outro'] ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contato">Contato na empresa: </label>
                                    <input type="text" class="form-control" id="contato" name="contato" maxlength="150" value="<?= $pessoa_juridica['contato'] ?>">
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Cancelar</button>
                                <input type="hidden" name="idPessoaJuridica" value="<?= $idPessoaJuridica ?>">
                                <button type="submit" name="cadastra" id="cadastra" class="btn btn-primary pull-right"> Cadastrar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>