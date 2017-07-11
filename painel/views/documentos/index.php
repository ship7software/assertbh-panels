<?php
$idcondominio = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$modulo = 'documentos';
$title = 'Documento';
$delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

if ($delete):
    require('_app/Models/AdminDocumento.class.php');
    $delUser = new AdminDocumento();
    $delUser->ExeDelete($delete, $idcond);
    DSErro($delUser->getError()[0], $delUser->getError()[1]);
endif;

$Condominio = new AdminDocumento();
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
            <h3 class="box-title">Lista de <?= $title; ?>s do Condomínio <?=$Condominio->getCondominio($idcondominio)?> </h3>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=<?= $modulo; ?>/create&id=<?= $idcondominio; ?>" title="Cadastrar Novo <?= $title; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Cadastrar <?= $title; ?></a>
               <a href="painel.php?exe=condominios/index" title="Retornar para Condominios" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Condominios</a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <?php
                                $documentos = new Read;
                                $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "docgerais" AND id_condominio='.$idcondominio);
                                echo $documentos->getRowCount();
                                ?>
                            </h3>
                            <p>Documentos Gerais</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <a href="painel.php?exe=documentos/documentos&tipo=docgerais&id=<?= $idcondominio; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua-gradient">
                        <div class="inner">
                            <h3>
                                <?php
                                $documentos = new Read;
                                $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "comuinfo" AND id_condominio='.$idcondominio);
                                echo $documentos->getRowCount();
                                ?>
                            </h3>
                            <p>Comunicados e Informações</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <a href="painel.php?exe=documentos/documentos&tipo=comuinfo&id=<?= $idcondominio; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                <?php
                                $documentos = new Read;
                                $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "gestao" AND id_condominio='.$idcondominio);
                                echo $documentos->getRowCount();
                                ?>
                            </h3>
                            <p>Gestão</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <a href="painel.php?exe=documentos/documentos&tipo=gestao&id=<?= $idcondominio; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-light-blue-gradient">
                        <div class="inner">
                            <h3>
                                <?php
                                $documentos = new Read;
                                $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "contabil" AND id_condominio='.$idcondominio);
                                echo $documentos->getRowCount();
                                ?>
                            </h3>
                            <p>Contabilidade</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <a href="painel.php?exe=documentos/documentos&tipo=contabil&id=<?= $idcondominio; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
