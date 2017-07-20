<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$title = 'Retorno de Remessa';

require('_app/Models/AdminRemessa.class.php');
if ($ClienteData && $ClienteData['SendPostForm']):
    $ClienteData['arquivo'] = ( $_FILES['arquivo']['tmp_name'] ? $_FILES['arquivo'] : null );
    unset($ClienteData['SendPostForm']);
    if (!empty($_FILES['arquivo']['tmp_name'])):
        $enviaFotos = new AdminRemessa;
        $fileName = 'RETORNO_REMESSA_'.date('YmdHis').'.ret'
        $enviaFotos->ExeEnvia($_FILES['arquivo'], $fileName);
        if ($enviaFotos->getResult()):
            header("Location:https://boleto-assertbh.mybluemix.net/processar/retorno/".$fileName);
        else:
            DSErro($enviaFotos->getError()[0], $enviaFotos->getError()[1]);
        endif;
    endif;
endif;

?>

<section class="content-header">
    <h1>
        <?= $title; ?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Upload de Arquivo de Retorno</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Upload de Arquivo de Retorno</h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Selecione o arquivo</label>
                        <input class="form-control"
                               type = "file"
                               name = "arquivo" />
                    </div>
                </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-send"></span><input type="submit" name="SendPostForm" value="Enviar Arquivo" class="btn btn-primary" /></span>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
