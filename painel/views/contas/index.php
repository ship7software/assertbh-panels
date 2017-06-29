<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$modulo = 'contas';
$title = 'Conta';
if ($delete):
    require('_app/Models/AdminContas.class.php');
    $delUser = new AdminContas();
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
                <a href="painel.php?exe=<?= $modulo; ?>/create" title="Cadastrar Nova <?= $title; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?= $title; ?></a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Condomínio</th>
                        <th>Banco</th>
                        <th>Agência</th>
                        <th>Conta</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $Condominio = new AdminContas();
                    $read = new Read;
                    $read->ExeRead($modulo, "ORDER BY condominio_id ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $Condominio->getCondominio($condominio_id) ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $banco?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $agencia ?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>"><?= $conta ?></td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=<?= $modulo; ?>/update&userid=<?= $id; ?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
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
