<?php
include "../perfil/pesquisa/includes/menu.php";

$con = bancoMysqli();

    if(isset($_POST['carrega'])){
        $idUsuario = (isset($_POST['idUsuario']) ? $_POST['idUsuario'] : NULL);
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

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="#" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nome">Nome Completo *</label>
                                    <input type="text" id="nome" name="nome" class="form-control" value="<?= $usuario['nome_completo']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rf_usuario">RF *</label>
                                    <input data-mask="000.000.0" type="text" id="rf_usuario" name="rf_usuario" class="form-control" value="<?= $usuario['RF']; ?>" onblur="geraUusario()" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rf_usuario">Usuário *</label>
                                    <input type="text" id="usuario" name="usuario" class="form-control" maxlength="7" required readonly value="<?= $usuario['usuario']; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tel_usuario">Telefone *</label>
                                    <input data-mask="(00) 0000-00000" type="text" id="tel_usuario" name="tel_usuario" class="form-control" maxlength="100" value="<?= $usuario['telefone']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail *</label>
                                    <input type="text" id="email" name="email" class="form-control" value="<?= $usuario['email']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="unidade_id">Unidade *</label>
                                    <select class="form-control" id="unidade_id" name="unidade_id" disabled>
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades", $usuario['unidade_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nivel_acesso">Nível de acesso </label> <br>
                                    <select class="form-control" id="nivel_acesso" name="nivel_acesso" disabled>
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("nivel_acessos", $usuario['nivel_acesso_id']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
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


    function geraUusario() {

        // pega o valor do RF
        var usuarioRf = document.querySelector("#rf_usuario").value;

        // tira os pontos do valor, ficando apenas os numeros
        usuarioRf = usuarioRf.replace(/[^0-9]/g, '');
        usuarioRf = parseInt(usuarioRf);

        // adiciona o d antes do rf
        usuarioRf = "d" + usuarioRf;

        // limita o rf a apenas o d + 6 primeiros numeros do rf
        let usuario = usuarioRf.substr(0, 7);

        // passa o valor para o input
        document.querySelector("[name='usuario']").value = usuario;
    }

</script>