<?php
$ClienteData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$modulo = 'contas';
$title = 'Conta';
if ($ClienteData && $ClienteData['SendPostForm']):
    unset($ClienteData['SendPostForm']);

    require('_app/Models/AdminContas.class.php');
    $cadastra = new AdminContas();
    $cadastra->ExeCreate($ClienteData);

    if ($cadastra->getResult()):
        header("Location: painel.php?exe={$modulo}/update&create=true&userid={$cadastra->getResult()}");
    else:
        DSErro($cadastra->getError()[0], $cadastra->getError()[1]);
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
        <li><a href="painel.php?exe=<?= $modulo; ?>/index"><?= $title; ?></a></li>
        <li class="active">Cadastro</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastro de <?= $title; ?></h3>
        </div>
        <div class="box-body">
            <form action = "" method = "post" name = "UserCreateForm" enctype="multipart/form-data">

                <div class="row form-group">
                    <div class="col-md-8">
                        <label>Condomínio</label>
                        <select class="form-control" name="condominio_id">
                            <option disabled="disabled" selected="selected"> Selecione o Condomínio</option>
                            <?php
                            $condominios = new Read;
                            $condominios->ExeRead('condominios', 'ORDER BY nome');
                            if ($condominios->getResult()):
                                foreach ($condominios->getResult() as $dados):
                                    extract($dados);
                                    ?>
                                    <option value="<?=$id ?>" <?=($ClienteData['condominio_id'] == $id ? 'selected="selected"' : '')?>><?= $nome; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4">
                        <label>Banco</label>
                        <input class="form-control"
                               type = "text"
                               name = "banco"
                               value="<?php if (!empty($ClienteData['banco'])) echo $ClienteData['banco']; ?>"
                               title = "Informe o Banco da <?= $title; ?>"
                               required
                               placeholder="Banco da <?= $title; ?>" >
                    </div>
                    <div class="col-md-4">
                        <label>Código do Banco</label>
                        <input class="form-control"
                               type = "text"
                               name = "codbanco"
                               value="<?php if (!empty($ClienteData['codbanco'])) echo $ClienteData['codbanco']; ?>"
                               title = "Informe o Código do Banco da <?= $title; ?>"
                               placeholder="Código do Banco da <?= $title; ?>" >
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3">
                        <label>Agência</label>
                        <input class="form-control"
                               type = "text"
                               name = "agencia"
                               value="<?php if (!empty($ClienteData['agencia'])) echo $ClienteData['agencia']; ?>"
                               title = "Informe a Agência da <?= $title; ?>"
                               required
                               placeholder="Agência da <?= $title; ?>" >
                    </div>
                    <div class="col-md-3">
                        <label>Conta</label>
                        <input class="form-control"
                               type = "text"
                               name = "conta"
                               value="<?php if (!empty($ClienteData['conta'])) echo $ClienteData['conta']; ?>"
                               title = "Informe o Numero da <?= $title; ?>"
                               required
                               placeholder="Numero da <?= $title; ?>" >
                    </div>
                    <div class="col-md-2">
                        <label>Carteira</label>
                        <input class="form-control"
                               type = "text"
                               name = "carteira"
                               value="<?php if (!empty($ClienteData['carteira'])) echo $ClienteData['carteira']; ?>"
                               title = "Informe a Carteira da <?= $title; ?>"
                               placeholder="Carteira da <?= $title; ?>" >
                    </div>
                </div>


        </div><!-- /.box-body -->
        <div class="box-footer">
            <div class="row form-group col-lg-12">
                <span class="icon-input-btn"><span class="fa fa-hdd-o"></span><input type="submit" name="SendPostForm" value="Salvar" class="btn btn-primary" /></span>
                <a href="painel.php?exe=<?= $modulo; ?>/index" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
            </form>
        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
