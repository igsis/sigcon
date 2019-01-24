<?php
include "../perfil/includes/menu.php";
$conn = bancoPDO();

$usuarios  = $conn->query("SELECT * FROM `usuarios`")->fetchAll();

if(isset($_POST['pesquisaUsuario'])){
    $usuario  = $_POST['usuario'];
    $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario ]);
    $usuarios = $stmt->fetchAll();
}

if(isset($_POST['pesquisaNivel'])){
    $nivel_acesso = $_POST['nivel_acesso'];
    $stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE nivel_acesso_id = :id");
    $stmt->execute(['id' => $nivel_acesso ]);
    $usuarios = $stmt->fetchAll();
}

?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>Pesquisa Usuário</h1>
    </section>

    <section class="content">
        <div class="col-xs-12">
            <div class="box-body">
                <div class='col-md-6'>

                    <div class="form-group">
                        <div class="form-group">
                            <form method='POST'>
                                <label for="usuario">Usuário </label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name='usuario' maxlength='7' minlength='7' class="form-control pull-right" placeholder="Buscar">
                                    <div class="input-group-btn">
                                        <button type="submit" name='pesquisaUsuario' class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="form-group">
                        <form method='POST'>
                            <label for="nievlAcesso">Nivel Acesso</label>
                            <div class="input-group input-group-sm">
                                <select name="nivel_acesso" id="nivel_acesso" class="form-control pull-right">
                                    <?php
                                        geraOpcao('nivel_acessos');
                                    ?>
                                </select>
                                <div class="input-group-btn">
                                    <button type="submit" name='pesquisaNivel' class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Pesquisa Usuário</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Nome Completo</th>
                            <th>Usuário</th>
                            <th>Nivel de Acesso</th>
                            <th>Editar</th>
                        </tr>

                        <?php
                        foreach ($usuarios as $usuario) {
                            $nivel_acesso = recuperaDados('nivel_acessos', 'id', $usuario['nivel_acesso_id'] )['nivel_acesso'];
                            ?>
                            <tr>
                                <td><?= $usuario['usuario'] ?></td>
                                <td><?= $usuario['nome_completo'] ?></td>
                                <td><?= $nivel_acesso ?></td>
                                <td>
                                    <form action="?perfil=administrativo/usuario/usuario_edita" method='POST'>
                                        <input type="hidden" name='idUsuario' value='<?= $usuario['id'] ?>'>
                                        <button type="submit" class='btn btn-info' name="carrega"> Carregar </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>