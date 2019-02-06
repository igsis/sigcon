<?php

$con = bancoMysqli();
$conn = bancoPDO();

if(isset($_POST['idPj'])){
    $idPessoaJuridica = $_POST['idPj'];
}


if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idPessoaJuridica = $_POST['idPessoaJuridica'] ?? NULL;
    $razao_social = addslashes($_POST['razao_social']);
    $cnpj = $_POST['cnpj'];
    $email = $_POST['email'];
    $telefones = $_POST['telefone'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? NULL;
    $uf = $_POST['uf'];
    $cidade = $_POST['cidade'];
    $contato = $_POST['contato'];

    if (isset($_POST['cadastra'])) {
        // cadastrar endereco de pj
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

        if (mysqli_query($con, $sqlEndereco)) {

            gravarLog($sqlEndereco);

            $endereco_id = recuperaUltimo("enderecos");

            $sql = "INSERT INTO pessoa_juridicas
                                (razao_social,
                                 cnpj,
                                 email,
                                 contato,
                                 endereco_id,
                                 publicado)
                          VALUES ('$razao_social',
                                  '$cnpj',
                                  '$email',
                                  '$contato',
                                  '$endereco_id',
                                  '1')";

            if (mysqli_query($con, $sql)) {

                $idPessoaJuridica = recuperaUltimo('pessoa_juridicas');

                foreach ($telefones as $telefone) {
                    if ($telefone != '') {
                        // cadastrar o telefone de pj
                        $sqlTelefone = "INSERT INTO pj_telefones
                                      (pessoa_juridica_id,
                                       telefone)
                              VALUES  ('$idPessoaJuridica',
                                       '$telefone')";


                        if (mysqli_query($con, $sqlTelefone)) {

                            gravarLog($sqlTelefone);

                            $mensagem = mensagem("success", "Cadastrado com sucesso!");
                        }
                    }
                }
            }
        } else {
            $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");

        }
    }

    if (isset($_POST['edita'])) {

        $sql = "UPDATE pessoa_juridicas SET
                                 razao_social = '$razao_social',
                                 cnpj = '$cnpj',
                                 email = '$email',
                                 contato = '$contato'
                          WHERE id = '$idPessoaJuridica'";

        $pj = recuperaDados('pessoa_juridicas', 'id', $idPessoaJuridica);
        $endereco_id = $pj['endereco_id'];

        if (isset($_POST['telefone2'])) {
            $telefone2 = $_POST['telefone2'];
            $sqlTelefone2 = "INSERT INTO pj_telefones (pessoa_juridica_id, telefone) VALUES ('$idPessoaJuridica', '$telefone2')";
            $query = mysqli_query($con, $sqlTelefone2);
        }

        if (isset($_POST['telefone3'])) {
            $telefone3 = $_POST['telefone3'];
            $sqlTelefone3 = "INSERT INTO pj_telefones (pessoa_juridica_id, telefone) VALUES ('$idPessoaJuridica', '$telefone3')";
            $query = mysqli_query($con, $sqlTelefone3);
        }

        if (mysqli_query($con, $sql)) {

            foreach ($telefones as $idTelefone => $telefone) {

                if (!strlen($telefone)) {
                    // Deletar telefone do banco se for apagado.
                    $sqlDelete = "DELETE FROM pj_telefones WHERE id = '$idTelefone'";
                    mysqli_query($con, $sqlDelete);
                    gravarLog($sqlDelete);
                }

                if ($telefone != '') {
                    // editar o telefone de pj
                    $sqlTelefone = "UPDATE  pj_telefones SET
                                          telefone = '$telefone'
                                  WHERE id = '$idTelefone'";
                    mysqli_query($con, $sqlTelefone);
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

$sqlTelefones = "SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$idPessoaJuridica'";
$arrayTelefones = $conn->query($sqlTelefones)->fetchAll();

$pessoa_juridica = recuperaDados("pessoa_juridicas", "id", $idPessoaJuridica);
$pj_endereco = recuperaDados("enderecos", "id", $endereco_id);

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
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>

                    <form method="POST" action="?perfil=contratos&p=pessoa_juridica&sp=pj_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="razao_social">Razão Social *</label>
                                    <input type="text" class="form-control" id="razao_social" name="razao_social" maxlength="170" value="<?= $pessoa_juridica['razao_social'] ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cnpj">CNPJ *</label>
                                    <input type="text" data-mask="00.000.000/0000-00" minlength="18" class="form-control" id="cnpj" name="cnpj" value="<?= $pessoa_juridica['cnpj'] ?>" required onblur="validacao()">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cep">CEP *</label>
                                    <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" minlength="9" value="<?= $pj_endereco['cep'] ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="logradouro">Rua</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="200" readonly value="<?= $pj_endereco['logradouro'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero">Número *</label>
                                    <input type="number" class="form-control" id="numero" name="numero" value="<?= $pj_endereco['numero'] ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento </label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="25" value="<?= $pj_endereco['complemento'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" readonly value="<?= $pj_endereco['bairro'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" readonly value="<?= $pj_endereco['cidade'] ?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="uf">Estado</label>
                                    <input type="text" class="form-control" id="uf" name="uf" readonly value="<?= $pj_endereco['estado'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail * </label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" value="<?= $pessoa_juridica['email'] ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1 * </label>
                                    <input type="text" data-mask="(00) 0000-0000" required class="form-control" id="telefone" name="telefone[<?= $arrayTelefones[0]['id'] ?>]" value="<?= $arrayTelefones[0]['telefone']; ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="celular">Telefone #2 </label>
                                    <?php
                                    if (isset($arrayTelefones[2])) {
                                    ?>
                                        <input type="text" data-mask="(00)00000-0000" class="form-control" id="celular" name="telefone[<?= $arrayTelefones[1]['id'] ?>]" value="<?= $arrayTelefones[1]['telefone']; ?>">
                                    <?php
                                    } else {
                                    ?>
                                        <input type="text" data-mask="(00) 00000-0000" class="form-control" id="celular" name="telefone2">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="recado">Telefone #3</label>
                                    <?php if (isset($arrayTelefones[2])) {
                                        ?>
                                        <input type="text" data-mask="(00) 00000-0000" class="form-control" id="recado" name="telefone[<?= $arrayTelefones[2]['id'] ?>]" value="<?=  $arrayTelefones[2]['telefone']; ?>">

                                        <?php
                                    } else {
                                        ?>

                                        <input type="text" data-mask="(00) 00000-0000" class="form-control" id="recado" name="telefone3">

                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="contato">Contato na empresa: </label>
                                    <input type="text" class="form-control" id="contato" name="contato" maxlength="150" value="<?= $pessoa_juridica['contato'] ?>" required>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="idPessoaJuridica" value="<?= $idPessoaJuridica ?>">
                                <button type="submit" name="edita" id="edita" class="btn btn-primary pull-right"> Gravar </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    function validarCNPJ(cnpj) {

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

        var cnpj = document.querySelector('#cnpj').value

        console.log(cnpj);

        // tira os pontos do valor, ficando apenas os numeros
        cnpj = cnpj.replace(/[^\d]+/g,'');

        //console.log(cnpj);

        var validado = validarCNPJ(cnpj);

        //console.log(teste);

        if(!validado){
            alert('CNPJ inválido');

            document.querySelector("#edita").disabled = true;
        }else if(validado){
            document.querySelector("#edita").disabled = false;
        }
    }


</script>