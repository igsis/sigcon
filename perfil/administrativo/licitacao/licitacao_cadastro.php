<?php
    include "../perfil/includes/menu.php";

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
                                    <select class="form-control" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades")
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="levantamento_preco">Levantamento de preço? </label> <br>
                                    <label><input type="radio" name="levantamento_preco" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="levantamento_preco" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reserva">Reserva? </label> <br>
                                    <label><input type="radio" name="reserva" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="reserva" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="elaboracao_edital">Elaboração de Edital? </label> <br>
                                    <label><input type="radio" name="elaboracao_edital" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="elaboracao_edital" value="1" checked> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="analise_edital">Análise / Ajuste do Edital? </label> <br>
                                    <label><input type="radio" name="analise_edital" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="analise_edital" value="1" checked> Não </label>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="licitacao">Licitação * </label> <br>
                                    <input type="date" name="licitacao" class="form-control">
                                </div>
                                <div class="form-group col-md-offset-3 col-md-6">
                                    <label for="homologacao">Homologação / Recurso? </label> <br>
                                    <label><input type="radio" name="homologacao" value="2" onclick="habilitaCampo('obs_homologacao')"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="homologacao" value="1" checked onclick="desabilitarCampo('obs_homologacao')"> Não </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="obs_licitacao">Licitação Observação *</label>
                                    <input type="text" id="obs_licitacao" name="obs_licitacao" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="obs_homologacao">Homologação Observação *</label>
                                    <input type="text" id="obs_homologacao" name="obs_homologacao" class="form-control" maxlength="60" disabled="disabled">

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="empenho">Empenho? </label> <br>
                                    <label><input type="radio" name="empenho" value="2" onclick="habilitaCampo('obs_empenho')"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="empenho" value="1" checked onclick="desabilitarCampo('obs_empenho')"> Não </label>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="entrega">Entrega? </label> <br>
                                    <label><input type="radio" name="entrega" value="2" onclick="habilitaCampo('ordem_inicio')"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="entrega" value="1" checked onclick="desabilitarCampo('ordem_inicio')"> Não </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="obs_empenho">Empenho Observação *</label>
                                    <input type="text" id="obs_empenho" name="obs_empenho" class="form-control" maxlength="60" disabled="disabled">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Ordem de Início *</label>
                                    <input type="date" name="ordem_inicio" id='ordem_inicio' class="form-control" disabled="disabled">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="observacao">Observação *</label>
                                    <textarea type="text" id="observacao" name="observacao" class="form-control" maxlength="250" rows="5" required></textarea>
                                </div>
                                <div style="margin-top: 50px" class="form-group col-md-6">
                                    <label for="status">Status </label> <br>
                                    <label><input type="radio" name="status" value="3" checked> Licitação </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="status" value="2"> Contrato </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="status" value="1"> Cancelado </label>
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


    function habilitaCampo(id) {
        if(document.getElementById(id).disabled==true){document.getElementById(id).disabled=false}
    }

    function desabilitarCampo(id){
        if(document.getElementById(id).disabled==false){document.getElementById(id).disabled=true}
    }

    window.load function {

    }

   /* function habilitarRadio (valor) {
        if (valor == 2) {
            document.status.disabled = false;
        } else {
            document.status.disabled = true;
        }
    }*/




</script>
