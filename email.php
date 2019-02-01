<?php
include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

if (isset($_POST['reset']))
{
    $token = bin2hex(random_bytes(50));
    $email = trim($_POST['email']);


    $sqlConsulta = "SELECT * FROM `usuarios` WHERE email = '$email'";
    $queryConsulta = $con->query($sqlConsulta);
    if ($queryConsulta->num_rows > 0)
    {
        // store token in the password-reset database table against the user's email
        $sqlConsultaToken = "SELECT * FROM `reset_senhas` WHERE `email` = '$email'";
        if ($con->query($sqlConsultaToken)->num_rows > 0)
        {
            $sqlToken = "UPDATE `reset_senhas` SET `token` = '$token' WHERE `email` = '$email'";
        }
        else
        {
            $sqlToken = "INSERT INTO `reset_senhas`(email, token) VALUES ('$email', '$token')";
        }
        $results = $con->query($sqlToken);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Recuperação de Senha Sigcon";
        $msg = emailReset($token);

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= "De: no.reply.smcsistemas@gmail.com\r\n";
        mail($to, $subject, $msg, $headers);

        $texto = "Enviamos um email para <b>$email</b> para a reiniciarmos sua senha. <br>
                    Por favor acesse seu email e clique no link recebido para cadastrar uma nova senha!";
        $mensagem = callout("success", $texto);
    }
    else
    {
        $mensagem = callout("danger", "E-mail não cadastrado");
    }

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

        <form action="email.php" method="post">
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="row form-group">
                <div class="col-xs-12">
                    <input type="hidden" name="reset">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
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
</body>
</html>
