<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
$idcond = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'unidades';
$title = 'Unidade';
if ($delete):
    require('_app/Models/AdminUnidade.class.php');
    $delUser = new AdminUnidade();
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
                <a href="painel.php?exe=<?= $modulo; ?>/create&id=<?= $idcond; ?>" title="Cadastrar Novo <?= $title; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?= $title; ?></a>
                <a href="painel.php?exe=unidades/index" title="Retornar para Unidades" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Unidades</a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Proprietário</th>
                        <th>Condomínio</th>
                        <th>Unidade</th>
                        <th>Emergencia</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $Proprietario = new AdminUnidade();
                    $Condominio = new AdminUnidade();
                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_condominio = {$idcond} ORDER BY id_proprietario ASC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $Proprietario->getProprietario($id_proprietario)?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $Condominio->getCondominio($id_condominio)?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>">Bloco:<?=$bloco?> - Unidade:<?=$apto_sala?></td>
                                <td><a href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>"><?= $telefone_emergencia ?></td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="painel.php?exe=cobranca/index&id=<?= $id; ?>" title="Boletos"><i class="glyphicon glyphicon-usd" ></i> Boletos</a>
                                    <a class="btn btn-xs btn-primary" href="painel.php?exe=<?= $modulo; ?>/update&id1=<?= $id; ?>&id2=<?= $idcond; ?>" title="Editar"><i class="glyphicon glyphicon-edit" ></i></a>
                                    <a class="btn btn-xs btn-default" href="https://www.assertbh.com.br/report/reports/unidades.php?userid=<?= $id; ?>" target="_blanks" title="Imprimir"><i class="glyphicon glyphicon-print" ></i></a>
                                    <a id="delete_btn" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-tabela="<?= $modulo; ?>" data-pasta="<?= $modulo; ?>"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>

                            <?php
                        endforeach;

                    else:
                        DSErro("Desculpe, ainda não existem ".$title."s cadastradas!", DS_INFOR);
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
