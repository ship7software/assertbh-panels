<?php
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
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
                <!--                <a href="painel.php?exe=<?/*= $modulo; */?>/create" title="Cadastrar Novo <?/*= $title; */?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?/*= $title; */?></a>
-->            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <?php

                $colors = array('lightBlue', 'red', 'green', 'aqua', 'yellow', 'blue', 'navy', 'teal', 'olive', 'lime', 'orange', 'fuchsia', 'purple', 'maroon', 'gray');

                $read = new Read;
                $read->ExeRead('condominios');
                if ($read->getResult()):
                    foreach ($read->getResult() as $user):
                        extract($user);
                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-<?=$colors[array_rand($colors)]?>">
                                <div class="inner">
                                    <h3>
                                        <?php
                                        $unidades = new Read;
                                        $unidades->ExeRead('unidades','WHERE id_condominio = '.$id);
                                        echo $unidades->getRowCount() . ' Unidades' ;
                                        ?>
                                    </h3>
                                    <p><?=$nome?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <a href="painel.php?exe=unidades/indexcond&id=<?=$id?>" class="small-box-footer">Acesso Unidades <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <?php
                    endforeach;
                else:
                    DSErro("Desculpe, ainda não existem ".$title."s cadastradas!", DS_INFOR);
                endif;
                ?>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
