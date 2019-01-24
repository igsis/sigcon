<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

$tipoPessoa = $_POST['tipoPessoa'];
$idPessoa = $_POST['idPessoa'];

$idLicitacao = $_POST['idLicitacao'];
$licitacao = recuperaDados("licitacoes", "id", $idLicitacao);

if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
    $idContrato = $_POST['idContrato'] ?? NULL;
    $termo_contrato = $_POST['termo_contrato'];
    $tipo_servico = $_POST['tipo_servico'];
    $objeto = $_POST['objeto'];
    $idEmpresa = $_POST['idEmpresa'];
    $idUnidade = $_POST['unidade'];
    $idEquipamento = $_POST['equipamento'];
    $fiscal = $_POST['fiscal'];
    $contatoFiscal = $_POST['fiscal_contato'];
    $suplente = $_POST['suplente'];
    $contatoSuplente = $_POST['suplente_contato'];
    $garantia = $_POST['garantia'];
    $vigencia_inicio = $_POST['vigencia_inicio'];
    $vigencia_fim = $_POST['vigencia_fim'];
    $DOU = $_POST['dou'];
    $valor_mensal = $_POST['valor_mensal'];
    $valor_anual = $_POST['valor_anual'];
    $negociacoes_reajustes = $_POST['negociacoes_reajustes'];
    $nivel_risco = $_POST['nivel_risco'];
    $observacao = $_POST['observacao'];
    $vencimento = $_POST['vencimento'];
    $status = $_POST['status'];

    if(isset($_POST['cadastra'])) {
        $sqlFiscal = "INSERT INTO fiscais (nome_fiscal, 
                                           contato_fiscal, 
                                           publicado)
                                  VALUES  ('$fiscal', 
                                           '$contatoFiscal',
                                           '1')";

        if (mysqli_query($con, $sqlFiscal)) {

            gravarLog($sqlFiscal);
            $idFiscal = recuperaUltimo("fiscais");

            $sqlSuplente = "INSERT INTO suplentes (nome_suplente, 
                                           contato_suplente, 
                                           publicado)
                                  VALUES  ('$suplente', 
                                           '$contatoSuplente',
                                           '1')";

            if (mysqli_query($con, $sqlSuplente)) {

                gravarLog($sqlSuplente);
                $idSuplente = recuperaUltimo("suplentes");

                $sqlContrato = "INSERT INTO contratos (licitacao_id, 
                                                       termo_contrato, 
                                                       tipo_servico,
                                                       tipo_pessoa_id,
                                                       pessoa_id,
                                                       unidade_id,
                                                       equipamentos_id,
                                                       fiscal_id,
                                                       suplente_id,
                                                       garantia, 
                                                       vencimento,
                                                       negociacoes_reajustes,
                                                       nivel_de_risco,
                                                       observacao,
                                                       contrato_status_id,
                                                       publicado)
                                             VALUES   ('$idLicitacao', 
                                                       '$termo_contrato',
                                                       '$tipo_servico',
                                                       '$tipo_pessoa',
                                                       '$pessoa_id',
                                                       '$idUnidade',
                                                       '$idEquipamento',
                                                       '$idFiscal',
                                                       '$idSuplente',
                                                       '$garantia',
                                                       '$vencimento',
                                                       '$negociacoes_reajustes',
                                                       '$nivel_risco',
                                                       '$observacao',
                                                       '$status',                                                       
                                                       '1')";

                if (mysqli_query($con, $sqlContrato)) {

                    gravarLog($sqlContrato);
                    $idContrato = recuperaUltimo("contratos");
                    $mensagem = mensagem("success", "Cadastrado com sucesso!");

                } else {
                    $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");
                }
            }
        }
    }

    if (isset($_POST['edita'])){

        $sqlContrato = "UPDATE contratos SET 
                                          termo_contrato = '$termo_contrato', 
                                          tipo_servico = '$tipo_servico',
                                          tipo_pessoa_id = '$tipo_pessoa',
                                          pessoa_id = '$pessoa_id',
                                          unidade_id = '$idUnidade',
                                          equipamentos_id = '$idEquipamento',
                                          garantia =  '$garantia',
                                          vencimento = '$vencimento',
                                          negociacoes_reajustes =  '$negociacoes_reajustes',
                                          nivel_de_risco = '$nivel_risco',
                                          observacao = '$observacao',
                                          contrato_status_id = '$status'
                                  WHERE id = '$idContrato'";

        if (mysqli_query($con, $sqlContrato)) {

            gravarLog($sqlContrato);

            $contrato = recuperaDados("contratos", "id", $idContrato);
            $idFiscal = $contrato['fiscal_id'];
            $idSuplente = $contratos['suplente_id'];

            $sqlFiscal = "UPDATE fiscais SET 
                                          nome_fiscal = '$fiscal', 
                                          contato_fiscal = '$contatoFiscal'
                                      WHERE id = '$idFiscal'";

            if (mysqli_query($con, $sqlFiscal)) {

                gravarLog($sqlFiscal);

                $sqlSuplente = "UPDATE suplentes SET 
                                                nome_suplente = '$suplente', 
                                                contato_suplente = '$contatoSuplente'
                                      WHERE id = '$idSuplente'";

                if (mysqli_query($con, $sqlSuplente)) {
                    gravarLog($sqlSuplente);
                    $mensagem = mensagem("success", "Atualizado com sucesso!");

                } else {
                    $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
                }
            }
        }
    }
}

