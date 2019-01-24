<?php
include "../perfil/includes/menu.php";
$conn = bancoPDO();

$licitacoes  = $conn->query("SELECT * FROM `licitacoes`")->fetchAll();
$unidades    = $conn->query("SELECT * FROM `unidades`")->fetchAll();

if(isset($_POST['pesquisaNumProcesso']) && '' != $_POST['numProcesso']){
    $numProcesso  = $_POST['numProcesso'];
    $stmt = $conn->prepare("SELECT * FROM `licitacoes` WHERE numero_processo = :id");
    $stmt->execute(['id' => $numProcesso ]);
    $licitacoes = $stmt->fetchAll();
}

if(isset($_POST['pesquisaObjeto'])){
    $objeto  = $_POST['objeto'];
    $stmt = $conn->prepare("SELECT * FROM `licitacoes` WHERE objeto LIKE :objeto ");
    $stmt->execute(['objeto' => "%$objeto%" ]);
    $licitacoes = $stmt->fetchAll();
}


if(isset($_POST['pesquisaUnidade']) && '0' != $_POST['unidade'] ){
    $idUnidade  = $_POST['unidade'];
    $stmt = $conn->prepare("SELECT * FROM `licitacoes` WHERE unidade_id = :unidade ");
    $stmt->execute(['unidade' => $idUnidade ]);
    $licitacoes = $stmt->fetchAll();   
}

?>

<div class="content-wrapper">

    <section class="content-header">
      <h1>Pesquisa Licitação </h1>
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
                                        <form action="?perfil=contratos/tipo_pessoa" method='POST'>
                                            <input type="hidden" name='idLicitacao' value='<?= $licitacao['id'] ?>'>
                                            <button type='submit' class='btn btn-info'> Carregar </button>
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