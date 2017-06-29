<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($ClienteData && $ClienteData['SendPostForm']):
    $ClienteData['imagem'] = ( $_FILES['imagem']['tmp_name'] ? $_FILES['imagem'] : null );
    unset($ClienteData['SendPostForm']);


    require('_app/Models/AdminUser.class.php');
    $cadastra = new AdminUser;
    $cadastra->ExeCreate($ClienteData);

    if ($cadastra->getResult()):
        header("Location: painel.php?exe=users/update&create=true&userid={$cadastra->getResult()}");
    else:
        DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
endif;
?>

<section class="content-header">
    <h1>
        Usuários
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=users/index">Usuários</a></li>
        <li class="active">Cadastro</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de Usuários</h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-md-2">
                        <a href="#" class="thumbnail"><img src="<?= HOME ?>/img/nopicture.jpg" /></a>
                    </div>
                    <div class="col-md-3">
                        <label>Selecione Nova Imagem</label>
                        <input class="form-control"
                               type = "file"
                               name = "imagem" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Nome</label>
                        <input class="form-control"
                               type = "text"
                               name = "nome"
                               value="<?php if (!empty($ClienteData['nome'])) echo $ClienteData['nome']; ?>"
                               title = "Informe o Nome do Usuário"
                               required
                               placeholder="Nome do Usuário" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>E-mail</label>
                        <input class="form-control"
                               type = "text"
                               name = "email"
                               value="<?php if (!empty($ClienteData['email'])) echo $ClienteData['email']; ?>"
                               title = "Informe o E-mail do Usuário"
                               required
                               placeholder="E-mail do Usuário" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Senha</label>
                        <input class="form-control"
                               type = "password"
                               name = "senha"
                               value="<?php if (!empty($ClienteData['senha'])) echo $ClienteData['senha']; ?>"
                               title = "Informe a Senha do Usuário [ de 6 a 12 caracteres! ]"
                               pattern = ".{6,12}"
                               required
                               placeholder="Senha do Usuário" >
                    </div>
                </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Salvar Usuário" class="btn btn-primary" /></span>
                <a href="painel.php?exe=users/index" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
