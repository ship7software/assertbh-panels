<?php
ob_start();
session_start();
require('_app/Config.inc.php');

$login = new Login();
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->CheckLogin()):
    unset($_SESSION['userlogininquilino']);
    header('Location: index.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogininquilino'];
endif;

if ($logoff):
    unset($_SESSION['userlogininquilino']);
    header('Location: index.php?exe=logoff');
endif;
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="HTTPro Solutions">

        <title><?=SITENAME?></title>
        <link href="<?=HOME; ?>/img/favicon.ico" rel="shortcut icon" >

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet" >
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" >
        <link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" >
        <link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" >
        <link href="css/AdminLTE.min.css" rel="stylesheet">
        <link href="css/skins/_all-skins.min.css" rel="stylesheet">
        <link href="css/sweetalert.css" rel="stylesheet" >

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">

        <header class="main-header">
            <a href="painel.php" class="logo">
                <span class="logo-mini"><img src="<?=HOME.'/img/logo.png'?>" style="width: 30px; float: left; margin-left: 10px; margin-top: 20px;"></span>
                <span class="logo-lg"><img src="<?=HOME.'/img/logo.png'?>" style="width: 110px; float: left; margin-left: 30px; margin-top: 10px;">  <?/*=SITENAME*/?></span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php extract($_SESSION['userlogininquilino']); ?>
                                <?= Check::ImageUserAvatarMini('../uploads/inquilinos/avatar.png'); ?>
                                <span class="hidden-xs"><?= "{$nome_inquilino}"; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?= Check::ImageUserAvatar('../uploads/inquilinos/avatar.png'); ?>
                                    <p><small><?= "{$nome_inquilino}"; ?></small></p>
                                    <p><small><?= "{$email}"; ?></small></p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="painel.php?exe=unidades/update&userid=<?=$id?>" class="btn btn-default btn-flat">Perfil</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="painel.php?logoff=true" class="btn btn-default btn-flat">Sair</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <div class="user-panel">
                    <div class="pull-left image">
                        <?= Check::ImageUserAvatar('../uploads/inquilinos/avatar.png'); ?>
                    </div>
                    <div class="pull-left info">
                        <p><?= "{$nome_inquilino}"; ?></p>
                        <a href="painel.php?exe=unidades/update&userid=<?=$id?>"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <ul class="sidebar-menu">
                    <li class="header">Menu Principal</li>
                    <li><a href="painel.php?exe=home"><i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span></a></li>
                    <li><a href="painel.php?exe=unidades/update&userid=<?=$id?>"><i class="fa fa-id-card fa-fw"></i> <span>Cadastro</span></a></li>
                    <li><a href="painel.php?exe=boletos/index&id=<?=$id?>"><i class="fa fa-money fa-fw"></i> <span>Boletos</span></a></li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
    <script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="__jsc/sweetalert.min.js"></script>
        <div class="content-wrapper">
            <div class="row">
                <div class="container-fluid">
                    <?php
                    //QUERY STRING
                    if (!empty($getexe)):
                        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
                    else:
                        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'home.php';
                    endif;

                    if (file_exists($includepatch)):
                        require_once($includepatch);
                    else:
                        echo "<div class=\"content notfound\">";
                        DSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", DS_ERROR);
                        echo "</div>";
                    endif;
                    ?>
                </div>
            </div>
        </div><!-- /#page-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.0
            </div>
            <strong>Copyright &copy; 2014-2016 <a href="http://www.httpro.com.br">HTTPro Solutions</a>.</strong> All rights reserved.
        </footer>
    </div><!-- /#wrapper -->
    </body>


    <script src="assets/plugins/jQueryUI/jquery-ui.min.js"></script>
    <script type="text/javascript" src="__jsc/bootstrap.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <script src="__jsc/raphael-min.js"></script>
    <script src="assets/plugins/morris/morris.min.js"></script>

    <script src="assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/plugins/DataTables/extensions/Responsive/js/responsive.jqueryui.min.js"></script>
    <script src="__jsc/dataTables.responsive.min.js"></script>

    <script type="text/javascript" src="__jsc/datatables-tabelas.js?version=20170629"></script>

    <script type="text/javascript" src="__jsc/fnReloadAjax.js"></script>

    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script src="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <script src="assets/plugins/knob/jquery.knob.js"></script>
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>

    <script src="assets/plugins/datepicker/bootstrap-datepicker.js"></script>

    <script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/fastclick/fastclick.min.js"></script>


    
    <script type="text/javascript" src="__jsc/jquery.mask.min.js"></script>
    <script type="text/javascript" src="__jsc/jquery.maskedinput-1.3.1.min.js"></script>
    <script src="__jsc/validacpfcnpj.js?v=3"></script>

    <script src="__jsc/moment.js"></script>
    <script src="__jsc/app.js"></script>
    <script>
        $.ajax({
            type: 'POST',
            url: 'https://boleto-assertbh.mybluemix.net/atualizarDataVencimento'
        })
    </script>
    <style>
        .sweet-alert {
            overflow-y: scroll !important;
            display: block;
            margin-top: -283px;
            max-height: 90vh !important;
        }
    </style>
    </html>
<?php

ob_end_flush();