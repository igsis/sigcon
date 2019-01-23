<?php
include "../perfil/includes/menu.php";

$con = bancoMysqli();

    if (isset($_POST['cadastra']) || isset($_POST['edita'])) {
        $idUsuario = $_POST['idUsuario'] ?? NULL;
        $nome_completo = $_POST['nome'];
        $RF = $_POST['rf_usuario'];
        $telefone = $_POST['tel_usuario'];
        $email = $_POST['email'];
        $unidade_id = $_POST['unidade_id'];
        $nivel_acesso = $_POST['nivel_acesso'];

        if (isset($_POST['cadastra'])) {

            $sql = "INSERT INTO usuarios (nome_completo, 
                                           RF,
                                           telefone, 
                                           email, 
                                           unidade_id, 
                                           nivel_acesso_id, 
                                           publicado) 
                                  VALUES ('$nome_completo',
                                           '$RF', 
                                           '$telefone', 
                                           '$email', 
                                           '$unidade_id',
                                           '$nivel_acesso',
                                            1)";

            if (mysqli_query($con, $sql)) {

                $idUsuario = recuperaUltimo("usuarios");
                $mensagem = mensagem("success", "Usuário cadastrado com sucesso!");

            } else {
                $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
            }
        }


        if (isset($_POST['edita'])) {
            $sql = "UPDATE usuarios SET 
                                        nome_completo = '$nome_completo', 
                                        RF = '$RF', 
                                        telefone = '$telefone', 
                                        email = '$email',
                                        unidade_id = '$unidade_id',
                                        nivel_acesso_id = '$nivel_acesso'
                                        WHERE id = '$idUsuario'";
            if (mysqli_query($con, $sql)) {

                $mensagem = mensagem("success", "Usuário editado com sucesso!");

            } else {
                $mensagem = mensagem("danger", "Erro ao atualizar! Tente novamente.");
            }
        }
    }


    $usuario = recuperaDados("usuarios", "id", $idUsuario);



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Editar Usuário</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nome do usuário: <?= $usuario['nome_completo']; ?></h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo/usuario/usuario_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nome">Nome Completo *</label>
                                    <input type="text" id="nome" name="nome" class="form-control" value="<?= $usuario['nome_completo']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="rf_usuario">RF *</label>
                                    <input data-mask="000.000.0" type="text" id="rf_usuario" name="rf_usuario" class="form-control" value="<?= $usuario['RF']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tel_usuario">Telefone *</label>
                                    <input data-mask="(00) 0000-00000" type="text" id="tel_usuario" name="tel_usuario" class="form-control" maxlength="100" value="<?= $usuario['telefone']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail *</label>
                                    <input type="text" id="email" name="email" class="form-control" value="<?= $usuario['email']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="unidade_id">Unidade *</label>
                                    <select class="form-control" id="unidade_id" name="unidade_id">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades", $usuario['unidade_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nivel_acesso">Nível de acesso </label> <br>
                                    <select class="form-control" id="nivel_acesso" name="nivel_acesso">
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("nivel_acessos", $usuario['nivel_acesso_id']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">
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
