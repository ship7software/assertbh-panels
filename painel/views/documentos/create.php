<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$idcondominio = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$tipodoc = filter_input(INPUT_GET, 'tipo');
$modulo = 'documentos';
$title = 'Documento';
if ($ClienteData && $ClienteData['SendPostForm']):
    echo $_FILES;
    $ClienteData['arquivo'] = ( $_FILES['arquivo']['tmp_name'] ? $_FILES['arquivo'] : null );
    unset($ClienteData['SendPostForm']);
    $ClienteData['data'] = date('Y-m-d', strtotime(str_replace('/', '-', $ClienteData['data'])));

    require('_app/Models/AdminDocumento.class.php');
    $cadastra = new AdminDocumento();
    $cadastra->ExeCreate($ClienteData);

    if ($cadastra->getResult()):
        header("Location: painel.php?exe={$modulo}/index&id={$idcondominio}");
    else:
        DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
    endif;
endif;
$Condominio = new AdminDocumento();
?>

<section class="content-header">
    <h1>
        <?= $title; ?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="painel.php?exe=<?= $modulo; ?>/index"><?= $title; ?></a></li>
        <li class="active">Cadastro</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de <?= $title; ?> do Condomínio <?=$Condominio->getCondominio($idcondominio)?></h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Selecione um Arquivo</label>
                        <input class="form-control"
                               type = "file"
                               name = "arquivo" required />
                    </div>
                </div>

                <input type = "text" hidden
                       name = "id_condominio"
                       value="<?=$idcondominio?>"
                       required>


                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Data</label>
                        <input class="form-control mask-date"
                               type = "text"
                               name = "data"
                               value="<?php if (!empty($ClienteData['data'])) echo $ClienteData['data']; ?>"
                               title = "Informe a Data do <?= $title; ?>"
                               required
                               placeholder="Data do <?= $title; ?>" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Descrição</label>
                        <input class="form-control"
                               type = "text"
                               name = "descricao"
                               value="<?php if (!empty($ClienteData['descricao'])) echo $ClienteData['descricao']; ?>"
                               title = "Informe a Descrição do <?= $title; ?>"
                               required
                               placeholder="Descrição do <?= $title; ?>" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Pasta do Documento</label>
                        <select class="form-control" name="tipo_doc">
                            <option disabled="disabled" <?php if (empty($ClienteData['tipo_doc'])) echo 'selected="selected"';?>>Selecione a Pasta</option>
                            <option value="docgerais" <?php if ($tipodoc == 'docgerais') echo 'selected="selected"';?>>Documentos Gerais</option>
                            <option value="comuinfo" <?php if ($tipodoc == 'comuinfo') echo 'selected="selected"';?>>Comunicados e Informações</option>
                            <option value="gestao" <?php if ($tipodoc == 'gestao') echo 'selected="selected"';?>>Gestão</option>
                            <option value="contabil" <?php if ($tipodoc == 'contabil') echo 'selected="selected"';?>>Contabilidade</option>
                        </select>
                    </div>
                </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Salvar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?= $modulo; ?>/index&id=<?= $idcondominio; ?>" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
