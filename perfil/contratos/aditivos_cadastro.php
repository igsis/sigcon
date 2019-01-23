<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Aditivo</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Aditivo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos/contrato_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Vigência início</label>
                                    <input type="date" name="vigencia_inicio" id='vigencia_inicio' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Vigência fim</label>
                                    <input type="date" name="vigencia_fim" id='vigencia_fim' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>DOU</label>
                                    <input type="date" name="dou" id='dou' class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_mensal">Valor mensal</label>
                                    <input type="text" id="valor_mensal" name="valor_mensal" class="form-control" placeholder="Valor em formato decimal *">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_reajuste">Valor do reajuste</label>
                                    <input type="text" id="valor_reajuste" name="valor_reajuste" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" placeholder="Valor em formato decimal *">
                                </div>
                            </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END ACCORDION & CAROUSEL-->

    </section>
    <!-- /.content -->
</div>


<script>

    $('#num_processo').mask('0000.0000/0000000-0', {reverse: true});


    function habilitaCampo(id) {
        if(document.getElementById(id).disabled==true){document.getElementById(id).disabled=false}
    }

    function desabilitarCampo(id){
        if(document.getElementById(id).disabled==false){document.getElementById(id).disabled=true}
    }

    /* function habilitarRadio (valor) {
         if (valor == 2) {
             document.status.disabled = false;
         } else {
             document.status.disabled = true;
         }
     }*/




</script>
