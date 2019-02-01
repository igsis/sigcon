<?php
$conn = bancoPDO();

$licitacoes = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE publicado = 1 AND licitacao_status_id = 1")->fetch();

$contratos = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE publicado = 1 AND licitacao_status_id = 2")->fetch();

$canceladas = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE publicado = 1 AND licitacao_status_id = 3")->fetch();

// etapa de levantamento de preço
$levantamento = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE levantamento_preco = 1 AND reserva = 0 AND publicado = 1 AND licitacao_status_id != 3")->fetch();

// etapa de reserva
$reserva = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE reserva = 1 AND elaboracao_edital = 0 AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$elaboracao_edital = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE elaboracao_edital = 1 AND analise_edital = 0 AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$analise_edital = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE analise_edital = 1 AND licitacao = '0000-00-00' AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$licitacao = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE licitacao != '0000-00-00' AND homologacao = 0 AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$homologacao = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE homologacao = 1 AND empenho = 0 AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$empenho = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE empenho = 1 AND entrega = 0 AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$entrega = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE entrega = 1 AND ordem_inicio = '0000-00-00' AND publicado = 1 AND licitacao_status_id != 3")->fetch();

//
$ordem_inicio = $conn->query("SELECT count(id) AS qtde FROM licitacoes WHERE ordem_inicio != '0000-00-00' AND publicado = 1 AND licitacao_status_id != 3")->fetch();
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <h2 class="page-header"><?= saudacao();?></h2>
        <!--Gráfico-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Resumo</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="chart-responsive">
                            <canvas id="pieChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <table class="table table-condensed">
                            <tr>
                                <td><i class="fa fa-circle-o text-red"></i> Levantamento de preço</td>
                                <td><span class="pull-right text-red"><?= $levantamento['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-yellow"></i> Reserva</td>
                                <td><span class="pull-right text-yellow"><?= $reserva['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-green"></i> Elaboração de edital</td>
                                <td><span class="pull-right text-green"><?= $elaboracao_edital['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-lime"></i> Análise edital</td>
                                <td><span class="pull-right text-lime"><?= $analise_edital['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-aqua"></i> Licitação</td>
                                <td><span class="pull-right text-aqua"><?= $licitacao['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-blue"></i> Homologação</td>
                                <td><span class="pull-right text-blue"><?= $homologacao['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-purple"></i> Empenho</td>
                                <td><span class="pull-right text-purple"><?= $empenho['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-fuchsia"></i> Entrega</td>
                                <td><span class="pull-right text-fuchsia"><?= $entrega['qtde'] ?></span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-circle-o text-muted"></i> Ordem de Início</td>
                                <td><span class="pull-right text-muted"><?= $ordem_inicio['qtde'] ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-1"></div>

                    <div class="col-md-3">
                        <table class='table table-striped table-bordered table-responsive list_info'>
                            <thead>
                            <tr class='list_menu text-center text-purple text-bold'>
                                <td width='50%'>Status da licitação</td>
                                <td width='50%'>Total</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class='list_description'>
                                <td>Licitação</td>
                                <td class='list_description'><?= $licitacoes['qtde'] ?> </td>
                            </tr>
                            <tr class='list_description'>
                                <td>Contrato</td>
                                <td class='list_description'><?= $contratos['qtde'] ?> </td>
                            </tr>
                            <tr class='list_description'>
                                <td>Cancelada</td>
                                <td class='list_description'><?= $canceladas['qtde'] ?> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
</div>

<!-- ChartJS -->
<script defer src="../visual/bower_components/chart.js/Chart.js"></script>
<script>
    $(function ()
    {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        let pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        let pieChart = new Chart(pieChartCanvas);
        let PieData = [
            {
                value: <?= $levantamento['qtde'] ?>,
                color: '#DD4B39',
                highlight: '#DD4B39',
                label: 'Levantamento de preço'
            },
            {
                value: <?= $reserva['qtde'] ?>,
                color: '#F39C12',
                highlight: '#F39C12',
                label: 'Reserva'
            },
            {
                value: <?= $elaboracao_edital['qtde'] ?>,
                color: '#07A85F',
                highlight: '#07A85F',
                label: 'Elaboração edital'
            },
            {
                value: <?= $analise_edital['qtde'] ?>,
                color: '#13FF7A',
                highlight: '#13FF7A',
                label: 'Análise edital'
            },
            {
                value: <?= $licitacao['qtde'] ?>,
                color: '#5BD6F5',
                highlight: '#5BD6F5',
                label: 'Licitação'
            },
            {
                value: <?= $homologacao['qtde'] ?>,
                color: '#1A81BE',
                highlight: '#1A81BE',
                label: 'Homologação'
            },
            {
                value: <?= $empenho['qtde'] ?>,
                color: '#9E9BCA',
                highlight: '#9E9BCA',
                label: 'Empenho'
            },
            {
                value: <?= $entrega['qtde'] ?>,
                color: '#F22AC5',
                highlight: '#F22AC5',
                label: 'Entrega'
            },
            {
                value: <?= $ordem_inicio['qtde'] ?>,
                color: '#9C9C9C',
                highlight: '#9C9C9C',
                label: 'Ordem de Início'
            }
        ];
        let pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: '#fff',
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: 'easeOutBounce',
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
    });
</script>
