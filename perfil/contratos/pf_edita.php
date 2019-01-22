<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();


if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idPessoaFisica = $_POST['idPessoaFisica'] ?? NULL;
    $nome_pf = addslashes($_POST['nome_pf']);
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $outro = $_POST['recado'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? NULL;
    $uf = $_POST['uf'];
    $cidade = $_POST['cidade'];

}

if (isset($_POST['cadastra']))
{
    $sqlConsultaCPF = "SELECT `cpf` FROM `pessoas_fisicas` WHERE `cpf` = '$cpf'";
    if ($con->query($sqlConsultaCPF)->num_rows > 0)
    {
        $mensagem = mensagem("danger", "Erro ao gravar! CPF já cadastrado.");
    }
    else
    {
        // cadastrar endereco de pf
        $sqlEndereco = "INSERT INTO enderecos
                                        (cep,
                                         logradouro,
                                         bairro,
                                         cidade,
                                         estado,
                                         numero,
                                         complemento)
                                  VALUES ('$cep',
                                          '$logradouro',
                                          '$bairro',
                                          '$cidade',
                                          '$uf',                                      
                                          '$numero',
                                          '$complemento')";
        if ($con->query($sqlEndereco))
        {
            gravarLog($sqlEndereco);
            $endereco_id = $con->insert_id;

            $sql = "INSERT INTO pessoas_fisicas 
                                    (nome,
                                     cpf,
                                     email,
                                     endereco_id,
                                     publicado) 
                              VALUES ('$nome_pf',
                                      '$cpf',
                                      '$email',
                                      '$endereco_id',
                                      '1')";
            if ($con->query($sql))
            {
                $idPessoaFisica = $con->insert_id;
                gravarLog($sql);

                $sqlTelefone = "INSERT INTO pf_telefones
                                        (pessoa_fisica_id,
                                         telefone) 
                                  VALUES ('$idPessoaFisica', 
                                          '$telefone')";
                if ($con->query($sqlTelefone))
                {
                    gravarLog($sqlTelefone);
                    $telefone_id = $con->insert_id;
                    $mensagem = mensagem("success", "Cadastrado com sucesso!");
                }
                else
                {
                    $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
                }
            }
            else
            {
                $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
            }
        }
        else
        {
            $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
        }
    }
}

if (isset($_POST['edita'])) {
    
    $sql = "UPDATE pessoas_fisicas SET
                              nome = '$nome_pf',
                                 cpf = '$cpf',
                                 email = '$email',
                          WHERE id = '$idPessoaFisica'";

    if (mysqli_query($con, $sql)) {

        $pf = recuperaDados('pessoas_fisicas', 'id', $idPessoaFisica);
        $telefone_id = $pf['telefone_id'];
        $endereco_id = $pf['endereco_id'];

        $sqlTelefone = "UPDATE telefones SET
                                  telefone = '$telefone'
                                  celular = '$celular',
                                  outro = '$outro'
                                  WHERE id = '$telefone_id'";

        if (mysqli_query($con, $sqlTelefone)) {

            $sqlEndereco = "UPDATE enderecos SET
                                  cep = '$cep',
                                  logradouro = '$logradouro',
                                  estado= '$uf',
                                  cidade = '$cidade',
                                  bairro = '$bairro',
                                  numero = '$numero',
                                  complemento = '$complemento'
                                  WHERE id = '$endereco_id'";

            if (mysqli_query($con, $sqlEndereco)) {

                $mensagem = mensagem("success", "Atualizado com sucesso!");

                //gravarLog($sql);
            } else {
                $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
                //gravarLog($sql);
            }
        }
    }
}


$pessoa_fisica = recuperaDados("pessoas_fisicas", "id", $idPessoaFisica);
$pf_telefone = recuperaDados("pf_telefones", "id", $telefone_id);
$pf_endereco = recuperaDados("enderecos", "id", $endereco_id);

?>
<script language="JavaScript" >
    $("#cep").mask('00000-000', {reverse: true});
</script>

<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Edição Pessoa Física</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nome: <?= $pessoa_fisica['nome']; ?></h3>
                    </div>
                    <h1><?=$mensagem?></h1>

                    <form method="POST" action="?perfil=contratos/pf_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nome_pf">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome_pf" name="nome_pf" maxlength="170" value="<?=$pessoa_fisica['nome'];?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" data-mask="000.000.000-00" class="form-control" id="cpf" name="cpf" value=" <?= $pessoa_fisica['cpf']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" maxlength="100" value=" <?= $pf_endereco['cep']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" value="<?= $pf_endereco['numero']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25" value=" <?= $pf_endereco['complemento']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="logradouro">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="logradouro" maxlength="200" readonly value=" <?= $pf_endereco['logradouro']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" readonly value=" <?= $pf_endereco['bairro']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="uf">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="uf" readonly value=" <?= $pf_endereco['estado']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" readonly value=" <?= $pf_endereco['cidade']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" required value=" <?= $pessoa_fisica['email']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Celular * </label>
                                    <input type="text" data-mask="(00) 0.0000-0000" class="form-control" id="celular" name="celular" value=" <?= $pf_telefone['celular']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone fixo * </label>
                                    <input type="text" data-mask="(00) 0000-0000" class="form-control" id="telefone" name="telefone" value=" <?= $pf_telefone['telefone']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label el for="recado">Recado (opcional) </label>
                                    <input type="text" class="form-control" id="recado" name="recado" value=" <?= $pf_telefone['outro']; ?>">
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-default">Cancelar</button>
                                <input type="hidden" name="idPessoaFisica" value="<?= $idPessoaFisica ?>">
                                <button type="submit" name="edita" id="edita" class="btn btn-primary pull-right"> Editar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>