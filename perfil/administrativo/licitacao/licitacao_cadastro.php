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
                    <form method="POST" action="?perfil=administrativo&p=licitacao&sp=licitacao_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="num_processo">Número do processo administrativo *</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" maxlength="20" placeholder="0000.0000/0000000-0" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="link_processo">Link do processo administrativo *</label>
                                    <input type="text" id="link_processo" name="link_processo" class="form-control" maxlength="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="objeto">Objeto *</label>
                                    <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade">Unidade *</label>
                                    <select class="form-control" id="unidade" name="unidade" required>
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades")
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="levantamento_preco">Levantamento de preço? </label> <br>
                                    <label><input type="radio" name="levantamento_preco" value="2" onclick="habilitarDesabilitarCampo('.reserva', false)"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="levantamento_preco" value="1" checked onclick="habilitarDesabilitarCampo('.reserva', true)"> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reserva">Reserva? </label> <br>
                                    <label><input type="radio" name="reserva" value="2" class="reserva" disabled onclick="habilitarDesabilitarCampo('.elaboracao_edital', false)"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="reserva" value="1" class="reserva" checked disabled onclick="habilitarDesabilitarCampo('.elaboracao_edital', true)"> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="elaboracao_edital">Elaboração de Edital? </label> <br>
                                    <label><input type="radio" name="elaboracao_edital" value="2" class="elaboracao_edital" disabled onclick="habilitarDesabilitarCampo('.analise_edital', false)"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="elaboracao_edital" value="1" class="elaboracao_edital" disabled onclick="habilitarDesabilitarCampo('.analise_edital', true)" checked> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="analise_edital">Análise / Ajuste do Edital? </label> <br>
                                    <label><input type="radio" name="analise_edital" class="analise_edital" value="2" disabled>  Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="analise_edital" class="analise_edital" value="1" disabled checked> Não </label>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="licitacao">Licitação</label> <br>
                                    <input type="date" name="licitacao" id="licitacao" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="obs_licitacao">Licitação Observação</label>
                                    <input type="text" id="obs_licitacao" name="obs_licitacao" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="homologacao">Homologação / Recurso?</label> <br>
                                    <label><input type="radio" name="homologacao" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="homologacao" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="obs_homologacao">Homologação Observação</label>
                                    <input type="text" id="obs_homologacao" name="obs_homologacao" class="form-control" maxlength="60">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="empenho">Empenho?</label> <br>
                                    <label><input type="radio" name="empenho" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="empenho" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="obs_empenho">Empenho Observação</label>
                                    <input type="text" id="obs_empenho" name="obs_empenho" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="entrega">Entrega? </label> <br>
                                    <label><input type="radio" name="entrega" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="entrega" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ordem_inicio">Ordem de Início</label>
                                    <input type="date" name="ordem_inicio" id='ordem_inicio' class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observacao">Observação</label>
                                    <input type="text" id="observacao" name="observacao" class="form-control" maxlength="250">
                                </div>
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



    function habilitarDesabilitarCampo(target, prop)
    {
        $(target).prop('disabled',prop);
    }



</script>