$fical = recuperaDados("fiscais", "id", $idFiscal);
$suplente = recuperaDados("suplentes", "id", $idSuplente);
$contratos = recuperaDados("contratos", "id", $idContrato);



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Contrato</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
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
                    <form method="POST" action="?perfil=contratos/contrato_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="num_processo">Número do processo administrativo</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" maxlength="20" value="<?= $licitacao['numero_processo'];  ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="termo_contrato">Termo de contrato *</label>
                                    <input type="text" id="termo_contrato" name="termo_contrato" class="form-control" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tipo_servico">Tipo de serviço *</label>
                                    <input type="text" id="tipo_servico" name="tipo_servico" class="form-control" maxlength="80" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="objeto">Objeto *</label>
                                    <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <form method='POST'>
                                        <label for="pesquisaEmpresa">Empresa</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name='cnpj' maxlength='19' minlength='19' class="form-control" placeholder="Buscar">
                                            <div class="input-group-btn">
                                                <button type="submit" name='pesquisaEmpresa' class="btn btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="form-group col-md-3">
                                    <form method='POST'>
                                        <label for="pesquisaPf">Pessoa Fisíca</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" name='cpf' maxlength='19' minlength='11' class="form-control" placeholder="Buscar">
                                            <div class="input-group-btn">
                                                <button type="submit" name='pesquisaPf' class="btn btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="unidade">Unidade *</label>
                                    <select class="form-control" id="unidade" name="unidade">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades")
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <!-- Campo populado de acordo com a escolha da unidade -->
                                    <label for="equipamentos">Equipamentos atendidos</label> <br>
                                    <select class="form-control" id="equipamentos" name="equipamentos">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("equipamentos")
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="fiscal">Fiscal</label>
                                    <input type="text" id="fiscal" name="fiscal" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="fiscal_contato">Contato do fiscal</label>
                                    <input type="text" id="fiscal_contato" name="fiscal_contato" class="form-control" maxlength="60">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="suplente">Suplente</label>
                                    <input type="text" id="suplente" name="suplente" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="suplente_contato">Contato do suplente</label>
                                    <input type="text" id="suplente_contato" name="suplente_contato" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-6" align="center" style="margin-top: 10px">
                                    <label for="garantia">Garatia? </label> <br>
                                    <label><input type="radio" name="garantia" value="2"> Sim </label>&nbsp;&nbsp;
                                    <label><input type="radio" name="garantia" value="1"> Não </label>
                                </div>
                            </div>

                            <hr />

                            <div align="center">
                                <h2>Informações do contrato</h2>
                            </div>
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
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" placeholder="Valor em formato decimal *">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="observacao">Negociações / Reajuste</label>
                                    <textarea type="text" id="observacao" name="observacao" class="form-control" rows="3" maxlength="125" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nivel_risco">Nível de risco</label>
                                    <textarea type="text" id="nivel_risco" name="nivel_risco" class="form-control" maxlength="250" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="observacao">Observação *</label>
                                    <textarea type="text" id="observacao" name="observacao" class="form-control" maxlength="250" rows="3" required></textarea>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 25px">
                                    <label for="vencimento">Vencimento</label>
                                    <input type="date" id="vencimento" name="vencimento" class="form-control" maxlength="60" readonly>
                                </div>
                                <div class="form-group col-md-3" style="margin-top: 25px">
                                    <label for="status">Status *</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("contrato_status")
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="idContrato" value="<?= $idContrato ?>">
                            <button type="submit" name="edita" class="btn btn-primary pull-right">Editar</button>
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
