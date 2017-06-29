<?php
$unidadeid = filter_input(INPUT_GET, 'unidadeid', FILTER_VALIDATE_INT);

$unidade = new Read;
$unidade->ExeRead('unidades','WHERE id = :unidade','unidade='.$unidadeid);

$modulo = 'documentos';
$title = 'Documento';

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
            <h3 class="box-title">Lista de <?= $title; ?>s do Condomínio <?=$Condominio->getCondominio($unidade->getResult()[0]['id_condominio'])?> </h3>
            <h4>Unidade: Bloco: <?= $unidade->getResult()[0]['bloco']; ?> / Apto/Sala: <?= $unidade->getResult()[0]['apto_sala']; ?></h4>
            <div class="box-tools pull-right">
                <a href="painel.php?exe=unidades/index&userid=<?= $unidade->getResult()[0]['id_proprietario']; ?>" title="Retornar para Unidades" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> Retornar para Unidades</a>
            </div>
        </div>
        <div class="box-body">

            <div class="row">
                <?php
                if ($unidade->getResult()[0]['docgerais'] == 'Sim'):
                    ?>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>
                                    <?php
                                    $documentos = new Read;
                                    $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "docgerais" AND id_condominio='.$unidade->getResult()[0]['id_condominio']);
                                    echo $documentos->getRowCount();
                                    ?>
                                </h3>
                                <p>Documentos Gerais</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file-text"></i>
                            </div>
                            <a href="painel.php?exe=documentos/documentos&tipo=docgerais&unidadeid=<?= $unidade->getResult()[0]['id']; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <?php
                if ($unidade->getResult()[0]['comuinfo'] == 'Sim'):
                    ?>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua-gradient">
                            <div class="inner">
                                <h3>
                                    <?php
                                    $documentos = new Read;
                                    $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "comuinfo" AND id_condominio='.$unidade->getResult()[0]['id_condominio']);
                                    echo $documentos->getRowCount();
                                    ?>
                                </h3>
                                <p>Comunicados e Informações</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file-text"></i>
                            </div>
                            <a href="painel.php?exe=documentos/documentos&tipo=comuinfo&unidadeid=<?= $unidade->getResult()[0]['id']; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <?php
                if ($unidade->getResult()[0]['gestao'] == 'Sim'):
                    ?>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3>
                                    <?php
                                    $documentos = new Read;
                                    $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "gestao" AND id_condominio='.$unidade->getResult()[0]['id_condominio']);
                                    echo $documentos->getRowCount();
                                    ?>
                                </h3>
                                <p>Gestão</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file-text"></i>
                            </div>
                            <a href="painel.php?exe=documentos/documentos&tipo=gestao&unidadeid=<?= $unidade->getResult()[0]['id']; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <?php
                if ($unidade->getResult()[0]['contabil'] == 'Sim'):
                    ?>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-light-blue-gradient">
                            <div class="inner">
                                <h3>
                                    <?php
                                    $documentos = new Read;
                                    $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "contabil" AND id_condominio='.$unidade->getResult()[0]['id_condominio']);
                                    echo $documentos->getRowCount();
                                    ?>
                                </h3>
                                <p>Contabilidade</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-file-text"></i>
                            </div>
                            <a href="painel.php?exe=documentos/documentos&tipo=contabil&unidadeid=<?= $unidade->getResult()[0]['id']; ?>" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php
                endif;
                ?>

            </div>


        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->
</section><!-- /.content -->
