<?php
$conn = bancoPDO();
$con = bancoMysqli();

if (isset($_POST['cadastra'])) {
    $idUsuario = (isset($_POST['idUsuario']) ? $_POST['idUsuario'] : NULL);
    $usuario = $_POST['usuario'];
    $nome_completo = $_POST['nome'];
    $RF = $_POST['rf_usuario'];
    $telefone = $_POST['tel_usuario'];
    $email = $_POST['email'];
    $unidade_id = $_POST['unidade_id'];
    $nivel_acesso = $_POST['nivel_acesso'];

    $senha = md5("sigcon2019");

    $sql = "INSERT INTO usuarios (nome_completo, 
                                           usuario,
                                           senha,
                                           RF,
                                           telefone, 
                                           email, 
                                           unidade_id, 
                                           nivel_acesso_id, 
                                           publicado) 
                                  VALUES ('$nome_completo',
                                           '$usuario',
                                           '$senha',
                                           '$RF', 
                                           '$telefone', 
                                           '$email', 
                                           '$unidade_id',
                                           '$nivel_acesso',
                                            1)";

    if ($conn->query($sql))
    {
        $idUsuario = $con->insert_id;
        gravarLog($sql);
        $mensagem = mensagem("success", "Usuário cadastrado com sucesso!");
    }
    else
    {
        $mensagem = mensagem("danger", "Erro ao gravar! Tente novamente.");
    }
}

if(isset($_POST['excluiUsuario'])){
    $usuario = $_POST['idUsuario'];
    $stmt = $conn->prepare("UPDATE `usuarios` SET publicado = 0 WHERE id = :id");
    $stmt->execute(['id' => $usuario ]);
    $mensagem = mensagem("success", "Usuário excluido com sucesso!");
}

$usuarios  = $conn->query("SELECT * FROM `usuarios` WHERE publicado = 1")->fetchAll();

?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>Pesquisa Usuário</h1>
    </section>

    <section class="content">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lista de Usuário</h3>
                    <a href="?perfil=administrativo&p=usuario&sp=usuario_cadastro" class="text-right btn btn-success" style="float: right">Adicionar Usuario</a>
                </div>
                <!-- /.box-header -->

                <div class="row" align="center">
                    <?php if (isset($mensagem)) {
                        echo $mensagem;
                    }; ?>
                </div>

                <div class="box-body table-responsive">
                    <table id="tblUsuario" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nome Completo</th>
                                <th>Usuário</th>
                                <th>Nivel de Acesso</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($usuarios as $usuario) {
                            $nivel_acesso = recuperaDados('nivel_acessos', 'id', $usuario['nivel_acesso_id'] )['nivel_acesso'];
                            ?>
                            <tr>
                                <td><?= $usuario['usuario'] ?></td>
                                <td><?= $usuario['nome_completo'] ?></td>
                                <td><?= $nivel_acesso ?></td>
                                <td>
                                    <form action="?perfil=administrativo&p=usuario&sp=usuario_edita" method='POST'>
                                        <input type="hidden" name='idUsuario' value='<?= $usuario['id'] ?>'>
                                        <button type="submit" class='btn btn-info' name="carrega"> Editar </button>
                                        <button type="button" class='btn btn-danger' data-toggle="modal" data-target="#confirmApagar" data-id="<?= $usuario['id'] ?>" data-nome="<?= $usuario['nome_completo'] ?>"> Excluir </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nome Completo</th>
                                <th>Usuário</th>
                                <th>Nivel de Acesso</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                    <!-- Confirmação de Exclusão -->
                    <div class="modal fade modal-danger" id="confirmApagar" name="confirmApagar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="titulo"> </h4>
                                </div>
                                <div class="modal-body">
                                    <p>Confirma?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                    <form method="POST" id="formExcliuir">
                                        <input type="hidden" name='idUsuario'>
                                        <button type="submit" class="btn btn-danger" id="excluiUsuario" name="excluiUsuario">Remover</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Confirmação de Exclusão -->
            </div>
        </div>
    </section>

</div>

<script type="text/javascript" defer src="../visual/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" defer src="../visual/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" defer>
    $(function () {
        $('#tblUsuario').DataTable({
            "language": {
                "url": 'bower_components/datatables.net/Portuguese-Brasil.json'
            },
            "responsive": true,
            "dom": "<'row'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7 text-right'p>>",
        });
    })
</script>

<script type="text/javascript">
    // language=JQuery-CSS
    $('#confirmApagar').on('show.bs.modal', (e) =>
    {
        document.querySelector('#titulo').innerHTML = "Excluir " + ` ${e.relatedTarget.dataset.nome}?`
        document.querySelector('#formExcliuir input[name="idUsuario"]').value = e.relatedTarget.dataset.id
    });
</script>