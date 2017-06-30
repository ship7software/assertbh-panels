<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$id_cond = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$modulo = 'proprietarios';
$title = 'Proprietário';
if ($delete):
    require('_app/Models/AdminProprietario.class.php');
    $delUser = new AdminProprietario();
    $delUser->ExeDelete($delete);
    DSErro($delUser->getError()[0], $delUser->getError()[1]);
endif;

$condominio =  new AdminProprietario();
$condominio->getCondominio($id_cond);
?>

<section class="content-header">
    <h1>
        <?= $title; ?>s do Condomínio <?=$condominio->getCondominio($id_cond);?>
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
                <a href="painel.php?exe=proprietarios/indexcond" title="Retornar para Condominios" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Condominios</a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped responsive table-hover" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Celular</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE LOCATE({$id_cond},condominios) ORDER BY nome ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&id=<?=$id_cond?>" class="thumbnail"><?= Check::Image('../uploads/'.$modulo.'/'.$imagem); ?></a></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&id=<?=$id_cond?>"><?= $nome?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&id=<?=$id_cond?>"><?= $email ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&id=<?=$id_cond?>"><?= $celular ?></td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>&id=<?=$id_cond?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a class="btn btn-xs btn-default" href="https://www.assertbh.com.br/report/reports/proprietarios.php?userid=<?= $id; ?>" title="Imprimir" target="_blank"><i class="glyphicon glyphicon-print" ></i></a>
                                    <a id="delete_prop" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-idcond="<?= $id_cond; ?>" data-tabela="<?= $modulo; ?>" data-pasta="<?= $modulo; ?>"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
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
