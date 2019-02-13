<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();
$conn = bancoPDO();

    if (isset($_POST['cadastra']) || isset($_POST['edita'])) {

        $idContrato = $_POST['idContrato'];

        $sqlAditivo = "SELECT * FROM aditivos WHERE contrato_id = '$idContrato'";
        $queryADT = mysqli_query($con, $sqlAditivo);
        $num_rows = mysqli_num_rows($queryADT);

        if ($num_rows > 0) {
            $sqlZerarUltimo = "UPDATE aditivos SET valor_reajuste = '0.00' WHERE contrato_id = '$idContrato' AND aditivo_numero = '$num_rows'";
            mysqli_query($con, $sqlZerarUltimo);
            $qtde = ++$num_rows;
        } else {
            $qtde = 1;
        }

        $sqlInformacoesAditivo = "SELECT * FROM informacoes_do_contrato WHERE contrato_id = '$idContrato'";
        $queryInfoADT = mysqli_query($con, $sqlInformacoesAditivo);
        $followingdata = $queryInfoADT->fetch_assoc();

        $contratoValorMensal = $followingdata['valor_mensal'];

        $idAditivo = $_POST['idAditivo'] ?? NULL;
        $inicio_vigencia = $_POST['inicio_vigencia'];
        $fim_vigencia = $_POST['fim_vigencia'];
        $DOU = $_POST['dou'];
        $valor_mensal = dinheiroDeBr($_POST['valor_mensal']);
        $valor_anual = dinheiroDeBr($_POST['valor_anual']);
        $reajuste = (float) $valor_mensal - $contratoValorMensal;

        if (isset($_POST['cadastra'])) {
            $sql = "INSERT INTO aditivos 
                                      (contrato_id,
                                      aditivo_numero,
                                      inicio_vigencia, 
                                      fim_vigencia,
                                      DOU,
                                      valor_mensal,
                                      valor_reajuste,
                                      valor_anual,
                                      publicado)
                              VALUES ('$idContrato', 
                                      '$qtde', 
                                      '$inicio_vigencia',
                                      '$fim_vigencia',
                                      '$DOU', 
                                      '$valor_mensal',
                                      '$reajuste',
                                      '$valor_anual',
                                      '1')";

            if (mysqli_query($con, $sql)) {
                gravarLog($sql);

                $idAditivo = recuperaUltimo("aditivos");

                $mensagem = mensagem("success", "Aditivo cadastrado com sucesso!");

            } else {
                $mensagem = mensagem("danger", "Erro ao cadastrar! Tente novamente.");
            }

        }

        if (isset($_POST['edita'])) {

            $sql = "UPDATE aditivos SET 
                                      contrato_id = '$idContrato',
                                      aditivo_numero = '$qtde',
                                      inicio_vigencia = '$inicio_vigencia', 
                                      fim_vigencia = '$fim_vigencia',
                                      DOU = '$DOU',
                                      valor_mensal = '$valor_mensal',
                                      valor_reajuste = '$reajuste',
                                      valor_anual = '$valor_anual'
                                      WHERE id = '$idAditivo'";

            if (mysqli_query($con, $sql)) {
                gravarLog($sql);

                $mensagem = mensagem("success", "Atualizado com sucesso!");

            } else {
                $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
            }
        }
    }

    if(isset($_POST['visualizar'])){
        $idAditivo = $_POST['idAditivo'];
    }

    $aditivo = recuperaDados("aditivos", "id", $idAditivo);


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
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=contratos&p=aditivo&sp=aditivo_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Vigência início</label>
                                    <input type="date" name="inicio_vigencia" id='inicio_vigencia' class="form-control" value="<?= $aditivo['inicio_vigencia'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Vigência fim</label>
                                    <input type="date" name="fim_vigencia" id='fim_vigencia' class="form-control" value="<?= $aditivo['fim_vigencia'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>DOU</label>
                                    <input type="date" name="dou" id='dou' class="form-control" value="<?= $aditivo['dou'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="valor_mensal">Valor mensal</label>
                                    <input type="text" id="valor_mensal" name="valor_mensal" class="form-control" onKeyPress="return(moeda(this,'.',',',event))" value="<?= dinheiroParaBr($aditivo['valor_mensal']) ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_anual">Valor anual</label>
                                    <input type="text" id="valor_anual" name="valor_anual" class="form-control" onKeyPress="return(moeda(this,'.',',',event))" value="<?= dinheiroParaBr($aditivo['valor_anual']) ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_reajuste">Valor do reajuste</label>
                                    <input type="text" id="valor_reajuste" name="valor_reajuste" class="form-control" value="<?= dinheiroParaBr($aditivo['valor_reajuste']) ?>" readonly>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="idContrato" id="idContrato" value="<?= $idContrato ?>">
                                <input type="hidden" name="idAditivo" id="idAditivo" value="<?= $idAditivo ?>"></input>
                                <button type="submit" name="edita" class="btn btn-info pull-right">Salvar</button>
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
    function moeda(a, e, r, t) {
        let n = ""
            , h = j = 0
            , u = tamanho2 = 0
            , l = ajd2 = ""
            , o = window.Event ? t.which : t.keyCode;
        if (13 == o || 8 == o)
            return !0;
        if (n = String.fromCharCode(o),
        -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.length,
                 h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
            ;
        for (l = ""; h < u; h++)
            -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
        0 == (u = l.length) && (a.value = ""),
        1 == u && (a.value = "0" + r + "0" + l),
        2 == u && (a.value = "0" + r + l),
        u > 2) {
            for (ajd2 = "",
                     j = 0,
                     h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                    j = 0),
                    ajd2 += l.charAt(h),
                    j++;
            for (a.value = "",
                     tamanho2 = ajd2.length,
                     h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }
</script>