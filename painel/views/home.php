<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle - <?=SITENAME?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a><li class="active">Dashboard</li></li>

    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php
                        $condominios = new Read;
                        $condominios->ExeRead('condominios');
                        echo $condominios->getRowCount();
                        ?>
                    </h3>
                    <p>Condomínios</p>
                </div>
                <div class="icon">
                    <i class="fa fa-building-o"></i>
                </div>
                <a href="painel.php?exe=condominios/index" class="small-box-footer">Acesso Condomínios <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-gray">
                <div class="inner">
                    <h3>
                        <?php
                        $proprietarios = new Read;
                        $proprietarios->ExeRead('proprietarios');
                        echo $proprietarios->getRowCount();
                        ?>
                    </h3>
                    <p>Proprietários</p>
                </div>
                <div class="icon">
                    <i class="fa fa-address-book"></i>
                </div>
                <a href="painel.php?exe=proprietarios/indexcond" class="small-box-footer">Acesso Proprietários <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-gray">
                <div class="inner">
                    <h3>
                        <?php
                        $unidades = new Read;
                        $unidades->ExeRead('unidades');
                        echo $unidades->getRowCount();
                        ?>
                    </h3>
                    <p>Unidades</p>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <a href="painel.php?exe=unidades/index" class="small-box-footer">Acesso Unidades <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-blue-gradient">
                <div class="inner">
                    <h3>
                        <?php
                        $contatos = new Read;
                        $contatos->ExeRead('contatos');
                        echo $contatos->getRowCount();
                        ?>
                    </h3>
                    <p>Contatos</p>
                </div>
                <div class="icon">
                    <i class="fa fa-phone-square"></i>
                </div>
                <a href="painel.php?exe=contatos/index" class="small-box-footer">Acesso Contatos <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div>

</section>
