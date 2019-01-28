<?php
include "../perfil/includes/menu.php";
$conn = bancoPDO();

$licitacoes  = $conn->query("SELECT * FROM `licitacoes` WHERE publicado = '1' ")->fetchAll();
$unidades    = $conn->query("SELECT * FROM `unidades`")->fetchAll();

if(isset($_POST['pesquisaNumProcesso']) && '' != $_POST['numProcesso']){
    $numProcesso  = $_POST['numProcesso'];
    $stmt = $conn->prepare("SELECT * FROM `licitacoes` WHERE publicado = '1' AND numero_processo = :id");
    $stmt->execute(['id' => $numProcesso ]);
    $licitacoes = $stmt->fetchAll();
}

if(isset($_POST['pesquisaObjeto'])){
    $objeto  = $_POST['objeto'];
    $stmt = $conn->prepare("SELECT * FROM `licitacoes` WHERE  publicado = '1' AND objeto LIKE :objeto ");
    $stmt->execute(['objeto' => "%$objeto%" ]);
    $licitacoes = $stmt->fetchAll();
}


if(isset($_POST['pesquisaUnidade']) && '0' != $_POST['unidade'] ){
    $idUnidade  = $_POST['unidade'];
    $stmt = $conn->prepare("SELECT * FROM `licitacoes` WHERE  publicado = '1' AND unidade_id = :unidade ");
    $stmt->execute(['unidade' => $idUnidade ]);
    $licitacoes = $stmt->fetchAll();   
}


if(isset($_POST['excluirLicitacao'])){
    $idLicitacao  = $_POST['excluirLicitacao'];
    $stmt = $conn->prepare("UPDATE`licitacoes` SET publicado = '1' WHERE id = :idLicitacao ");
    $stmt->execute(['idLicitacao' => $idLicitacao ]);
    $licitacoes = $stmt->fetchAll();  
    $licitacoes  = $conn->query("SELECT * FROM `licitacoes` WHERE publicado = '1' ")->fetchAll(); 
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
                                <label for="exampleInputEmail1">Número do processo</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name='numProcesso' maxlength='19' minlength='19' class="form-control pull-right" placeholder="Buscar">
                                    <div class="input-group-btn">
                                        <button type="submit" name='pesquisaNumProcesso' class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="form-group">
                        <form method='POST'>
                            <label for="exampleInputEmail1">Objeto</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="objeto" class="form-control pull-right" placeholder="Buscar">
                                <div class="input-group-btn">
                                    <button type="submit" name='pesquisaObjeto' class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="form-group">
                        <form method='POST'>
                            <label for="exampleInputEmail1">Unidade</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control pull-right" name="unidade" id="">
                                    <option value="0">Selecione a Unidade</option>
                                    <?php 
                                        foreach($unidades as $unidade){
                                    ?>
                                        <option value="<?= $unidade['id'] ?>"><?= $unidade['nome'] ?></option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                                
                                <div class="input-group-btn">
                                    <button type="submit" name='pesquisaUnidade' class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Pesquisa Licitação</h3>            
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Número do processo administrativo</th>
                                <th>Objeto</th>
                                <th>Unidade</th>
                                <th>Editar</th>
                                <th>Excluir</th>
                            </tr>

                            <?php 
                                foreach ($licitacoes as $licitacao) {
                                    $unidade = recuperaDados('unidades', 'id', $licitacao['unidade_id'] )['nome'];
                            ?>
                                <tr>
                                    <td><?= $licitacao['numero_processo'] ?></td>
                                    <td><?= $licitacao['objeto'] ?></td>
                                    <td><?= $unidade ?></td> 
                                    <td>
                                        <form action="?perfil=administrativo/licitacao/licitacao_edita" method='POST'>
                                            <input type="hidden" name='editarLicitacao' value='<?= $licitacao['id'] ?>'>
                                            <button type='submit' class='btn btn-info'> Carregar </button>
                                        </form>
                                    </td> 
                                    <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluirLicitacao" data-id='<?= $licitacao['id'] ?>' data-objeto='<?= $licitacao['objeto'] ?>'>
                                        Excluir
                                    </button>
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

<div class="modal modal-danger fade in" id="excluirLicitacao" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Danger Modal</h4>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a licitação <span> </span> </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Sair</button>
                <form method='POST' id='formExcliuir'>
                    <input type="hidden" name='excluirLicitacao' >
                    <button type='submit' class="btn btn-outline"> Excluir </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#excluirLicitacao').on('show.bs.modal', (e) =>
    {
        document.querySelector('#excluirLicitacao .modal-body p span').innerHTML = ` ${e.relatedTarget.dataset.objeto}?`
        document.querySelector('#formExcliuir input[name="excluirLicitacao"]').value = e.relatedTarget.dataset.id
    });

</script>

