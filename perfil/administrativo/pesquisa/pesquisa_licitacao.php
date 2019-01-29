<?php
$conn = bancoPDO();

if (isset($_POST['excluirLicitacao'])) {
    $idLicitacao = $_POST['excluirLicitacao'];
    $stmt = $conn->prepare("UPDATE`licitacoes` SET licitacao_status_id = '3' WHERE id = :id ");
    $stmt->execute(['id' => $idLicitacao]);
    if ($stmt->execute(['id' => $idLicitacao])) {
        $mensagem = mensagem("success", "Licitação cancelada com sucesso!");
        //gravarLog($sql);
    } else {
        $mensagem = mensagem("danger", "Erro ao cancelar licitação. Tente novamente!");
    }
}

$licitacoes = $conn->query("SELECT * FROM `licitacoes` WHERE publicado = '1'")->fetchAll();
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
                        <h3 class="box-title text-left">Lista de Licitações</h3>
                        <a href="?perfil=administrativo&p=licitacao&sp=licitacao_cadastro"
                           class="text-right btn btn-success" style="float: right">Adicionar Licitação</a>
                    </div>

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tblEquipamento" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nº SEI administrativo</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Editar</th>
                                <th>Cancelar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($licitacoes as $licitacao) {
                                $unidade = recuperaDados('unidades', 'id', $licitacao['unidade_id'])['nome'];
                                $status = recuperaDados('licitacao_status', 'id', $licitacao['licitacao_status_id'])['status'];
                                ?>
                                <tr>
                                    <td><?= $licitacao['numero_processo'] ?></td>
                                    <td><?= $licitacao['objeto'] ?></td>
                                    <td><?= $unidade ?></td>
                                    <td><?= $status ?></td>
                                    <td>
                                        <form action="?perfil=administrativo&p=licitacao&sp=licitacao_edita" method='POST'>
                                            <input type="hidden" name='editarLicitacao' value='<?= $licitacao['id'] ?>'>
                                            <button type='submit' class='btn btn-info'> Carregar</button>
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluirLicitacao" data-id='<?= $licitacao['id'] ?>' data-objeto='<?= $licitacao['objeto'] ?>' <?php if($licitacao['licitacao_status_id'] == 3) echo "disabled" ?> > Cancelar
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nº SEI administrativo</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Status</th>
                                <th>Editar</th>
                                <th>Cancelar</th>
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
        <div class="modal modal-danger fade in" id="excluirLicitacao" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Cancelar Licitação</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja cancelar a licitação? <span> </span> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Sair</button>
                        <form method='POST' id='formExcliuir'>
                            <input type="hidden" name='excluirLicitacao' value="<?= $licitacao['id'] ?>" >
                            <button type='submit' class="btn btn-outline"> Cancelar </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    $('#excluirLicitacao').on('show.bs.modal', (e) =>
    {
        document.querySelector('#excluirLicitacao .modal-body p span').innerHTML = ` ${e.relatedTarget.dataset.objeto}?`
        document.querySelector('#formExcliuir input[name="excluirLicitacao"]').value = e.relatedTarget.dataset.id
    });

</script>

