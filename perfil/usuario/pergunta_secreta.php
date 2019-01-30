<?php

include "../perfil/includes/menu.php";

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$usuario = recuperaDados('usuarios', 'id', $idUser);

$mensagem = mensagem("warning", "Para acessar o sistema, cadastre sua Pergunta e Resposta Secreta");

if (isset($_POST['atualizar']))
{
    $pergunta = $_POST['pergunta'];
    $resposta = addslashes($_POST['resposta']);

    $sqlPergunta = "UPDATE `usuarios` SET
                      `frase_seguranca_id` = '$pergunta',
                      `resposta_frase_seguranca` = '$resposta'
                    WHERE `id` = '$idUser'";
    if ($con->query($sqlPergunta))
    {
        gravarLog($sqlPergunta);
        $mensagem = mensagem("success", "Cadastrado com sucesso! Redirecionando ao sistema!");

        switch ($_SESSION['nivelAcesso'])
        {
            case 1:
                echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=?perfil=administrativo'>";
                break;

            case 2:
                echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=?perfil=contratos'>";
                break;

            case 3:
                echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=?perfil=pesquisa'>";
                break;

            default:
                echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=?perfil=pesquisa'>";
                break;
        }
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente!");
    }
}


$usuario = recuperaDados('usuarios', 'id', $idUser);

?>


<div class="content-wrapper">
    <section class="content">

        <h2 class="page-header">Cadastro de Pergunta Secreta</h2>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Usuário: <?= $usuario['usuario'] ?></h3>
                    </div>
                    <div class="row" align="center">
                        <?php if (isset($mensagem)) {
                            echo $mensagem;
                        }; ?>
                    </div>

                    <form method="POST" action="?perfil=usuario/pergunta_secreta.php" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pergunta">Pergunta Secreta:</label>
                                    <select class="form-control" name="pergunta" id="pergunta" required>
                                        <option value="">Selecione...</option>
                                        <?php geraOpcao('frase_seguranca', '') ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="resposta">Resposta:</label>
                                    <input class="form-control" type="text" id="resposta" name="resposta" maxlength="15" required>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" name="atualizar" id="atualizar" class="btn btn-info pull-right">
                                    Cadastrar
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</div>