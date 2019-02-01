<?php

$con = bancoMysqli();
$conn = bancoPDO();

$dtHoje = date("Y-m-d");
$data = DateTime::createFromFormat("Y-m-d", $dtHoje);

//Licitações na que foram empenhadas
$sqlEmpenho = "SELECT * FROM licitacoes WHERE empenho = 1 ORDER BY numero_processo";
$query = mysqli_query($con,$sqlEmpenho);
$num_empenhadas = mysqli_num_rows($query);
$licitacoes_empenhadas = $conn->query($sqlEmpenho)->fetchAll();


//Licitações na fase homologação
$sqlHomologacao = "SELECT * FROM licitacoes WHERE homologacao = 1 AND empenho = 0 ORDER BY numero_processo";
$num_homologadas = $conn->query($sqlHomologacao)->rowCount();
$licitacoes_homologadas = $conn->query($sqlHomologacao)->fetchAll();


//Contratos com vencimento menor que 45 dias
$sqlContrato = "SELECT cont.id, cont.licitacao_id, lici.numero_processo, lici.objeto, termo_contrato, tipo_pessoa_id, pessoa_id, vencimento, cont.publicado 
                FROM contratos as cont LEFT JOIN licitacoes as lici ON cont.licitacao_id = lici.id 
                WHERE cont.publicado = 1 ORDER BY vencimento";

$contratos = $conn->query($sqlContrato)->fetchAll();

$contratosAvencer = [];

    foreach ($contratos as $contrato) {

        $vencimento = DateTime::createFromFormat("Y-m-d", $contrato['vencimento']);
        $diferenca = date_diff($data, $vencimento);

        if ($diferenca->days < 45) {
            array_push($contratosAvencer, $contrato);
        }

        if ($contrato['tipo_pessoa_id'] == 1) {
            $idPF = $contrato['pessoa_id'];
            $sqlPF = "SELECT nome FROM pessoa_fisicas WHERE id = '$idPF'";
            $pessoa_fisica = $conn->query($sqlPF)->fetch();
            $tipoPessoa = 1;

        }elseif ($contrato['tipo_pessoa_id'] == 2) {
            $idPJ = $contrato['pessoa_id'];
            $sqlPJ = "SELECT razao_social FROM pessoa_juridicas WHERE id = '$idPJ'";
            $pessoa_juridica = $conn->query($sqlPJ)->fetch();
            $tipoPessoa = 2;
        }
    }


$qtdeAvencer = count($contratosAvencer);

?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <h2 class="page-header"><?= saudacao();?></h2>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title text-bold">Contratos à vencer dentro de 45 dias!</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            if($qtdeAvencer > 0)
                            {
                                ?>
                                    <table id="tblLicitacao" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nº SEI administrativo</th>
                                        <th>Proponente</th>
                                        <th>Termo de contrato</th>
                                        <th>Vencimento</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($contratos as $contrato) {
                                        ?>
                                        <tr>
                                            <td><?= $contrato['numero_processo'] ?></td>

                                            <?php
                                            if ($tipoPessoa == 1) {
                                                ?>

                                                <td><?= $pessoa_fisica['nome'] ?></td>

                                                <?php
                                            } else {
                                                ?>

                                                <td><?= $pessoa_juridica['razao_social'] ?></td>

                                                <?php
                                            }
                                            ?>

                                            <td><?= $contrato['termo_contrato'] ?></td>
                                            <td><?= exibirDataBr($contrato['vencimento']) ?></td>
                                            <td>
                                                <form action="?perfil=contratos&p=contrato_edita" method='POST'>
                                                    <input type="hidden" name='carregar' value='<?= $contrato['id'] ?>'>
                                                    <button type='submit' class='btn btn-info'> Carregar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                    </table>

                                <?php
                            }
                            else
                            {
                                echo "Não há resultado no momento.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title text-bold">Licitações empenhadas</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            if($num_empenhadas > 0)
                            {
                                ?>

                                <table id="tblLicitacao" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nº SEI administrativo</th>
                                        <th>Objeto</th>
                                        <th>Unidade</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($licitacoes_empenhadas as $licitacao) {
                                        $unidade = recuperaDados('unidades', 'id', $licitacao['unidade_id'])['nome'];
                                        $status = recuperaDados('licitacao_status', 'id', $licitacao['licitacao_status_id'])['status'];
                                        ?>
                                        <tr>
                                            <td><?= $licitacao['numero_processo'] ?></td>
                                            <td><?= $licitacao['objeto'] ?></td>
                                            <td><?= $unidade ?></td>
                                            <td><?= $status ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>

                                <?php
                            }
                            else
                            {
                                echo "Não há resultado no momento.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title text-bold">Licitações Homologadas</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            if($num_homologadas > 0)
                            {

                                ?>

                                <table class='table table-striped table-bordered table-responsive list_info'>
                                    <thead>
                                    <tr>
                                        <th>Nº SEI administrativo</th>
                                        <th>Objeto</th>
                                        <th>Unidade</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($licitacoes_homologadas as $licitacao) {
                                        $unidade = recuperaDados('unidades', 'id', $licitacao['unidade_id'])['nome'];
                                        $status = recuperaDados('licitacao_status', 'id', $licitacao['licitacao_status_id'])['status'];
                                        ?>
                                        <tr>
                                            <td><?= $licitacao['numero_processo'] ?></td>
                                            <td><?= $licitacao['objeto'] ?></td>
                                            <td><?= $unidade ?></td>
                                            <td><?= $status ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>

                                <?php
                            }
                            else
                            {
                                echo "Não há resultado no momento.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">

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






