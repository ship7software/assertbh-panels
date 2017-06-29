<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a><li class="active">Dashboard</li></li>

    </ol>
</section>
<?php extract($_SESSION['userlogininquilino']);
?>
<section class="content">
    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        Cadastro
                        <?php
                        /*$condominios = new Read;
                        $condominios->ExeRead('condominios');
                        echo $condominios->getRowCount();*/
                        ?>
                    </h3>
                    <p>Dados Cadastrais</p>
                </div>
                <div class="icon">
                    <i class="fa fa-address-card-o"></i>
                </div>
                <a href="painel.php?exe=unidades/update&userid=<?=$id?>" class="small-box-footer">Dados Cadastrais <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
    <hr>
    <h3>Pastas de Documentos</h3>
    <div class="row">
        <?php
        if ($docgeraisinc == 'Sim'):
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php
                            $documentos = new Read;
                            $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "docgerais" AND id_condominio = '.$id_condominio);
                            echo $documentos->getRowCount();
                            ?>
                        </h3>
                        <p>Documentos Gerais</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-folder-open-o"></i>
                    </div>
                    <a href="painel.php?exe=documentos/index&tipo=docgerais" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <?php
        endif;
        ?>
        <?php
        if ($comuinfoinc == 'Sim'):
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua-gradient">
                    <div class="inner">
                        <h3>
                            <?php
                            $documentos = new Read;
                            $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "comuinfo" AND id_condominio = '.$id_condominio);
                            echo $documentos->getRowCount();
                            ?>
                        </h3>
                        <p>Comunicados e Informações</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-comments-o"></i>
                    </div>
                    <a href="painel.php?exe=documentos/index&tipo=comuinfo" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <?php
        endif;
        ?>
        <?php
        if ($gestaoinc == 'Sim'):
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            <?php
                            $documentos = new Read;
                            $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "gestao" AND id_condominio = '.$id_condominio);
                            echo $documentos->getRowCount();
                            ?>
                        </h3>
                        <p>Gestão</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clipboard"></i>
                    </div>
                    <a href="painel.php?exe=documentos/index&tipo=gestao" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <?php
        endif;
        ?>
        <?php
        if ($contabilinc == 'Sim'):
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-light-blue-gradient">
                    <div class="inner">
                        <h3>
                            <?php
                            $documentos = new Read;
                            $documentos->FullRead('SELECT * FROM documentos WHERE tipo_doc = "contabil" AND id_condominio = '.$id_condominio);
                            echo $documentos->getRowCount();
                            ?>
                        </h3>
                        <p>Contabilidade</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-usd"></i>
                    </div>
                    <a href="painel.php?exe=documentos/index&tipo=contabil" class="small-box-footer">Acesso Documentos <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <?php
        endif;
        ?>

    </div>

</section>
