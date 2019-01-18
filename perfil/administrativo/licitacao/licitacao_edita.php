<?php

$con = bancoMysqli();
include "../perfil/includes/menu.php";

if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idLicitacao = $_POST['idLicitacao'] ?? NULL;
    $num_processo = $_POST['num_processo'];
    $link_processo = addslashes($_POST['link_processo']) ?? NULL;
    $objeto = $_POST['objeto'];
    $unidade_id = $_POST['unidade'] ?? NULL;
    $levantamento_preco = $_POST['levantamento_preco'];
    $reserva = $_POST['reserva'];
    $elaboracao_edital = $_POST['elaboracao_edital'];
    $analise_edital = $_POST['analise_edital'];
    $licitacao = $_POST['licitacao'];
    $obs_licitacao = $_POST['obs_licitacao'] ?? NULL;
    $homologacao = $_POST['homologacao'];
    $obs_homologacao = $_POST['obs_homologacao'] ?? NULL;
    $empenho = $_POST['empenho'];
    $obs_empenho = $_POST['obs_empenho'] ?? NULL;
    $entrega = $_POST['entrega'];
    $ordem_inicio = $_POST['ordem_inicio'] ?? NULL;
    $observacoes = addslashes($_POST['observacao']) ?? NULL;
    $status = $_POST['status'];

    if(isset($_POST['cadastra'])){
        $sql = "
         INSERT INTO licitacoes (numero_processo,
                                link_processo, 
                                objeto, 
                                unidade_id, 
                                levantamento_preco, 
                                reserva, 
                                elaboracao_edital, 
                                analise_edital, 
                                licitacao, 
                                licitacao_observacao, 
                                homologacao, 
                                homologacao_observacao, 
                                empenho, 
                                empenho_observacao, 
                                entrega, 
                                ordem_inicio, 
                                observacao, 
                                status, 
                                publicado) 
                     VALUES    ('$num_processo', 
                                '$link_processo', 
                                '$objeto', 
                                '$unidade_id', 
                                '$levantamento_preco', 
                                '$reserva', 
                                '$elaboracao_edital',
                                '$analise_edital', 
                                '$licitacao', '$obs_licitacao', 
                                '$homologacao', 
                                '$obs_homologacao',
                                '$empenho', 
                                '$obs_empenho', 
                                '$entrega', 
                                '$ordem_inicio', 
                                '$observacoes', 
                                '$status', 
                                '1')";

        if (mysqli_query($con, $sql)) {

            $idLicitacao = recuperaUltimo("licitacoes");

            $mensagem = mensagem("success", "Licitação cadastrada com sucesso!");
        } else {
            $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
        }
    }

    if (isset($_POST['edita'])) {

        $sql = "UPDATE licitacoes SET 
                                numero_processo = '$num_processo',
                                link_processo = '$link_processo', 
                                objeto = '$objeto', 
                                unidade_id = '$unidade_id', 
                                levantamento_preco = '$levantamento_preco', 
                                reserva = '$reserva', 
                                elaboracao_edital = '$elaboracao_edital', 
                                analise_edital = '$analise_edital', 
                                licitacao = '$licitacao', 
                                licitacao_observacao = '$obs_licitacao', 
                                homologacao = '$homologacao', 
                                homologacao_observacao = '$obs_homologacao', 
                                empenho = '$empenho', 
                                empenho_observacao = '$obs_empenho', 
                                entrega = '$entrega', 
                                ordem_inicio = '$ordem_inicio', 
                                observacao = '$observacoes', 
                                status = '$status' 
                                WHERE id = '$idLicitacao'";

        if (mysqli_query($con, $sql)) {
            $mensagem = mensagem("success", "Editado com sucesso!");
        } else {
            $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
        }

    }
}

