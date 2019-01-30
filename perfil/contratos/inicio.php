<?php

$con = bancoMysqli();
$conn = bancoPDO();

$sql = "SELECT * FROM licitacoes WHERE empenho = 1 ORDER BY numero_processo";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
$licitacoes = $conn->query($sql)->fetchAll();


$sqlStatus3 = "SELECT * FROM licitacoes WHERE licitacao_status_id = 3";
$queryStatus3 = mysqli_query($con, $sqlStatus3);
$qtde3 = mysqli_num_rows($queryStatus3);

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

                            if($num > 0)
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
                                    foreach ($licitacoes as $licitacao) {
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
                <div class="box">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title text-bold">Etapas</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            if($num > 0)
                            {
                                ?>

                                <table class='table table-striped table-bordered table-responsive list_info'>
                                    <thead>
                                    <tr class='list_menu text-center text-bold text-purple'>
                                        <td width='50%'>Etapa da licitação</td>
                                        <td width='50%'>Total </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Licitações que ainda não possuem contrato</td>
                                        <td class='list_description'><?= $qtde3 ?></td>
                                    </tr>
                                    <tr><td>Licitações que possoem contrato</td>
                                        <td class='list_description'><?= $qtde2 ?></td></tr>
                                    <tr><td>Licitações canceladas</td>
                                        <td class='list_description'><?= $qtde1 ?></td></tr>
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




