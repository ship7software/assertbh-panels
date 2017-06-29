<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$produtoid = filter_input(INPUT_GET, 'produtoid', FILTER_VALIDATE_INT);
if ($delete):
    require('_app/Models/AdminFotos.class.php');
    $delDados = new AdminFotos();
    $delDados->ExeDelete($delete);
    DSErro($delDados->getError()[0], $delDados->getError()[1]);
endif;

$NomeProduto = new AdminFotos;
?>

<section class="content-header">
    <h1>
        Fotos do Produto <?= $NomeProduto->getNomeProduto($produtoid); ?>
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a><li class="active">Fotos do Produto</li></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de Fotos</h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=fotos/create&produtoid=<?=$produtoid?>" title="Cadastrar Novas Fotos" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar Fotos</a>
                <a href="painel.php?exe=produtos/index" title="Retornar para Produtos" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Produtos</a>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="fotostable">
                    <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome do Arquivo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $ReadDados = new Read;
                    $ReadDados->ExeRead("fotos", "WHERE id_produto = :prop ORDER BY id", "prop={$produtoid}");
                    if ($ReadDados->getResult()):
                        foreach ($ReadDados->getResult() as $dados):
                            extract($dados);
                            ?>

                            <tr>
                                <td>
                                    <a class="thumbnail" href="#" data-image-id="<?= $id; ?>" data-toggle="modal" data-title="<?= $imagem; ?>" data-image="<?= '../uploads/produtos/'. $imagem; ?>" data-target="#image-gallery" data-caption="">
                                        <?= Check::Image('../uploads/produtos/'. $imagem); ?>
                                    </a>
                                </td>
                                <td><?= $imagem ?></td>

                                <td>
                                    <a id="delete_fotos_btn" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-idproduto="<?= $produtoid; ?>" data-tabela="fotos" data-pasta="fotos"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else:
                        DSErro("Desculpe, ainda não existem Fotos cadastradas!", DS_INFOR);
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->


<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="image-gallery-title"></h4>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive" src="">
            </div>
            <div class="modal-footer">
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="show-previous-image">Anterior</button>
                </div>

                <div class="col-md-8 text-justify" id="image-gallery-caption">
                    This text will be overwritten by jQuery
                </div>

                <div class="col-md-2">
                    <button type="button" id="show-next-image" class="btn btn-default">Próxima</button>
                </div>
            </div>
        </div>
    </div>
</div>