<?php
include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

if (isset($_GET['token']))
{
    $token = $_GET['token'];
    $sqlConsultaToken = "SELECT `email` FROM `reset_senhas` WHERE token = '$token' LIMIT 1";

    if ($con->query($sqlConsultaToken)->num_rows <= 0)
    {
        $mensagem = callout("danger","Link Inválido! Tente recuperar sua senha novamente. Redirecionando a tela de login.");
        echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=index.php'>";
    }
}
else
{
    header('location: ./index.php');
}

if (isset($_POST['reset'])) {
    $token = $_POST['token'];
    $novaSenha = $_POST['novaSenha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    if ($novaSenha == $confirmaSenha)
    {
        $sqlConsultaToken = "SELECT `email` FROM `reset_senhas` WHERE token = '$token' LIMIT 1";
        $queryToken = $con->query($sqlConsultaToken);

        if ($queryToken)
        {
            $email = $queryToken->fetch_assoc()['email'];
            $senha = md5($novaSenha);
            $sqlNovaSenha = "UPDATE usuarios SET senha = '$senha' WHERE email = '$email'";

            if ($con->query($sqlNovaSenha))
            {
                gravarLog($sqlNovaSenha);
                $mensagem = callout("success","Senha atualizada com sucesso! Redirecionando a página de login!");
                $con->query("DELETE FROM `reset_senhas` WHERE `token` = '$token'");
                echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=index.php'>";
            }
            else
            {
                $mensagem = callout("danger","Erro ao atualizar! Tente novamente");
            }
        }
        else
        {
            $mensagem = callout("danger","Link Inválido! Tente recuperar sua senha novamente");
        }
    }
    else
    {
        $mensagem = callout("danger","Senhas não conferem");
    }

//    // Grab to token that came from the email link
//    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
//    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
//    if (count($errors) == 0) {
//        // select email address of user from the password_reset table
//        $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
//        $results = mysqli_query($db, $sql);
//        $email = mysqli_fetch_assoc($results)['email'];
//
//        if ($email) {
//            $new_pass = md5($new_pass);
//            $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
//            $results = mysqli_query($db, $sql);
//            header('location: index.php');
//        }
//    }
}
?>

<!DOCTYPE html>
<html ng-app="sigCon">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SigCon | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="visual/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="visual/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="visual/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="visual/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="visual/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo"><b>SIGCON</b></div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Recuperação de Senha</p>
        <?= isset($mensagem) ? $mensagem : "" ?>

        <form action="reset.php?token=<?= $_GET['token'] ?>" method="post">
            <div class="form-group has-feedback">
                <label for="novaSenha">Nova senha: </label>
                <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
            </div>
            <div class="form-group has-feedback" id="divConfirmaSenha">
                <label for="confirmaSenha">Confirmar Senha: </label>
                <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha"
                       onblur="comparaSenhas()" onkeypress="comparaSenhas()" required>
                <span class="help-block" id="spanHelp"></span>
            </div>
            <div class="row form-group">
                <div class="col-xs-12">
                    <input type="hidden" name="reset">
                    <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
                    <button type="submit" id="atualizar" class="btn btn-primary btn-block btn-flat" >Atualizar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="index.php">Voltar a tela de Login</a>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="visual/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="visual/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="visual/plugins/iCheck/icheck.min.js"></script>
<!--Frufru do login em angular-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
<script language="JavaScript">
    function comparaSenhas() {
        let senha = document.getElementById("novaSenha");
        let confirmaSenha = document.getElementById("confirmaSenha");
        let divConfirmaSenha = document.getElementById("divConfirmaSenha");
        document.getElementById("atualizar").disabled = true;
        divConfirmaSenha.classList.add("has-error");
        document.getElementById("spanHelp").innerHTML = "Senha não confere";

        if (senha.value == confirmaSenha.value) {
            document.getElementById("atualizar").disabled = false;
            divConfirmaSenha.classList.remove("has-error");
            document.getElementById("spanHelp").innerHTML = "";

        } else {
        }
    }
</script>
</body>
</html>
