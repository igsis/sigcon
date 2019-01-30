<?php
$con = bancoMysqli();

// Carrega Licitação do Pesquisa
if(isset($_POST['editarLicitacao'])){
    $id = $_POST['editarLicitacao'];
    $idLicitacao = recuperaDados('licitacoes', 'id', $id)['id'];
}

if (isset($_POST['cadastra']) || isset($_POST['edita'])) {

    $idLicitacao = $_POST['idLicitacao'] ?? NULL;
    $num_processo = $_POST['num_processo'];
    $link_processo = addslashes($_POST['link_processo']) ?? NULL;
    $objeto = $_POST['objeto'];
    $unidade_id = $_POST['unidade'] ?? NULL;
    $levantamento_preco = ($_POST['levantamento_preco'] == 'on') ?? NULL;
    echo "<pre>";
    print_r($levantamento_preco);
    echo "</pre>";
    $reserva = ($_POST['reserva'] == 'on') ?? NULL;
    $elaboracao_edital = ($_POST['elaboracao_edital'] == 'on') ?? NULL;
    $analise_edital = ($_POST['analise_edital']  == 'on') ?? NULL;
    $licitacao = $_POST['licitacao'];
    $obs_licitacao = $_POST['obs_licitacao'] ?? NULL;
    $homologacao = ($_POST['homologacao']  == 'on') ?? NULL;
    $obs_homologacao = $_POST['obs_homologacao'] ?? NULL;
    $empenho = ($_POST['empenho']  == 'on') ?? NULL;
    $obs_empenho = $_POST['obs_empenho'] ?? NULL;
    $entrega = ($_POST['entrega']  == 'on') ?? NULL;
    $ordem_inicio = $_POST['ordem_inicio'] ?? NULL;
    $observacoes = addslashes($_POST['observacao']) ?? NULL;

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
                                licitacao_status_id, 
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
                                '1', 
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
                                observacao = '$observacoes'
                                WHERE id = '$idLicitacao'";

        if (mysqli_query($con, $sql)) {
            $mensagem = mensagem("success", "Editado com sucesso!");
        } else {
            $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
        }

    }
}

$licitacao = recuperaDados('licitacoes', 'id', $idLicitacao);
$status = recuperaDados("licitacao_status","id",$licitacao['licitacao_status_id']);
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
                            <?= "Status: " . $status['status']?>
                        </h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {echo $mensagem;} ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=licitacao&sp=licitacao_edita" role="form">
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
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="levantamento_preco" class='text-center'><strong>Levantamento de preço?</strong>
                                            <?php  //echo "<pre>"; print_r($licitacao['levantamento_preco']); echo "</pre>"; ?>
                                            <input type="checkbox" name='levantamento_preco' id='levantamento_preco'  <?= $licitacao['levantamento_preco'] ? 'checked' : NULL ?>/>
                                        </label>                                        
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="reserva" class='text-center'><strong>Reserva? </strong>
                                            <input type="checkbox" name="reserva" id='reserva'  <?= $licitacao['reserva'] ? 'checked' : NULL ?> />
                                        </label>                                      
                                    </div>                                
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="elaboracao_edital" class='text-center'><strong>Elaboração de Edital?</strong>
                                            <input type="checkbox" name="elaboracao_edital" id="elaboracao_edital" <?= $licitacao['elaboracao_edital'] ? 'checked' : NULL ?> />
                                        </label> 
                                    </div>                                    
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="analise_edital" class='text-center'><strong>Análise / Ajuste do Edital? </strong>
                                            <input type="checkbox" name="analise_edital"  id='analise_edital' <?= $licitacao['analise_edital'] ? 'checked' : NULL ?> /> 
                                        </label>
                                    </div>                                
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="licitacao">Licitação </label>
                                    <input type="date" name="licitacao" id="licitacao" class="form-control" value="<?=$licitacao['licitacao']?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="obs_licitacao">Licitação Observação</label>
                                    <input type="text" id="obs_licitacao" name="obs_licitacao" class="form-control" maxlength="60" value="<?= $licitacao['licitacao_observacao'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="homologacao" class='text-center'><strong>Homologação / Recurso?</strong>
                                            <input type="checkbox" name="homologacao" id='homologacao' <?= $licitacao['homologacao'] ? 'checked' : NULL ?> />
                                        </label>
                                    </div>                                   
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="obs_homologacao">Homologação Observação</label>
                                    <input type="text" id="obs_homologacao" name="obs_homologacao" class="form-control" maxlength="60" value="<?= $licitacao['homologacao_observacao']  ?>">

                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <div class="checkbox">
                                        <label for="empenho" class='text-center'><strong>Empenho?</strong>
                                            <input type="checkbox" name="empenho" id='empenho' <?= $licitacao['empenho'] ? 'checked' : NULL ?> />
                                        </label>
                                    </div>                                            
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="obs_empenho">Empenho Observação</label>
                                    <input type="text" id="obs_empenho" name="obs_empenho" class="form-control" maxlength="60" value="<?= $licitacao['empenho_observacao']  ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="checkbox">
                                        <label for="entrega" class='text-center'> <strong>Entrega? </strong>
                                            <input type="checkbox" name="entrega" id='entrega' <?= $licitacao['entrega'] ? 'checked' : NULL ?> />
                                        </label>                                    
                                    </div>                                  
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ordem_inicio">Ordem de Início</label>
                                    <input type="date" name="ordem_inicio" id='ordem_inicio' class="form-control" value="<?= $licitacao['licitacao']?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observacao">Observação</label>
                                    <input type="text" id="observacao" name="observacao" class="form-control" maxlength="250" value="<?= $licitacao['observacao'] ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
                            <button type="submit" name="edita" class="btn btn-info pull-right">Editar</button>
                            <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#modal-danger">Cancelar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END ACCORDION & CAROUSEL-->
        <!-- Confirmação de Exclusão -->
        <div class="modal modal-danger fade" id="modal-danger">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmação de cancelamento</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente cancelar?<br/></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Voltar</button>
                        <form method="POST" action="?perfil=administrativo&p=licitacao/licitacao_visualiza" role="form">
                            <input type="hidden" name="idLicitacao" value="<?= $idLicitacao ?>">
                            <button type="submit" name="apagar" class="btn btn-outline">Sim</button>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fim Confirmação de Exclusão -->
    </section>
    <!-- /.content -->
</div>

<script>

    $('#num_processo').mask('0000.0000/0000000-0', {reverse: true});

    function habilitarDesabilitarCampo(target, prop)
    {
        $(target).prop('disabled',prop);
    }

    function habilitaCampo(id) {
        $('#' + id).prop('disabled');
        if(document.getElementById(id).disabled==true){document.getElementById(id).disabled=false}
    }

    function desabilitarCampo(id){
        if(document.getElementById(id).disabled==false){document.getElementById(id).disabled=true}
    }

    // 2 = habilitado
    // 1 = desaboçotado

    $(document).ready(function (){
        alert('Pagina carregada');
    })
</script>