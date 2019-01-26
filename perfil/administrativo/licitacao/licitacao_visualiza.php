<?php
$con = bancoMysqli();
$idLicitacao = $_POST['idLicitacao'];

if(isset($_POST['apagar'])){
    $sql = "UPDATE licitacoes SET licitacao_status_id = '3' WHERE id = '$idLicitacao'";
    if(mysqli_query($con, $sql)) {
        $mensagem = mensagem("success", "Licitação cancelada com sucesso!");
    } else {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
    }
}

$licitacao = recuperaDados('licitacoes', 'id', $idLicitacao);
$status = recuperaDados("licitacao_status","id",$licitacao['licitacao_status_id']);
$unidade = recuperaDados("unidades","id",$licitacao['unidade_id']);

function sim_nao($licitacao_atributo){
    if($licitacao_atributo == 2) {
        return "Sim";
    }
    else{
        return "Não";
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Licitação</h2>
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
                    <div class="box-body">
                        <p><strong>Número do processo administrativo:</strong> <a href="<?= $licitacao['link_processo'] ?>"><?= $licitacao['numero_processo'] ?></a> </p>
                        <p><strong>Objeto:</strong> <?= $licitacao['objeto'] ?></p>
                        <p><strong>Unidade:</strong> <?= $unidade['sigla'] . " - " . $unidade['nome'] ?></p>
                        <p><strong>Levantamento de preço?</strong> <?= sim_nao($licitacao['levantamento_preco']) ?></p>
                        <p><strong>Reserva?</strong> <?= sim_nao($licitacao['reserva']) ?></p>
                        <p><strong>Elaboração de Edital?</strong> <?= sim_nao($licitacao['elaboracao_edital']) ?></p>
                        <p><strong>Análise / Ajuste do Edital?</strong> <?= sim_nao($licitacao['analise_edital']) ?></p>
                        <p><strong>Data da Licitação:</strong> <?= sim_nao($licitacao['licitacao']) ?> <?= $licitacao['licitacao_observacao'] ?? NULL ?></p>
                        <p><strong>Homologação / Recurso?</strong> <?= sim_nao($licitacao['homologacao']) ?> <?= $licitacao['homologacao_observacao'] ?? NULL ?></p>
                        <p><strong>Empenho?</strong> <?= sim_nao($licitacao['empenho']) ?> <?= $licitacao['empenho_observacao'] ?? NULL ?></p>
                        <p><strong>Entrega?</strong> <?= sim_nao($licitacao['entrega']) ?></p>
                        <p><strong>Ordem de Início:</strong> <?= $licitacao['ordem_inicio'] ?>
                        <p><strong>Observação:</strong> <?= $licitacao['observacao'] ?>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
