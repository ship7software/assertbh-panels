<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

if ($ClienteData && $ClienteData['SendPostForm']):
    $ClienteData['imagem'] = ( $_FILES['imagem']['tmp_name'] ? $_FILES['imagem'] : 'null' );
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminUser.class.php');
    $cadastra = new AdminUser;
    $cadastra->ExeUpdate($userId, $ClienteData);
    DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-arrow-left';
    $imagem = $cadastra->getImagem($userId);
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead("usuarios", "WHERE id = :userid", "userid={$userId}");
    if ($ReadUser->getResult()):
        $ClienteData = $ReadUser->getResult()[0];
        unset($ClienteData['senha']);
        $imagem = $ClienteData['imagem'];
    endif;
    $botaoCR = 'Cancelar';
    $botaoClass = 'fa fa-ban';
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    DSErro("O usuário foi cadastrado com sucesso no sistema!", DS_ACCEPT);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-ban';
endif;
?>

<section class="content-header">
    <h1>
        Usuários
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=clientes/index">Usuários</a></li>
        <li class="active">Atualização</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Atualização de Usuários</h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-md-2">
                        <a href="#" class="thumbnail" onclick="document.getElementById('upload').click(); return false"><?= Check::Image('../uploads/usuarios/'. $imagem); ?></a>
                    </div>
                    <div class="col-md-3">
                        <label>Selecione Nova Imagem</label>
                        <input class="form-control"
                               id="upload"
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
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar Usuário" class="btn btn-primary" /></span>
                <a href="painel.php?exe=users/index" class="btn btn-danger"><i class="<?=$botaoClass ?>"></i> <?=$botaoCR ?></a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->