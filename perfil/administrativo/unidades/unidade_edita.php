<?php
$con = bancoMysqli();

if (isset($_POST['cadastra']) || isset($_POST['edita']) || isset($_POST['idUnidade'])) {
    $idUnidade = $_POST['idUnidade'] ?? NULL;
    $un_nome = $_POST['un_nome'] ?? null;
    $un_sigla = $_POST['un_sigla'] ?? null;
    $un_orcamentaria = $_POST['un_orcamentaria'] ?? null;

    if (isset($_POST['cadastra'])) {

       $sql = "INSERT INTO unidades (nome, 
                                     sigla,
                                     unidade_orcamentaria, 
                                     publicado)
                            VALUES ('$un_nome',
                                    '$un_sigla',
                                    '$un_orcamentaria',
                                    '1' )";

       if (mysqli_query($con, $sql)) {

           $idUnidade = recuperaUltimo("unidades");

           $mensagem = mensagem("success", "Unidade cadastrada com sucesso!");
           gravarLog($sql);

       } else {
           $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
       }

    }

    if (isset($_POST['edita'])) {
        $sql = "UPDATE unidades SET 
                              nome  = '$un_nome',
                              sigla = '$un_sigla', 
                              unidade_orcamentaria = '$un_orcamentaria'
                        WHERE id = '$idUnidade'";


        if (mysqli_query($con, $sql)) {

            $mensagem = mensagem("success", "Unidade editada com sucesso!");
            gravarLog($sql);

        } else {

            $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
        }
    }
}

$unidade = recuperaDados("unidades", "id", $idUnidade);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Editar Unidade</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?= "Nome da unidade: " . $unidade['nome']?>
                        </h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=unidades&sp=unidade_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="un_nome">Nome da Unidade *</label>
                                    <input type="text" id="un_nome" name="un_nome" class="form-control" maxlength="60" value="<?= $unidade['nome']  ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="un_sigla">Sigla *</label>
                                    <input type="text" id="un_sigla" name="un_sigla" class="form-control" maxlength="10" value="<?= $unidade['sigla']  ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="un_orcamentaria">Unidade Orçamentária *</label>
                                    <input type="text" data-mask="00.00" id="un_orcamentaria" name="un_orcamentaria" class="form-control" maxlength="100" value="<?= $unidade['unidade_orcamentaria']  ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="hidden" name="idUnidade" value="<?= $idUnidade ?>">
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
