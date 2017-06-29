<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$modulo = 'condominios';
$title = 'Condomínio';
if ($delete):
    require('_app/Models/AdminCondominio.class.php');
    $delUser = new AdminCondominio();
    $delUser->ExeDelete($delete);
    DSErro($delUser->getError()[0], $delUser->getError()[1]);
endif;
?>

<section class="content-header">
    <h1>
        <?= $title; ?>s
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a><li class="active"><?= $title; ?></li></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Lista de <?= $title; ?>s</h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=<?= $modulo; ?>/create" title="Cadastrar Novo <?= $title; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?= $title; ?></a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="display table table-striped table-hover responsive nowrap" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Síndico</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $read = new Read;
                    $read->ExeRead($modulo, "ORDER BY nome ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>" class="thumbnail"><?= Check::Image('../uploads/'.$modulo.'/'.$imagem); ?></a></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $nome?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $nome_sindico ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $telefone_sindico ?></td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="painel.php?exe=documentos/index&id=<?= $id; ?>" title="Documentos"><i class="glyphicon glyphicon-file" ></i> Documentos</a>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a class="btn btn-xs btn-default" href="https://www.assertbh.com.br/report/reports/condominios.php?userid=<?= $id; ?>" target="_blanks" title="Imprimir"><i class="glyphicon glyphicon-print" ></i></a>
                                    <a id="delete_btn" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-tabela="<?= $modulo; ?>" data-pasta="<?= $modulo; ?>"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>

                            <?php
                        endforeach;

                    else:
                        DSErro("Desculpe, ainda não existem ".$title."s cadastrados!", DS_INFOR);
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
