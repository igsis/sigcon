<?php
$conn = bancoPDO();
$con = bancoMysqli();

if (isset($_POST['idLicitacao'])) {
    $idLicitacao = $_POST['idLicitacao'];
}

if (isset($_POST['excluir'])){
    $idPessoaJuridica = $_POST['idPessoaJuridicaModal'];

    $sql = "UPDATE pessoa_juridicas SET publicado = 0 WHERE id = '$idPessoaJuridica'";
    if (mysqli_query($con,$sql)){
        $mensagem = mensagem("success","Pessoa Jurídica apagada com sucesso.");
        gravarLog($sql);
    }else{
        $mensagem = mensagem("danger",die(mysqli_errno($con)));
    }
}

$pessoa_juridica = $conn->query('SELECT * FROM pessoa_juridicas WHERE publicado = 1')->fetchAll();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pesquisar
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista de Pessoa Jurídica</h3>
                        <a href="?perfil=contratos&p=pessoa_juridica&sp=pj_cadastro" class="text-right btn btn-success" style="float: right">Adicionar Pessoa Jurídica</a>
                    </div>

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tblPj" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Razão Social</th>
                                <th>CNPJ</th>
                                <th>E-mail</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($pessoa_juridica as $pj)
                            {
                                ?>
                                <tr>
                                    <td><?=$pj['razao_social']?></td>
                                    <td><?=$pj['cnpj']?></td>
                                    <td><?=$pj['email']?></td>
                                    <td>
                                        <?php
                                        if (isset($_POST['idLicitacao']))
                                        {
                                            ?>
                                            <div id="FormSelecionar" style="float: left; padding: 5px;">
                                                <form action="?perfil=contratos&p=contrato_cadastro"
                                                      method="post">
                                                    <input type="hidden" name="tipoPessoa" value="2">
                                                    <input type="hidden" name="idPj" id="idPj" value="<?= $pj['id'] ?>">
                                                    <input type="hidden" name="idLicitacao" id="idLicitacao" value="<?= $_POST['idLicitacao'] ?>">
                                                    <input class="btn btn-warning" name="selecionar" type="submit" value="Selecionar">
                                                </form>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div id="FormAcao" style="padding: 5px;">
                                            <form action="?perfil=contratos&p=pessoa_juridica&sp=pj_edita" method="post">
                                                <input type="hidden" name="idPj" id="idPj" value="<?= $pj['id'] ?>">
                                                <input type="hidden" name="carregar" id="carregar">
                                                <input class="btn btn-info" type="submit" value="Editar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#exclusao" data-nome="<?= $pj['razao_social'] ?>"
                                                        data-id="<?= $pj['id'] ?>">Apagar
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
                                <th>Razão Social</th>
                                <th>CNPJ</th>
                                <th>E-mail</th>
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
        <div id="exclusao" class="modal modal-danger modal fade in" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmação de Exclusão</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir a pessoa jurídica?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="?perfil=contratos&p=pesquisa&sp=pj_pesquisa" method="post">
                            <input type="hidden" name="idPessoaJuridicaModal" id="idPessoaJuridicaModal" value="">
                            <input type="hidden" name="apagar" id="apagar">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-danger btn-outline" type="submit" name="excluir" value="Apagar">
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

<script defer>
    $(function () {
        $('#tblPj').DataTable({
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

            $(this).find('p').text(`Tem certeza que deseja excluir a pessoa jurídica ${nome} ?`);
            $(this).find('#idPessoaJuridicaModal').attr('value', `${id}`);
        })
    })
</script>