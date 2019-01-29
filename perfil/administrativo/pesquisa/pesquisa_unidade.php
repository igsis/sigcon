<?php
include "../perfil/includes/menu.php";
$conn = bancoPDO();
$con = bancoMysqli();

$sql = "SELECT * FROM unidades WHERE publicado = 1";
$unidades = $conn->query($sql)->fetchAll();

if (isset($_POST['excluir'])){
    $idUnidade = $_POST['idUnidadeModal'];

    $sql = "UPDATE unidades SET publicado = 0 WHERE id = '$idUnidade'";
    if (mysqli_query($con,$sql)){
        $mensagem = mensagem("success","Uniadde apagada com sucesso.");
        gravarLog($sql);
    }else{
        $mensagem = mensagem("danger",die(mysqli_errno($con)));
    }

    $unidades = $conn->query("SELECT * FROM unidades WHERE publicado = 1")->fetchAll();
}

$unidade = $conn->query($sql);
$count = $unidade->rowCount();


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pesquisar
            <small>Unidades</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista de Unidades</h3>
                        <a href="?perfil=administrativo&p=unidades&sp=unidade_cadastro" class="text-right btn btn-success" style="float: right">Adicionar Unidade</a>
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
                                <th>Nome da unidade</th>
                                <th>Sigla</th>
                                <th>Unidade Orçamentária</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($count > 0){

                            foreach ($unidades as $unidade)
                            {
                                ?>
                                <tr>
                                    <td><?=$unidade['nome']?></td>
                                    <td><?=$unidade['sigla']?></td>
                                    <td><?=$unidade['unidade_orcamentaria']?></td>
                                    <td>
                                        <form action="?perfil=administrativo&p=unidades&sp=unidade_edita" method="post">
                                            <input type="hidden" name="idUnidade" id="idUnidade" value="<?=$unidade['id']?>">
                                            <input type="hidden" name="carregar" id="carregar">
                                            <input class="btn btn-primary" type="submit" value="Carregar">
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao" data-nome="<?=$unidade['nome']?>" data-id="<?=$unidade['id']?>">Apagar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tfoot>
                            <tr>
                                <th>Nome da unidade</th>
                                <th>Sigla</th>
                                <th>Unidade Orçamentária</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                            <?php }
                                    else{
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center">Não há registros cadastrados</td>
                                </tr>
                            <?php }?>
                            </tbody>
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
                        <p>Tem certeza que deseja excluir a unidade?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="?perfil=administrativo&p=pesquisa&sp=pesquisa_unidade" method="post">
                            <input type="hidden" name="idUnidadeModal" id="idUnidadeModal" value="">
                            <input type="hidden" name="apagar" id="apagar">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-danger btn-outline" type="submit" name="excluir" value="Apagar">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--    @TODO: Alinhar Pesquisar do plugin DataTable a direita-->
    <!-- /.content -->
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script defer>
    $(function () {
        $('#tblEquipamento').DataTable({
            "language": {
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                },
                "search": "Pesquisar: ",
                "lengthMenu": 'Exibir <select>'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="30">30</option>'+
                    '<option value="40">40</option>'+
                    '<option value="50">50</option>'+
                    '<option value="-1">Todos</option>'+
                    '</select> Registros',
                "info": "Exibindo página _PAGE_ de _PAGES_",
                "infoEmpty": "Exibindo _START_ a _END_ de _TOTAL_ registros",
                "infoFiltered": "(filtrado de _MAX_ registros totais)"
            },
            responsive: true
        })

        $('#exclusao').on('show.bs.modal', function (e) {
            let nome = $(e.relatedTarget).attr('data-nome');
            let id = $(e.relatedTarget).attr('data-id');

            $(this).find('p').text(`Tem certeza que deseja excluir a unidade ${nome} ?`);
            $(this).find('#idUnidadeModal').attr('value', `${id}`);
        })
    })
</script>