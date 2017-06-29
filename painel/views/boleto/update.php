<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$userId = 1;
$modulo = 'boleto';
$title = 'Configuração de Boleto';

if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminBoleto.class.php');
    $cadastra = new AdminBoleto();
    $cadastra->ExeUpdate($userId, $ClienteData);
    DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    $botaoCR = 'Retornar a Lista';
    $botaoClass = 'fa fa-arrow-left';
else:
    $ReadUser = new Read;
    $ReadUser->ExeRead($modulo, "WHERE id = :userid", "userid={$userId}");
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
                    <div class="col-md-3">
                        <label>Taxa do Boleto</label>
                        <input class="form-control"
                               type = "text"
                               name = "taxa"
                               value="<?php if (!empty($ClienteData['taxa'])) echo $ClienteData['taxa']; ?>"
                               title = "Taxa do Boleto"
                               placeholder="Taxa do Boleto" >
                    </div>
                </div>

                <h3>Demonstrativo</h3>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "demonstrativo1"
                               value="<?php if (!empty($ClienteData['demonstrativo1'])) echo $ClienteData['demonstrativo1']; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "demonstrativo2"
                               value="<?php if (!empty($ClienteData['demonstrativo2'])) echo $ClienteData['demonstrativo2']; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "demonstrativo3"
                               value="<?php if (!empty($ClienteData['demonstrativo3'])) echo $ClienteData['demonstrativo3']; ?>">
                    </div>
                </div>
                <h3>Instruções</h3>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "instrucoes1"
                               value="<?php if (!empty($ClienteData['instrucoes1'])) echo $ClienteData['instrucoes1']; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "instrucoes2"
                               value="<?php if (!empty($ClienteData['instrucoes2'])) echo $ClienteData['instrucoes2']; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "instrucoes3"
                               value="<?php if (!empty($ClienteData['instrucoes3'])) echo $ClienteData['instrucoes3']; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <input class="form-control"
                               type = "text"
                               name = "instrucoes4"
                               value="<?php if (!empty($ClienteData['instrucoes4'])) echo $ClienteData['instrucoes4']; ?>">
                    </div>
                </div>


        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Atualizar" class="btn btn-primary" /></span>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->