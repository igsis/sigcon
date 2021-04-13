<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <!-- START FORM-->
        <h2 class="page-header">Cadastro de Licitação</h2>

        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Licitação</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="?perfil=administrativo&p=licitacao&sp=licitacao_edita" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="num_processo">Número do processo administrativo *</label>
                                    <input type="text" data-mask="0000.0000/0000000-0" id="num_processo" name="num_processo" class="form-control" placeholder="0000.0000/0000000-0" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="link_processo">Link do processo administrativo *</label>
                                    <input type="text" id="link_processo" name="link_processo" class="form-control" maxlength="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="objeto">Objeto *</label>
                                    <input type="text" id="objeto" name="objeto" class="form-control" maxlength="100" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="unidade">Unidade *</label>
                                    <select class="form-control" id="unidade" name="unidade" required>
                                        <option value="">Selecione...</option>
                                        <?php
                                        geraOpcao("unidades")
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="levantamento_preco" class='text-center'><strong>Levantamento de preço?</strong>
                                            <input type="checkbox" class="check" name='levantamento_preco' id='levantamento_preco' />
                                        </label>                                        
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="reserva" class='text-center'><strong>Reserva? </strong>
                                            <input type="checkbox" class="check" name="reserva" id='reserva'  />
                                        </label>                                      
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="elaboracao_edital" class='text-center'><strong>Elaboração de Edital?</strong>
                                            <input type="checkbox" class="check" name="elaboracao_edital" id="elaboracao_edital" />
                                        </label> 
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="analise_edital" class='text-center'><strong>Análise / Ajuste do Edital? </strong>
                                            <input type="checkbox" class="check" name="analise_edital"  id='analise_edital' /> 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="licitacao">Licitação</label> <br>
                                    <input type="date" name="licitacao" id="licitacao" class="form-control licitacao" />
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="obs_licitacao">Licitação Observação</label>
                                    <input type="text" id="obs_licitacao" name="obs_licitacao" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="checkbox">
                                        <label for="homologacao" class='text-center'><strong>Homologação / Recurso?</strong>
                                            <input type="checkbox" class="check" name="homologacao" id='homologacao' />
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="obs_homologacao">Homologação Observação</label>
                                    <input type="text" id="obs_homologacao" name="obs_homologacao" class="form-control" maxlength="60">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <div class="checkbox">
                                        <label for="empenho" class='text-center'><strong>Empenho?</strong>
                                            <input type="checkbox" class="check" name="empenho" id='empenho' />
                                        </label>
                                    </div>                                        
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="obs_empenho">Empenho Observação</label>
                                    <input type="text" id="obs_empenho" name="obs_empenho" class="form-control" maxlength="60">
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="checkbox">
                                        <label for="entrega" class='text-center'> <strong>Entrega? </strong>
                                            <input type="checkbox" class="check" name="entrega" id='entrega' />
                                        </label>                                    
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ordem_inicio">Ordem de Início</label>
                                    <input type="date" name="ordem_inicio" id='ordem_inicio' class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observacao">Observação</label>
                                    <input type="text" id="observacao" name="observacao" class="form-control" maxlength="250">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="cadastra" class="btn btn-info pull-right">Cadastrar</button>
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

    let checks = document.querySelectorAll('.check');

    for (const key in checks) {
        if(key != 0){
            checks[key].disabled = true           
        }
    }

    // Função que desabilita todos os checkbox que forem maiores que a checkbox === false
    const disableMaiorqueAtual = () => {
        for (const key in checks) {
            if(checks[key].disabled == true && checks[key].checked == true){
                let cont = key
                do {
                    checks[cont].checked = false
                    checks[cont].disabled = true
                    cont ++
                }while(cont <= 6)
            }
        }
    }

    for (let i = 0; i < checks.length; i++) {
        const check = checks[i];
        check.addEventListener('change', () => {
            if(checks[i].checked === true){
                checks[(i + 1 )].disabled = false
            }else{
                checks[(i + 1 )].disabled = true
            }
            disableMaiorqueAtual()
        })  
    }

</script>
