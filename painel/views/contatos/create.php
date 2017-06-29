<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminContatos.class.php');
    $cadastra = new AdminContatos();
    $cadastra->ExeCreate($ClienteData);
    $cadastra->geraJSON();

    if ($cadastra->getResult()):
        header("Location: painel.php?exe=contatos/update&create=true&contatoid={$cadastra->getResult()}");
    else:
        DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
endif;
?>

<section class="content-header">
    <h1>
        Contatos
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=contatos/index">Contatos</a></li>
        <li class="active">Cadastro</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de Contatos</h3>
        </div>
        <div class="box-body">
            <form role="form" action = "" method = "post" name = "UserCreateForm">

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Departamento</label>
                        <input class="form-control"
                               type = "text"
                               name = "departamento"
                               value=""
                               title = "Informe o Departamento"
                               required
                               placeholder="Departamento" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Nome de Fornecedor</label>
                        <input class="form-control"
                               type = "text"
                               name = "nomefornecedor"
                               value=""
                               title = "Informe o Nome de Fornecedor"
                               placeholder="Nome de Fornecedor" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Itens de Fornecimento</label>
                        <input class="form-control"
                               type = "text"
                               name = "itensfornecimento"
                               value=""
                               title = "Informe os Itens de Fornecimento"
                               placeholder="Itens de Fornecimento" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Responsável</label>
                        <input class="form-control"
                               type = "text"
                               name = "responsavel"
                               value=""
                               title = "Informe o Responsável"
                               placeholder="Responsável" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>E-mail</label>
                        <input class="form-control"
                               type = "text"
                               name = "email"
                               value=""
                               title = "Informe o E-mail"
                               placeholder="E-mail" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Telefone</label>
                        <input class="form-control"
                               type = "text"
                               name = "telefone"
                               data-mask="(00) 0000-0000" data-mask-selectonfocus="true"
                               value=""
                               title = "Informe o Telefone"
                               placeholder="Telefone" >
                    </div>

                    <div class="col-md-4">
                        <label>Celular</label>
                        <input class="form-control"
                               type = "text"
                               name = "celular"
                               data-mask="(00) 0000-0000" data-mask-selectonfocus="true"
                               value=""
                               title = "Informe o Celular"
                               placeholder="Celular" >
                    </div>
                </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Salvar Contato" class="btn btn-primary" /></span>
                <a href="painel.php?exe=contatos/index" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
