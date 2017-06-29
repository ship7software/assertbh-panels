<?php
$modulo = 'notificacao';
$title = 'Notificações';
?>

<section class="content-header">
    <h1>
        <?= $title; ?>
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="painel.php?exe=home"><i class="fa fa-dashboard"></i></a><li class="active"><?= $title; ?></li></li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $title; ?></h3>
        </div>
        <div class="box-body">

            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover responsive nowrap" id="<?= $modulo.'table'; ?>">
                    <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Lida</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $read = new Read;
                    $read->ExeRead($modulo, "ORDER BY data DESC, id DESC");
                    if ($read->getResult()):
                        foreach ($read->getResult() as $user):
                            extract($user);
                            ?>
                            <? if($lida == 1) { ?>
                            <tr>
                            <? } ?>
                            <? if($lida == 0) { ?>
                            <tr style="background-color: #a5e2ff !important">
                            <? } ?>
                                <td><?= $tipo ?></td>
                                <td><?= date('d/m/Y', strtotime($data)) ?></td>
                                <? if($lida == 1) { ?>
                                <td>Sim</td>
                                <? } ?>
                                <? if($lida == 0) { ?>
                                <td>Não</td>
                                <? } ?>
                               <td>
                                    <a class="btn btn-xs btn-primary" href="https://boleto-assertbh.mybluemix.net/notificacao/<?= $id; ?>" title="Ver"><i class="glyphicon glyphicon-eye-open" ></i></a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    else:
                        DSErro("Desculpe, ainda não existem ".$title."!", DS_INFOR);
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