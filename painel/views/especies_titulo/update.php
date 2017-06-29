<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'especies_titulo';
$title = 'Espécies de Título';

if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminEspecies.class.php');
    $cadastra = new AdminEspecies();
    $cadastra->ExeUpdate($id, $ClienteData);
    DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-arrow-left';
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead($modulo, "WHERE id = :userid", "userid={$id}");
    if ($ReadUser->getResult()):
        $ClienteData = $ReadUser->getResult()[0];
    endif;
    $botaoCR = 'Cancelar';
    $botaoClass = 'fa fa-ban';
endif;

$checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
if ($checkCreate && empty($cadastra)):
    DSErro("A ".$title." foi cadastrado com sucesso no sistema!", DS_ACCEPT);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-ban';
endif;

?>

<section class="content-header">
    <h1>
        <?=$title?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=<?=$modulo?>/index"><?=$title?></a></li>
        <li class="active">Atualização</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Atualização de <?=$title?></h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Nome do Banco</label>
                        <input class="form-control valor"
                               type = "text"
                               name = "banco"
                               value="<?php if (!empty($ClienteData['banco'])) echo $ClienteData['banco']; ?>"
                               title = "Informe o Nome do Banco do <?= $title; ?>"
                               required
                               placeholder="Nome do Banco do <?= $title; ?>" >

                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Código do Banco</label>
                        <input class="form-control valor"
                               type = "text"
                               name = "codigo_banco"
                               value="<?php if (!empty($ClienteData['codigo_banco'])) echo $ClienteData['codigo_banco']; ?>"
                               title = "Informe o Código do Banco do <?= $title; ?>"
                               required
                               placeholder="Código do Banco do <?= $title; ?>" >
                    </div>
                    <div class="col-md-3">
                        <label>Código da Espécie</label>
                        <input class="form-control valor"
                               type = "text"
                               name = "codigo_especie"
                               value="<?php if (!empty($ClienteData['codigo_especie'])) echo $ClienteData['codigo_especie']; ?>"
                               title = "Informe o Código da Espécie do <?= $title; ?>"
                               required
                               placeholder="Código da Espécie do <?= $title; ?>" >
                    </div>
                    <div class="col-md-2">
                        <label>Sigla Boleto</label>
                        <input class="form-control valor"
                               type = "text"
                               name = "sigla_boleto"
                               value="<?php if (!empty($ClienteData['sigla_boleto'])) echo $ClienteData['sigla_boleto']; ?>"
                               title = "Informe a Sigla Boleto do <?= $title; ?>"
                               required
                               placeholder="Sigla Boleto do <?= $title; ?>" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Descrição</label>
                        <input class="form-control valor"
                               type = "text"
                               name = "descricao"
                               value="<?php if (!empty($ClienteData['descricao'])) echo $ClienteData['descricao']; ?>"
                               title = "Informe a Descrição do <?= $title; ?>"
                               required
                               placeholder="Descrição do <?= $title; ?>" >

                    </div>
                </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?=$modulo?>/index" class="btn btn-danger"><i class="<?=$botaoClass ?>"></i> <?=$botaoCR ?></a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->