<?php
$conn = bancoPDO();

$sql = "SELECT    pa.id,
                  pa.tipo_pessoa_id,
                  pa.pessoa_id,
                  li.numero_processo
        FROM pagamentos pa INNER JOIN contratos c2 on pa.contrato_id = c2.id 
        INNER JOIN licitacoes li on li.id = c2.licitacao_id";

$pagamentos = $conn->query($sql)->fetchAll();

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
                        <h3 class="box-title text-left">Pesquisa de Pagamentos</h3>
                        <a href="?perfil=administrativo&p=pesquisa&sp=pesquisa_contrato_pagamento"
                           class="text-right btn btn-success" style="float: right">Adicionar Pagamento</a>
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
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($count>0) {
                                foreach ($pagamentos as $pagamento) {
                                    if ($pagamento['pessoa_id'] == 1) {
                                        $pessoa = $conn->query("SELECT nome, cpf as documento FROM pessoas_fisicas WHERE id='" . $pagamento['pessoa_id'] . "'")->fetchAll();
                                    } else {
                                        $pessoa = $conn->prepare("SELECT razao_social as nome, CNPJ as documento FROM pessoas_juridicas WHERE id='" . $pagamento['pessoa_id'] . "'")->fetchAll();
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $pagamento['numero_processo'] ?></td>
                                        <td><?= $pessoa['documento'] ?></td>
                                        <td><?= $pessoa['nome'] ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" value="<?= $pagamento['id'] ?>">
                                                <button class="btn btn-primary" type="submit">Visualizar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                ?>
                                <tr>
                                    <td colspan="4" class="text-center">Não há pagamentos cadastrados</td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nº do processo administrativo</th>
                                <th>CPF/CNPJ</th>
                                <th>Nome/Razão social</th>
                                <th></th>
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