$licitacao = recuperaDados('licitacoes', 'id', $idLicitacao);


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
                        <h3 class="box-title">
                            <?= "Número do processo administrativo: " . $licitacao['numero_processo']?>
                        </h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo/licitacao/licitacao_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="num_processo">Número do processo administrativo *</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" placeholder="0000.0000/0000000-0" value="<?= $licitacao['numero_processo'] ?>" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="link_processo">Link do processo administrativo *</label>
                                    <input type="text" id="link_processo" name="link_processo" class="form-control" maxlength="100" value="<?= $licitacao['link_processo'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="objeto">Objeto *</label>
                                    <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" value="<?= $licitacao['objeto'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade">Unidade *</label>
                                    <select class="form-control" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades", $licitacao['unidade_id'])
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="levantamento_preco">Levantamento de preço? </label> <br>
                                    <label><input type="radio" name="levantamento_preco" value="2" <?= $licitacao['levantamento_preco'] == 2 ? 'checked' : NULL ?>> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="levantamento_preco" value="1" <?= $licitacao['levantamento_preco'] == 1 ? 'checked' : NULL ?>> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="reserva">Reserva? </label> <br>
                                    <label><input type="radio" name="reserva" value="2" <?= $licitacao['reserva'] == 2 ? 'checked' : NULL ?>> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="reserva" value="1" <?= $licitacao['reserva'] == 1 ? 'checked' : NULL ?>> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="elaboracao_edital">Elaboração de Edital? </label> <br>
                                    <label><input type="radio" name="elaboracao_edital" value="2" <?= $licitacao['elaboracao_edital'] == 2 ? 'checked' : NULL ?>> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="elaboracao_edital" value="1" <?= $licitacao['elaboracao_edital'] == 1 ? 'checked' : NULL ?>> Não </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="analise_edital">Análise / Ajuste do Edital? </label> <br>
                                    <label><input type="radio" name="analise_edital" value="2" <?= $licitacao['analise_edital'] == 2 ? 'checked' : NULL ?>> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="analise_edital" value="1" <?= $licitacao['analise_edital'] == 1 ? 'checked' : NULL ?>> Não </label>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="licitacao">Licitação * </label>
                                    <input type="date" name="licitacao" class="form-control">
                                </div>
                                <div class="form-group col-md-offset-3 col-md-6">
                                    <label for="homologacao">Homologação / Recurso? </label> <br>
                                    <label><input type="radio" name="homologacao" value="2" <?= $licitacao['homologacao'] == 2 ? 'checked' : NULL ?> onclick="if(document.getElementById('obs_homologacao').disabled==true){document.getElementById('obs_homologacao').disabled=false}"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="homologacao" value="1" <?= $licitacao['homologacao'] == 1 ? 'checked' : NULL ?> onclick="if(document.getElementById('obs_homologacao').disabled==false){document.getElementById('obs_homologacao').disabled=true}"> Não </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="obs_licitacao">Licitação Observação *</label>
                                    <input type="text" id="obs_licitacao" name="obs_licitacao" class="form-control" maxlength="60" value="<?= $licitacao['licitacao_observacao'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="obs_homologacao">Homologação Observação *</label>
                                    <input type="text" id="obs_homologacao" name="obs_homologacao" class="form-control" maxlength="60" value="<?= $licitacao['homologacao_observacao']  ?>" disabled="disabled">

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="empenho">Empenho? </label> <br>
                                    <label><input type="radio" name="empenho" value="2" <?= $licitacao['empenho'] == 2 ? 'checked' : NULL ?> onclick=""> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="empenho" value="1" <?= $licitacao['empenho'] == 1 ? 'checked' : NULL ?> onclick="if(document.getElementById('obs_empenho').disabled==false){document.getElementById('obs_empenho').disabled=true}"> Não </label>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="entrega">Entrega? </label> <br>
                                    <label><input type="radio" name="entrega" value="2" <?= $licitacao['entrega'] == 2 ? 'checked' : NULL ?> onclick="if(document.getElementById('ordem_inicio').disabled==true){document.getElementById('ordem_inicio').disabled=false}"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="entrega" value="1" <?= $licitacao['entrega'] == 1 ? 'checked' : NULL ?> onclick="if(document.getElementById('ordem_inicio').disabled==false){document.getElementById('ordem_inicio').disabled=true}"> Não </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="obs_empenho">Empenho Observação *</label>
                                    <input type="text" id="obs_empenho" name="obs_empenho" class="form-control" disabled="disabled" maxlength="60" value="<?= $licitacao['empenho_observacao']  ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Ordem de Início *</label>
                                    <input type="date" name="ordem_inicio" id='ordem_inicio' class="form-control" disabled="disabled" value="<?= exibirDataBr($licitacao['licitacao'] )?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="observacao">Observação *</label>
                                    <textarea type="text" id="observacao" name="observacao" class="form-control" maxlength="250" rows="5"><?= $licitacao['observacao'] ?></textarea>
                                </div>
                                <div style="margin-top: 50px" class="form-group col-md-6">
                                    <label for="status">Status </label> <br>
                                    <label><input type="radio" name="status" value="3" <?= $licitacao['status'] == 3 ? 'checked' : NULL ?> > Licitação </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="status" value="2" <?= $licitacao['status'] == 2 ? 'checked' : NULL ?> > Contrato </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="status" value="1" <?= $licitacao['status'] == 1 ? 'checked' : NULL ?> > Cancelado </label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
                            <button type="submit" name="edita" class="btn btn-info pull-right">Editar</button>
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



</script>
