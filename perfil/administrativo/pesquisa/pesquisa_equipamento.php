<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();

if (isset($_POST['apagar']))
{
    $idEquipamento = $_POST['idEquipamento'];
    $sqlApagar = "UPDATE `equipamentos` SET `publicado` = '0' WHERE `id` = '$idEquipamento'";

    if ($con->query($sqlApagar))
    {
        gravarLog($sqlApagar);
        $mensagem = mensagem("success", "Equipamento apagado com sucesso!");
    }
}

$sqlEquipamento = "SELECT e.id, e.nome AS 'equipamento', u.nome AS 'unidade' FROM `equipamentos` AS e
                    INNER JOIN `unidades` AS u on e.unidade_id = u.id 
                    WHERE e.publicado = '1'";
$queryEquipamento = $con->query($sqlEquipamento);

$lista = ($queryEquipamento->num_rows > 0) ? true : false;


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pesquisar
            <small>Pessoa Jurídica</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista Pessoa Jurídica</h3>
                        <a href="?perfil=administrativo&p=equipamentos&sp=equipamento_cadastro" class="text-right btn btn-success" style="float: right">Adicionar Equipamento</a>
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
                                <th>Nome do Equipamento</th>
                                <th>Unidade</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($lista)
                            {
                            foreach ($queryEquipamento as $equipamento)
                            {
                                ?>
                                <tr>
                                    <td><?=$equipamento['equipamento']?></td>
                                    <td><?=$equipamento['unidade']?></td>
                                    <td>
                                        <form action="?perfil=administrativo&p=equipamentos&sp=equipamento_edita" method="post">
                                            <input type="hidden" name="idEquipamento" id="idEquipamento" value="<?=$equipamento['id']?>">
                                            <input type="hidden" name="carregar" id="carregar">
                                            <input class="btn btn-primary" type="submit" value="Carregar">
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao">Apagar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tfoot>
                            <tr>
                                <th>Nome do Equipamento</th>
                                <th>Unidade</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                            <?php
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center">Não há registros cadastrados</td>
                                </tr>
                                <?php
                            }
                            ?>
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
                        <form action="?perfil=administrativo&p=pesquisa&sp=pesquisa_equipamento" method="post">
                            <input type="hidden" name="idEquipamento" id="idEquipamento" value="<?=$equipamento['id']?>">
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
    })
</script>