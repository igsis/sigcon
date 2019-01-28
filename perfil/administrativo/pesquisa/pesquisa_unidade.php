<?php
include "../perfil/includes/menu.php";
$conn = bancoPDO();

$unidades = $conn->query("SELECT * FROM unidades")->fetchAll();

if (isset($_POST['pesquisarUnidade'])){
    $unidade = $_POST['unidade'];

    $query = $conn->prepare("SELECT * FROM unidades WHERE nome = :unidade");
    $query->execute(['unidade' => $unidade]);
    $unidades = $query->fetchAll();
}

if (isset($_POST['exluir'])){
    $idUnidade = $_POST['idUnidadeExcluir'];

    
}


?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>Pesquisa Licitação</h1>
    </section>

    <section class="content">
        <div class="col-xs-12">
            <div class="box-body">
                <div class='col-md-6'>

                    <div class="form-group">
                        <div class="form-group">
                            <form method='POST'>
                                <label for="exampleInputEmail1">Nome da unidade</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name='unidade' maxlength='19' minlength='19' class="form-control pull-right" placeholder="Buscar">
                                    <div class="input-group-btn">
                                        <button type="submit" name='pesquisarUnidade' class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Pesquisa de unidade</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Nome da unidade</th>
                            <th>Sigla</th>
                            <th>Unidade Orçamentária</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>

                        <?php
                        foreach ($unidades as $unidade) {
                            ?>
                            <tr>
                                <td><?= $unidade['nome'] ?></td>
                                <td><?= $unidade['sigla'] ?></td>
                                <td><?= $unidade['unidade_orcamentaria'] ?></td>
                                <td>
                                    <form action="?perfil=administrativo/licitacao/unidade_edita" method='POST'>
                                        <input type="hidden" name='idUnidadeEdita' value='<?= $unidade['id'] ?>'>
                                        <button type='submit' name="carregar" class='btn btn-info'> Carregar </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="?perfil=administrativo/licitacao/pesquisa_unidade">
                                        <input type="hidden" name="idUnidadeExcluir" value='<?= $unidade['id']?>'>
                                        <button type="submit" name="excluir" class='btn btn-danger'>Excluir</button>
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