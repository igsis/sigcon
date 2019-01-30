<?php

$con = bancoMysqli();
$conn = bancoPDO();

$sqlEmpenho = "SELECT * FROM licitacoes WHERE empenho = 1 ORDER BY numero_processo";
$query = mysqli_query($con,$sqlEmpenho);
$num_empenhadas = mysqli_num_rows($query);
$licitacoes_empenhadas = $conn->query($sqlEmpenho)->fetchAll();

$sqlHomologacao = "SELECT * FROM licitacoes WHERE homologacao = 1 AND empenho = 0 ORDER BY numero_processo";
$queryHomologacao = mysqli_query($con, $sqlHomologacao);
$num_homologadas = mysqli_num_rows($queryHomologacao);
$licitacoes_homologadas = $conn->query($sqlHomologacao)->fetchAll();

$sqlStatus2 = "SELECT * FROM licitacoes WHERE licitacao_status_id = 2";
$queryStatus2 = mysqli_query($con, $sqlStatus2);
$qtde2 = mysqli_num_rows($queryStatus2);

$sqlStatus1 = "SELECT * FROM licitacoes WHERE licitacao_status_id = 1";
$queryStatus1 = mysqli_query($con, $sqlStatus1);
$qtde1 = mysqli_num_rows($queryStatus1);
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




