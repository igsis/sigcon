<?php

$con = bancoMysqli();

if (isset($_POST['cadastrar'])) {
    $idEquipamento = $_POST['idEquipamento'] ?? NULL;
    $equip_nome = $_POST['equip_nome'];
    $unidade_id = $_POST['unidade_id'];

    $sql = "INSERT INTO equipamentos (nome, unidade_id) VALUES ('$equip_nome', '$unidade_id')";

    if ($con->query($sql))
    {
        gravarLog($sql);
        $idEquipamento = $con->insert_id;
        $mensagem = mensagem("success", "Equipamento cadastrado com sucesso!");
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
    }
}

if (isset($_POST['apagar']))
{
    $idEquipamento = $_POST['idEquipamento'];
    $sqlApagar = "UPDATE `equipamentos` SET `publicado` = '0' WHERE `id` = '$idEquipamento'";

    if ($con->query($sqlApagar))
    {
        gravarLog($sqlApagar);
        $mensagem = mensagem("success", "Equipamento apagado com sucesso!");
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao apagar equipamento! Tente novamente.");
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
            <small>Equipamento</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista de Equipamentos</h3>
                        <a href="?perfil=administrativo&p=equipamentos&sp=equipamento_cadastro" class="text-right btn btn-success" style="float: right">Adicionar Equipamento</a>
                    </div>
                    <!-- /.box-header -->

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>

                    <div class="box-body">
                        <table id="tblEquipamento" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Nome do Equipamento</th>
                                <th>Unidade</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
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
                                        <input class="btn btn-info" type="submit" value="Editar">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exclusao" data-nome="<?=$equipamento['equipamento']?>" data-id="<?=$equipamento['id']?>">Apagar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome do Equipamento</th>
                                <th>Unidade</th>
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
                            <input type="hidden" name="idEquipamento" id="idEquipamento" >
                            <input type="hidden" name="apagar" id="apagar">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input class="btn btn-danger" type="submit" value="Apagar">
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

            $(this).find('p').text(`Deseja realmente excluir o equipamento: ${nome}`);
            $(this).find('#idEquipamento').attr('value', `${id}`);
        })
    })
</script>