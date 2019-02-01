<?php

$con = bancoMysqli();
$conn = bancoPDO();

$dtHoje = date("d/m/Y");
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
$sqlContrato = "SELECT * FROM contratos WHERE publicado = 1";
$contratos = $conn->query($sqlContrato)->fetchAll();

$vencimento = $contratos['vencimento'];



?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <h2 class="page-header"><?= saudacao();?></h2>




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




