<?php
include "../perfil/includes/menu.php";

$conn = bancoPDO();
$con = bancoMysqli();

$idContrato = $_POST['idContrato'];

$sql = "SELECT ce.id, equipamento.nome, unidade.nome unidade_nome FROM contrato_equipamento ce INNER JOIN equipamentos equipamento ON ce.equipamento_id = equipamento.id INNER JOIN unidades unidade ON equipamento.unidade_id = unidade.id WHERE ce.publicado = 1 AND ce.contrato_id = '$idContrato'";

$equipamentos = $conn->query($sql)->fetchAll();

$queryCount = $conn->prepare($sql);
$queryCount->execute();
$count = $queryCount->rowCount();

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Exibir Equipamentos</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Equipamentos Atendidos</h3>
                        <form method="POST" action="?perfil=contratos&p=equipamentos&sp=equipamento_cadastra" role="form">
                            <input type="hidden" name="idContrato" value="<?= $idContrato ?>">
                            <button type="submit" name="listaEquipamentos" class="btn btn-primary pull-right">Listar Equipamentos</button>
                        </form>
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
                                <th>Equipamento</th>
                                <th>Unidade</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($equipamentos as $equipamento) {
                                    ?>
                                    <tr>
                                        <form action="?perfil=contratos&p=equipamentos&sp=equipamento_edita"
                                              method="post">
                                            <td><?= $equipamento['nome'] ?></td>
                                            <td><?= $equipamento['unidade_nome'] ?></td>

                                            <td>
                                                <input type="hidden" name="idContratoEquipamento" value="<?= $equipamento['id'] ?>">
                                                <button class="btn btn-primary" type="submit" name="alterar">Alterar</button>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php
                                }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Equipamento</th>
                                <th>Unidade</th>
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

