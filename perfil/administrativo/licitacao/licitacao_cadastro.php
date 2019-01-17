<?php
    include "../perfil/includes/menu.php";
    include "../include/script.php"

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Licitação</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Licitação</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo/licitacao/licitacao_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="num_processo">Número do processo administrativo *</label>
                                        <input type="text" id="num_processo" name="num_processo" class="form-control" maxlength="20" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link_processo">Link do processo administrativo *</label>
                                        <input type="text" id="link_processo" name="link_processo" class="form-control" maxlength="100" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objeto">Objeto *</label>
                                        <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unidade">Unidade *</label>
                                        <select class="form-control" id="unidade" name="unidade" required>
                                            <option value="">Selecione...</option>
                                            <?php
                                            geraOpcao("unidades")
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="levantamento_preco">Levantamento de preço? </label> <br>
                                    <label><input type="radio" name="levantamento_preco" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="levantamento_preco" value="1"> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reserva">Reserva? </label> <br>
                                    <label><input type="radio" name="reserva" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="reserva" value="1"> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="elaborar_edital">Elaboração de Edital? </label> <br>
                                    <label><input type="radio" name="elaborar_edital" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="elaborar_edital" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="analise_edital">Análise de Edital? </label> <br>
                                    <label><input type="radio" name="analise_edital" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="analise_edital" value="1" checked> Não </label>
                                </div>
                            </div>
                        <hr />
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="licitacao">Licitação? </label> <br>
                                    <input type="date" name="licitacao" class="form-control">&nbsp;&nbsp;
                                </div>
                                <div class="form-group col-md-offset-3 col-md-6">
                                    <label for="homologacao">Homologação / Recurso? </label> <br>
                                    <label><input type="radio" name="homologacao" value="2" onclick="if(document.getElementById('obs_homologacao').disabled==true){document.getElementById('obs_homologacao').disabled=false}"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="homologacao" value="1" checked onclick="if(document.getElementById('obs_homologacao').disabled==false){document.getElementById('obs_homologacao').disabled=true}"> Não </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="obs_licitacao">Licitação Observação *</label>
                                        <input type="text" id="obs_licitacao" name="obs_licitacao" class="form-control" maxlength="60" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="obs_homologacao">Homologação Observação *</label>
                                        <input type="text" id="obs_homologacao" name="obs_homologacao" class="form-control" maxlength="60" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="empenho">Empenho? </label> <br>
                                    <label><input type="radio" name="empenho" value="2" onclick="if(document.getElementById('obs_empenho').disabled==true){document.getElementById('obs_empenho').disabled=false}"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="empenho" value="1" checked onclick="if(document.getElementById('obs_empenho').disabled==false){document.getElementById('obs_empenho').disabled=true}"> Não </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="entrega">Entrega? </label> <br>
                                    <label><input type="radio" name="entrega" value="2" onclick="if(document.getElementById('datepicker08').disabled==true){document.getElementById('datepicker08').disabled=false}"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="entrega" value="1" checked onclick="if(document.getElementById('datepicker08').disabled==false){document.getElementById('datepicker08').disabled=true}"> Não </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="obs_empenho">Empenho Observação *</label>
                                        <input type="text" id="obs_empenho" name="obs_empenho" class="form-control" maxlength="60" disabled="disabled">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ordem de Início *</label>
                                        <input type="text" name="ordem_inicio" id='datepicker11'  class="form-control">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name = "cadastra" class="btn btn-info pull-right">Cadastrar</button>
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

    $('#valor_individual').mask('000.000.000.000.000,00', {reverse: true});

</script>
