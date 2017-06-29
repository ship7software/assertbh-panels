<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$produtoid = filter_input(INPUT_GET, 'produtoid', FILTER_VALIDATE_INT);
require('_app/Models/AdminFotos.class.php');
if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);
    if (!empty($_FILES['imagens']['tmp_name'])):
        $enviaFotos = new AdminFotos;
        $enviaFotos->gbSend($_FILES['imagens'], $produtoid);
        header("Location: painel.php?exe=fotos/index&produtoid={$produtoid}");
    endif;
endif;
$NomeProduto= new AdminFotos;
?>

<section class="content-header">
    <h1>
        Fotos do Produto <?= $NomeProduto->getNomeProduto($produtoid); ?>
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=fotos/index&produtoid=<?=$produtoid?>">Fotos do Produto</a></li>
        <li class="active">Cadastro</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de Fotos do Produto <?= $NomeProduto->getNomeProduto($produtoid); ?></h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Selecione as fotos</label>
                        <input class="form-control"
                               type = "file" multiple
                               name = "imagens[]" />
                    </div>
                </div>

                <input type = "text" name = "id_produto" value="<?=$produtoid ?>" hidden="hidden" />

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-send"></span><input type="submit" name="SendPostForm" value="Enviar Fotos" class="btn btn-primary" /></span>
                <a href="painel.php?exe=fotos/index&produtoid=<?=$produtoid?>" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
