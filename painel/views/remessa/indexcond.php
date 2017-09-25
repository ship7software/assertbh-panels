<?php
$idcond = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$nomeCondominio = filter_input(INPUT_GET, 'nomeCondominio');
$modulo = 'remessa';
$title = 'Remessa';

$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

if ($delete):
    require('_app/Models/AdminRemessa.class.php');
    $delUser = new AdminRemessa();
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
            <h3 class="box-title">Lista de <?= $title; ?>s - Condomínio: <?= $nomeCondominio; ?></h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=remessa/index" title="Retornar para Condomínios" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Condomínios</a>
            </div>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Arquivo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $read = new Read;
                    $read->ExeRead($modulo, "WHERE id_condominio = {$idcond} ORDER BY dataGeracao DESC, id DESC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <tr>
                                <td>
                                    <a href="painel.php?exe=remessa/boletos&nomeCondominio=<?= $nomeCondominio; ?>&id=<?= $id; ?>&arquivo=<?= $nomeArquivo ?>&idcond=<?= $idcond ?>">
                                        <?= date('d/m/Y', strtotime($dataGeracao)) ?>
                                    </a>
                                </td>
                                <td>
                                    <a target="_blank" href="http://assertbh-com-br.umbler.net/remessa/<?= $id; ?>">
                                        <?= $nomeArquivo ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-success" href="painel.php?exe=remessa/boletos&nomeCondominio=<?= $nomeCondominio; ?>&id=<?= $id; ?>&arquivo=<?= $nomeArquivo ?>&idcond=<?= $idcond ?>" title="Boletos"><i class="glyphicon glyphicon-usd" ></i> Boletos</a>
                                    <a target="_blank" class="btn btn-xs btn-primary" href="http://assertbh-com-br.umbler.net/remessa/<?= $id; ?>" title="Baixar"><i class="glyphicon glyphicon-download-alt" ></i> Baixar</a>
                                    <a id="delete_btn" class="btn btn-xs btn-danger" data-id="<?= $id; ?>" data-idcondominio="<?= $idcond; ?>" data-tabela="<?= $modulo; ?>" data-pasta="<?= $modulo; ?>" data-nomecond="<?= $nomeCondominio; ?>"  title="Deletar"><i class="glyphicon glyphicon-trash"></i></a>
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
