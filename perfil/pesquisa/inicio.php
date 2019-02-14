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

$licitacoes = $conn->query("
  SELECT lic.id AS idLicitacao, licitacao_id, numero_processo, termo_contrato, objeto, licitacao, ordem_inicio, homologacao, contrato_status_id, lic.unidade_id, tipo_pessoa_id, pessoa_id, licitacao_status_id FROM `licitacoes` AS lic 
    LEFT JOIN (SELECT * FROM contratos WHERE publicado = '1') As con ON lic.id = con.licitacao_id 
  WHERE lic.publicado = '1'")->fetchAll();

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pesquisar</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista de Licitações</h3>
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
                                <th>Nº SEI administrativo</th>
                                <th>Homologação/Recurso</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Licitação</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($licitacoes as $licitacao) {

                                if ($licitacao['licitacao_status_id'] != 2) {

                                    $unidade = recuperaDados('unidades', 'id', $licitacao['unidade_id'])['nome'];
                                    $status = recuperaDados('licitacao_status', 'id', $licitacao['licitacao_status_id'])['status'];

                                    if ($licitacao['tipo_pessoa_id'] == 1) {
                                        $proponente = recuperaDados('pessoa_fisicas', 'id', $licitacao['pessoa_id'])['nome'];
                                        $documento = recuperaDados('pessoa_fisicas', 'id', $licitacao['pessoa_id'])['cpf'];
                                    } else {
                                        $proponente = recuperaDados('pessoa_juridicas', 'id', $licitacao['pessoa_id'])['razao_social'];
                                        $documento = recuperaDados('pessoa_juridicas', 'id', $licitacao['pessoa_id'])['cnpj'];
                                    }

                                    ?>
                                    <tr>
                                        <td><?= $licitacao['numero_processo'] ?></td>
                                        <?php if($licitacao['homologacao'] == 1) {
                                            ?>
                                            <td class="text-center">SIM</td>
                                            <?php
                                        }else {
                                            ?>
                                            <td class="text-center">NÃO</td>
                                            <?php
                                        }
                                        ?>
                                        <td><?= $licitacao['objeto'] ?></td>
                                        <td><?= $unidade ?></td>
                                        <td>Agendado para: <b><?= exibirDataBr($licitacao['licitacao']) ?></b></td>
                                        <td><?= $status ?></td>
                                        <td>
                                            <form action="?perfil=pesquisa&p=pesquisa_carregar" method='POST'>
                                                <input type="hidden" name='idLicitacao'
                                                       value='<?= $licitacao['idLicitacao'] ?>'>
                                                <input type="hidden" name="proponente" value="<?= $proponente ?>">
                                                <input type="hidden" name="documento" value="<?= $documento ?>">
                                                <input type="hidden" name="tipoPessoa"
                                                       value="<?= $licitacao['tipo_pessoa_id'] ?>">
                                                <button type='submit' class='btn btn-info'> Carregar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nº SEI administrativo</th>
                                <th>Homologação/Recurso</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Licitação</th>
                                <th>Status</th>
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



        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title text-left">Lista de Contratos</h3>
                    </div>

                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tblContrato" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nº SEI administrativo</th>
                                <th>Termo de contrato</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Proponente</th>
                                <th>Documento</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($licitacoes as $licitacao) {

                                if ($licitacao['licitacao_status_id'] == 2) {

                                    $unidade = recuperaDados('unidades', 'id', $licitacao['unidade_id'])['nome'];
                                    $status = recuperaDados('contrato_status', 'id', $licitacao['contrato_status_id'])['status'];
                                    if ($licitacao['tipo_pessoa_id'] != NULL) {
                                        if ($licitacao['tipo_pessoa_id'] == 1) {
                                            $proponente = recuperaDados('pessoa_fisicas', 'id', $licitacao['pessoa_id'])['nome'];
                                            $documento = recuperaDados('pessoa_fisicas', 'id', $licitacao['pessoa_id'])['cpf'];
                                        } else {
                                            $proponente = recuperaDados('pessoa_juridicas', 'id', $licitacao['pessoa_id'])['razao_social'];
                                            $documento = recuperaDados('pessoa_juridicas', 'id', $licitacao['pessoa_id'])['cnpj'];
                                        }
                                    } else {
                                        $proponente = NULL;
                                        $documento = NULL;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $licitacao['numero_processo'] ?></td>
                                        <td><?= $licitacao['termo_contrato'] ?></td>
                                        <td><?= $licitacao['objeto'] ?></td>
                                        <td><?= $unidade ?></td>
                                        <td><?= $proponente ?></td>
                                        <td><?= $documento ?></td>
                                        <td><?= $status ?></td>
                                        <td>
                                            <form action="?perfil=pesquisa&p=pesquisa_carregar" method='POST'>
                                                <input type="hidden" name='idLicitacao'
                                                       value='<?= $licitacao['idLicitacao'] ?>'>
                                                <input type="hidden" name="proponente" value="<?= $proponente ?>">
                                                <input type="hidden" name="documento" value="<?= $documento ?>">
                                                <input type="hidden" name="tipoPessoa"
                                                       value="<?= $licitacao['tipo_pessoa_id'] ?>">
                                                <button type='submit' class='btn btn-info'> Carregar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nº SEI administrativo</th>
                                <th>Termo de contrato</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Proponente</th>
                                <th>Documento</th>
                                <th>Status</th>
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
    </section>
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

    $(function () {
        $('#tblContrato').DataTable({
            "language": {
                "url": 'bower_components/datatables.net/Portuguese-Brasil.json'
            },
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7 text-right'p>>",
        });
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