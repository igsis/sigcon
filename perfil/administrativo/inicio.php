<?php

$con = bancoMysqli();

$sql = "SELECT * FROM licitacoes WHERE publicado = 1";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);

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
                        <h3 class="box-title text-bold">Listagem de licitações</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            if($num > 0)
                            {

                                ?>

                                <table class='table table-striped table-bordered table-responsive list_info'>
                                    <thead>
                                    <tr class='list_menu text-center text-purple text-bold'>
                                        <td width='50%'>Status da licitação</td>
                                        <td width='50%'>Total</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class='list_description'>
                                        <td>Total de licitações cadastradas</td>
                                        <td class='list_description'><?= $num ?> </td>
                                    </tr>
                                    <tr class='list_description'>
                                        <td>Total de licitações canceladas</td>
                                        <td class='list_description'><?= $qtde1 ?> </td>
                                    </tr>

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
<!--Gráfico-->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Gráfico</h3>
            </div>
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-responsive">
                            <canvas id="pieChart" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
</div>
<!-- ChartJS -->
<script defer src="../visual/bower_components/chart.js/Chart.js"></script>
<script defer>
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
                value: 700,
                color: '#f56954',
                highlight: '#f56954',
                label: 'Chrome'
            },
            {
                value: 500,
                color: '#00a65a',
                highlight: '#00a65a',
                label: 'IE'
            },
            {
                value: 400,
                color: '#f39c12',
                highlight: '#f39c12',
                label: 'FireFox'
            },
            {
                value: 600,
                color: '#00c0ef',
                highlight: '#00c0ef',
                label: 'Safari'
            },
            {
                value: 300,
                color: '#3c8dbc',
                highlight: '#3c8dbc',
                label: 'Opera'
            },
            {
                value: 100,
                color: '#d2d6de',
                highlight: '#d2d6de',
                label: 'Navigator'
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
