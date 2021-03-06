<?php
$con = bancoMysqli();
$idLicitacao = $_POST['idLicitacao'];
$proponente = $_POST['proponente'];
$doc = $_POST['documento'];
$tipoPessoa = $_POST['tipoPessoa'];

$licitacao = recuperaDados('licitacoes', 'id', $idLicitacao);
$status = recuperaDados("licitacao_status","id",$licitacao['licitacao_status_id']);
$unidade = recuperaDados("unidades","id",$licitacao['unidade_id']);
$contrato = recuperaDados("contratos", "licitacao_id", $idLicitacao);
$fiscal = recuperaDados("fiscais", "id", $contrato['fiscal_id']);
$suplente = recuperaDados("suplentes", "id", $contrato['suplente_id']);
$informacoes = recuperaDados("informacoes_do_contrato", "contrato_id", $contrato['id']);



function sim_nao($licitacao_atributo){
    if($licitacao_atributo == 1) {
        return "OK";
    }
    else{
        return "Não concluído";
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <h2 class="page-header">Resultado da pesquisa</h2>
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Informações da licitação
                        </h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {echo $mensagem;} ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <p><strong>Status:</strong> <?= $status['status'] ?></p>
                        <p><strong>Número do processo administrativo:</strong> <a href="<?= $licitacao['link_processo'] ?>"><?= $licitacao['numero_processo'] ?></a> </p>
                        <p><strong>Objeto:</strong> <?= $licitacao['objeto'] ?></p>
                        <p><strong>Unidade:</strong> <?= $unidade['sigla'] . " - " . $unidade['nome'] ?></p>
                        <p><strong>Levantamento de preço?</strong> <?= sim_nao($licitacao['levantamento_preco']) ?></p>
                        <p><strong>Reserva?</strong> <?= sim_nao($licitacao['reserva']) ?></p>
                        <p><strong>Elaboração de Edital?</strong> <?= sim_nao($licitacao['elaboracao_edital']) ?></p>
                        <p><strong>Análise / Ajuste do Edital?</strong> <?= sim_nao($licitacao['analise_edital']) ?></p>

                        <?php if ($licitacao['licitacao'] != "0000-00-00") {echo "<p><strong>Licitação: </strong>" . exibirDataBr($licitacao['licitacao']); }else {echo "<p><strong>Licitação Observação: </strong>" . $licitacao['licitacao_observacao'];} ?>

                        <?php if ($licitacao['homologacao'] == 1) {echo "<p><strong>Homologação: </strong>" . sim_nao($licitacao['homologacao']); } else { echo "<p><strong>Homologação Observação: </strong>" . $licitacao['homologacao_observacao'];} ?>

                        <?php if ($licitacao['empenho'] == 1) {echo "<p><strong>Empenho: </strong>" . sim_nao($licitacao['empenho']); } else { echo "<p><strong>Empenho Observação: </strong>" . $licitacao['homologacao_observacao'];} ?>

                        <p><strong>Entrega?</strong> <?= sim_nao($licitacao['entrega']) ?></p>
                        <p><strong>Ordem de Início:</strong> <?= exibirDataBr($licitacao['ordem_inicio']) ?>
                        <p><strong>Observação:</strong> <?= $licitacao['observacao'] ?>
                    </div>
                </div>
            </div>

            <?php
            if ($licitacao['licitacao_status_id'] == 2) {
                $contrato = recuperaDados("contratos", "licitacao_id", $idLicitacao);
                $idContrato = $contrato['id'];

                $sql = "SELECT * FROM contrato_equipamento as contratc_equips 
                INNER JOIN equipamentos AS equips ON contratc_equips.equipamento_id = equips.id WHERE contrato_id = '$idContrato'";
                $queryEquips = mysqli_query($con, $sql);
                $num = mysqli_num_rows($queryEquips);

                ?>

                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Informações sobre o contrato
                            </h3>
                        </div>
                        <div class="row" align="center">
                            <?php if (isset($mensagem)) {
                                echo $mensagem;
                            } ?>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p><strong>Número do processo administrativo:</strong> <a
                                        href="<?= $licitacao['link_processo'] ?>"><?= $licitacao['numero_processo'] ?></a>
                            </p>
                           <?php
                                if ($tipoPessoa == 1) {
                            ?>

                            <p><strong>Nome:</strong> <?= $proponente ?></p>
                            <p><strong>CPF:</strong> <?= $doc ?></p>

                            <?php
                                } elseif ($tipoPessoa == 2) {
                            ?>

                            <p><strong>Razão Social:</strong> <?= $proponente ?></p>
                            <p><strong>CNPJ:</strong> <?= $doc ?></p>

                            <?php } ?>

                            <p><strong>Objeto:</strong> <?= $licitacao['objeto'] ?></p>
                            <p><strong>Termo de contrato:</strong> <?= $contrato['termo_contrato'] ?></p>
                            <p><strong>Tipo de serviço:</strong> <?= $contrato['tipo_servico'] ?></p>
                            <p><strong>Unidade:</strong> <?= $unidade['sigla'] . " - " . $unidade['nome'] ?></p>
                            <p><strong>Equipamentos atendidos: </strong>

                            <?php
                                if($num > 0) {
                                    while($equip = mysqli_fetch_array($queryEquips)) {
                                        ?>
                                         <?=$equip['nome'] . "; "?>
                                    <?php
                                    }
                                }
                                ?>
                            </p>

                            <p><strong>Fiscal:</strong> <?= $fiscal['nome_fiscal'] ?> </p>
                            <p><strong>Contato do fiscal:</strong> <?= $fiscal['contato_fiscal'] ?></p>
                            <p><strong>Suplente: </strong> <?= $suplente['nome_suplente'] ?>
                            </p>
                            <p><strong>Contato do suplente:</strong> <?= $suplente['contato_suplente'] ?>
                            </p>
                             <?php if ($licitacao['licitacao'] != "0000-00-00") {echo "<p><strong>Licitação:</strong>" . exibirDataBr($licitacao['licitacao']); } else { echo "<p><strong>Licitação Observação:</strong>" . $licitacao['licitacao_observacao'];} ?>
                            <p><strong>Garantia?</strong> <?= sim_nao($contrato['garantia']) ?>
                            </p>

                            <p><strong>Negociações/Reajustes:</strong> <?= $contrato['negociacoes_reajustes'] ?></p>
                            <p><strong>Nível de risco:</strong> <?= $contrato['nivel_de_risco'] ?></p>
                            <p><strong>Observação:</strong> <?= $contrato['observacao'] ?></p>
                        <hr>

                            <div class="text-center">
                                <p><strong>Informações do contrato</strong></p>
                            </div>

                            <p class="text-center">
                                <strong>Vigência início:</strong> <?= exibirDataBr($informacoes['inicio_vigencia']) ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                <strong>Vigência fim:</strong> <?= exibirDataBr($informacoes['fim_vigencia']) ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                <strong>DOU:</strong> <?= exibirDataBr($informacoes['DOU']) ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                <strong>Valor mensal:</strong> <?= $informacoes['valor_mensal'] ?> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                <strong>Valor anual:</strong> <?= $informacoes['valor_anual'] ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </section>
</div>
