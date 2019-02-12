<?php
$conn = bancoPDO();
$con = bancoMysqli();

$sql = "SELECT  	co.id,
                    li.numero_processo,
                    co.termo_contrato,
                    li.objeto,
                    li.unidade_id,
                    co.tipo_servico,
                    co.tipo_pessoa_id,
                    co.pessoa_id
        FROM licitacoes as li INNER JOIN contratos as co on li.id = co.licitacao_id WHERE co.publicado = 1";

$contratos = $conn->query($sql)->fetchAll();

$queryCount = $conn->prepare($sql);
$queryCount->execute();
$count = $queryCount->rowCount();


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pesquisar</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Pesquisa de Contratos</h3>
                    </div>

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tblLicitacao" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nº do processo administrativo</th>
                                <th>CPF/CNPJ</th>
                                <th>Nome/Razão social</th>
                                <th>Termo de Contrato</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Equipamento</th>
                                <th>Tipo servoço</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
//                            if ($count > 0) {

                                foreach ($contratos as $contrato) {
                                    $unidade = recuperaDados("unidades","id",$contrato['unidade_id'])['nome'];

                                    $equipamento = recuperaDados("equipamentos","id","SELECT equipamento_id FROM contrato_equipamento WHERE contrato_id = ".$contrato['id'].")")['nome'];

                                    if ($contrato['tipo_pessoa_id'] == 1) {
                                        $fisica = recuperaDados("pessoa_fisicas","id",$contrato['pessoa_id']);
                                    } else {
                                        $juridica = recuperaDados("pessoa_juridicas","id",$contrato['pessoa_id']);
                                    }
                                    ?>
                                    <tr>
                                        <form action="?perfil=contratos&p=contrato_edita"
                                              method="post">
                                            <td><?= $contrato['numero_processo'] ?></td>
                                            <td><?= ($contrato['tipo_pessoa_id'] == 1)? $fisica['cpf']:$juridica['cnpj'] ?></td>
                                            <td><?= ($contrato['tipo_pessoa_id'] == 1)? $fisica['nome']:$juridica['razao_social'] ?></td>
                                            <td><?= $contrato['termo_contrato'] ?></td>
                                            <td><?= $contrato['objeto'] ?></td>
                                            <td><?= $unidade ?></td>
                                            <td></td>
                                            <td><?= $contrato['tipo_servico'] ?></td>
                                            <td>
                                                <input type="hidden" name="idContrato" value="<?= $contrato['id'] ?>">
                                                <input type="hidden" name="tipoPessoaId" value="<?= $contrato['tipo_pessoa_id'] ?>">
                                                <input type="hidden" name="pessoaId" value="<?= $contrato['pessoa_id'] ?>">
                                                <button class="btn btn-primary" type="submit" name="carregar">Carregar</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php
                                }
//                            } else {
//                                ?>
<!--                                <tr>-->
<!--                                    <td colspan="9" class="text-center">Não há contratos cadastrados</td>-->
<!--                                </tr>-->
<!--                                --><?php
//                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nº do processo administrativo</th>
                                <th>CPF/CNPJ</th>
                                <th>Nome/Razão social</th>
                                <th>Termo de Contrato</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Equipamento</th>
                                <th>Tipo servoço</th>
                                <th>Ação</th>
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
        <div class="modal modal-danger fade in" id="excluirLicitacao">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Cancelar Licitação</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja cancelar a licitação? <span> </span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Sair</button>
                        <form method='POST' id='formExcliuir'>
                            <input type="hidden" name='excluirLicitacao' value="<?= $licitacao['id'] ?>">
                            <button type='submit' class="btn btn-outline"> Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

    $('#excluirLicitacao').on('show.bs.modal', (e) => {
        document.querySelector('#excluirLicitacao .modal-body p span').innerHTML = ` ${e.relatedTarget.dataset.objeto}?`
        document.querySelector('#formExcliuir input[name="excluirLicitacao"]').value = e.relatedTarget.dataset.id
    });

    $(function () {
        $('#tblLicitacao').DataTable({
            "language": {
                "url": 'bower_components/datatables.net/Portuguese-Brasil.json'
            },
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7 text-right'p>>",
        });
    });

</script>

