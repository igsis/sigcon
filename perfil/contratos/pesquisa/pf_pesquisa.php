<?php

$con = bancoMysqli();

if (isset($_POST['idLicitacao'])) {
    $idLicitacao = $_POST['idLicitacao'];
}

$exibir = ' ';
$resultado = "<td></td>";

if (isset($_POST['procurar'])){

    $cpf = $_POST['procurar'] ?? NULL;

    if ($cpf != NULL ) {

        $queryCPF = "SELECT id, nome, cpf, email
                         FROM pessoa_fisicas
                         WHERE cpf = '$cpf'";

        if ($result = mysqli_query($con,$queryCPF)) {

            $resultCPF = mysqli_num_rows($result);

            if ($resultCPF > 0){

                $exibir = true;
                $resultado = "";

                foreach($result as $pessoa){

                    $resultado .= "<tr>";
                    $resultado .= "<td>".$pessoa['nome']."</td>";
                    $resultado .= "<td>".$pessoa['cpf']."</td>";
                    $resultado .= "<td>".$pessoa['email']."</td>";
                    $resultado .= "<td>
                                     <form action='?perfil=contratos/contrato_cadastro' method='post'>
                                        <input type='hidden' name='idPf' value='".$pessoa['id']."'>
                                        <input type='hidden' name='idLicitacao' value='".$idLicitacao."'>
                                        <input type='submit' name='carregar' class='btn btn-primary' name='selecionar' value='Selecionar'>
                                     </form>
                               </td>";
                    $resultado .= "</tr>";
                }
            }else {

                $exibir = false;
                $resultado = "<td colspan='4'>
                        <span style='margin: 50% 40%;'>Sem resultados</span>
                      </td>
                      <td>
                        <form method='post' action='?perfil=contratos/pf_cadastro'>
                            <input type='hidden' name='documentacao' value='$cpf'>
                            <button class=\"btn btn-primary\" name='adicionar' type='submit'>
                                <i class=\"glyphicon glyphicon-plus\">        
                                </i>Adicionar
                            </button>
                        </form>
                      </td>";

            }
        }
    }
}

if (isset($_POST['cadastrar'])) {
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

    // cadastrar endereco de pf
    $sqlEndereco = "INSERT INTO `enderecos`
                                (`cep`,
                                 `logradouro`,
                                 `bairro`,
                                 `cidade`,
                                 `estado`,
                                 `numero`,
                                 `complemento`)
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

        $sqlPf = "INSERT INTO `pessoa_fisicas`
                            (`nome`,
                             `cpf`,
                             `email`,
                             `endereco_id`,
                             `publicado`)
                      VALUES ('$nome_pf',
                              '$cpf',
                              '$email',
                              '$endereco_id',
                              '1')";

        if ($con->query($sqlPf))
        {
            gravarLog($sqlPf);
            $idPf = $con->insert_id;

            foreach ($telefones as $telefone)
            {
                if ($telefone != '')
                {
                    // cadastrar o telefone de pf
                    $sqlTelefone = "INSERT INTO `pf_telefones` (`pessoa_fisica_id`, `telefone`) VALUES ('$idPf', '$telefone')";

                    if ($con->query($sqlTelefone))
                    {
                        gravarLog($sqlTelefone);
                    }
                }
            }
        }
        else
        {
            $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");
        }
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");
    }
}

if (isset($_POST['apagar']))
{
    $idPf = $_POST['idPf'];
    $sqlApagar = "UPDATE `pessoa_fisicas` SET `publicado` = '0' WHERE `id` = '$idPf'";

    if ($con->query($sqlApagar))
    {
        gravarLog($sqlApagar);
        $mensagem = mensagem("success", "Pessoa Fisica apagada com sucesso!");
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao apagar! Tente novamente.");
    }
}

$sqlPf = "SELECT `id`, `nome`, `cpf`, `email` FROM `pessoa_fisicas` WHERE publicado = '1'";
$queryPf = $con->query($sqlPf);

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pesquisar
            <small>Pessoa Física</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista Pessoa Física</h3>
                        <a href="?perfil=contratos&p=pessoa_fisica&sp=pf_cadastro" class="text-right btn btn-success" style="float: right">Adicionar Pessoa Física</a>
                    </div>
                    <!-- /.box-header -->

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>

                    <div class="box-body">
                        <table id="tblPf" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($queryPf as $pf)
                            {
                                ?>
                                <tr>
                                    <td><?=$pf['nome']?></td>
                                    <td><?=$pf['cpf']?></td>
                                    <td><?=$pf['email']?></td>
                                    <td>
                                        <?php
                                        if (isset($_POST['idLicitacao']))
                                        {
                                            ?>
                                            <div id="FormSelecionar" style="float: left; padding: 5px;">
                                                <form action="?perfil=contratos&p=contrato_cadastro"
                                                      method="post">
                                                    <input type="hidden" name="tipoPessoa" value="1">
                                                    <input type="hidden" name="idPf" id="idPf" value="<?= $pf['id'] ?>">
                                                    <input type="hidden" name="idLicitacao" id="idLicitacao" value="<?= $_POST['idLicitacao'] ?>">
                                                    <input class="btn btn-warning" name="selecionar" type="submit" value="Selecionar">
                                                </form>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div id="FormAcao" style="padding: 5px;">
                                            <form action="?perfil=contratos&p=pessoa_fisica&sp=pf_edita" method="post">
                                                <input type="hidden" name="idPf" id="idPf" value="<?= $pf['id'] ?>">
                                                <input type="hidden" name="carregar" id="carregar">
                                                <input class="btn btn-info" type="submit" value="Editar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#exclusao" data-nome="<?= $pf['nome'] ?>"
                                                        data-id="<?= $pf['id'] ?>">Apagar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Ações</th>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!--.modal-->
        <div id="exclusao" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmação de Exclusão</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deseja Realmente Excluir?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="?perfil=contratos&p=pesquisa&sp=pf_pesquisa" method="post">
                            <input type="hidden" name="idPf" id="idPf" >
                            <input type="hidden" name="apagar" id="apagar">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-danger" type="submit" value="Apagar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" defer>
    $(function () {
        $('#tblPf').DataTable({
            "language": {
                "url": 'bower_components/datatables.net/Portuguese-Brasil.json'
            },
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7 text-right'p>>",
        });

        $('#exclusao').on('show.bs.modal', function (e) {
            let nome = $(e.relatedTarget).attr('data-nome');
            let id = $(e.relatedTarget).attr('data-id');

            $(this).find('p').text(`Deseja realmente excluir: ${nome}`);
            $(this).find('#idPf').attr('value', `${id}`);
        })
    })
</script>