<?php

$con = bancoMysqli();
$conn = bancoPDO();

$idPessoaFisica = $_POST['idPf'];

if (isset($_POST['edita'])) {
    $idPessoaFisica = $_POST['idPf'] ?? NULL;
    $nome_pf = addslashes($_POST['nome_pf']);
    $cpf = $_POST['cpf'];
    $email = trim($_POST['email']);
    $telefones = $_POST['telefone'];
    $cep = $_POST['cep'];
    $logradouro = addslashes($_POST['logradouro']);
    $bairro = addslashes($_POST['bairro']);
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? NULL;
    $uf = $_POST['uf'];
    $cidade = addslashes($_POST['cidade']);

    $pf = recuperaDados('pessoa_fisicas', 'id', $idPessoaFisica);
    $endereco_id = $pf['endereco_id'];

    if (isset($_POST['telefone3']))
    {
        $telefone3 = $_POST['telefone3'];
        $sqlTelefone3 = "INSERT INTO pf_telefones (pessoa_fisica_id, telefone) VALUES ('$idPessoaFisica', '$telefone3')";
        if ($con->query($sqlTelefone3))
        {
            gravarLog($sqlTelefone3);
        }
    }

    $sql = "UPDATE pessoa_fisicas SET
                                 nome = '$nome_pf',
                                 cpf = '$cpf',
                                 email = '$email'
                          WHERE id = '$idPessoaFisica'";

    if ($con->query($sql))
    {
        foreach ($telefones as $idTelefone => $telefone)
        {
            if (!strlen($telefone))
            {
                // Deletar telefone do banco se for apagado no edita.
                $sqlDelete = "DELETE FROM pj_telefones WHERE id = '$idTelefone'";
                if ($con->query($sqlDelete))
                {
                    gravarLog($sqlDelete);
                }
            }

            // cadastrar o telefone de pf
            $sqlTelefone = "UPDATE pf_telefones SET telefone = '$telefone' WHERE id = '$idTelefone'";

            if ($con->query($sqlTelefone))
            {
                gravarLog($sqlTelefone);
            }
        }

        $sqlEndereco = "UPDATE enderecos SET
                                  cep = '$cep',
                                  logradouro = '$logradouro',
                                  estado= '$uf',
                                  cidade = '$cidade',
                                  bairro = '$bairro',
                                  numero = '$numero',
                                  complemento = '$complemento'
                                  WHERE id = '$endereco_id'";

        if (mysqli_query($con, $sqlEndereco))
        if ($con->query($sqlEndereco))
        {
            gravarLog($sqlEndereco);
            $mensagem = mensagem("success", "Atualizado com sucesso!");
        }
        else
        {
            $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
        }
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
    }
}


$pessoa_fisica = recuperaDados("pessoa_fisicas", "id", $idPessoaFisica);
$pf_endereco = recuperaDados("enderecos", "id", $pessoa_fisica['endereco_id']);

$arrayTelefones = $conn->query("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idPessoaFisica'")->fetchAll();

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
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>

                    <form method="POST" action="?perfil=contratos&p=pessoa_fisica&sp=pf_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nome_pf">Nome Completo *</label>
                                    <input type="text" class="form-control" id="nome_pf" name="nome_pf" maxlength="170" value="<?=$pessoa_fisica['nome'];?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF *</label>
                                    <input type="text" data-mask="000.000.000-00" minlength="11" class="form-control" id="cpf" name="cpf" value="<?= $pessoa_fisica['cpf']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" minlength="9" data-mask="00000-000" value="<?= $pf_endereco['cep']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" value="<?= $pf_endereco['numero']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25" value="<?= $pf_endereco['complemento']; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="logradouro">Rua</label>
                                    <input type="text" class="form-control" id="rua" name="logradouro" maxlength="200" readonly value="<?= $pf_endereco['logradouro']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" readonly value="<?= $pf_endereco['bairro']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="uf">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="uf" readonly value="<?= $pf_endereco['estado']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" readonly value="<?= $pf_endereco['cidade']; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" value="<?=$pessoa_fisica['email']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone fixo * </label>
                                    <input type="text" data-mask="(00)0000-0000" class="form-control" id="telefone" name="telefone[<?= $arrayTelefones[0]['id'] ?>]" value="<?= $arrayTelefones[0]['telefone']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Celular *</label>
                                    <input type="text" data-mask="(00)00000-0000" class="form-control" id="celular" name="telefone[<?= $arrayTelefones[1]['id'] ?>]" value="<?= $arrayTelefones[1]['telefone']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="recado">Recado (opcional) </label>
                                    <?php if (isset($arrayTelefones[2])) {
                                    ?>

                                    <input type="text" data-mask="(00)00000-0000" class="form-control" id="recado" name="telefone[<?= $arrayTelefones[2]['id'] ?>]" value="<?=  $arrayTelefones[2]['telefone']; ?>">

                                    <?php
                                    } else {
                                    ?>

                                    <input type="text" data-mask="(00)00000-0000" class="form-control" id="recado" name="telefone3">

                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="box-footer">
                                <a href="?perfil=contratos&p=pesquisa&sp=pf_pesquisa" class="btn btn-default">Voltar a Pesquisa</a>
                                <input type="hidden" name="idPf" value="<?= $idPessoaFisica ?>">
                                <button type="submit" name="edita" id="edita" class="btn btn-primary pull-right"> Editar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
