<?php
ob_start();
session_start();
require('_app/Config.inc.php');

$login = new Login();
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogin'];
endif;

if ($logoff):
    unset($_SESSION['userlogin']);
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
        <link href="assets/plugins/datepicker/datepicker3.css" rel="stylesheet" >
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
                        <!-- Notifications: style can be found in dropdown.less -->
<!--                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">1</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Você tem 1 notificação</li>
                                <li>
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 1 Novo Assinante hoje
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">Veja Todas</a></li>
                            </ul>
                        </li>-->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php extract($_SESSION['userlogin']); ?>
                                <?= Check::ImageUserAvatarMini('../uploads/proprietarios/'.$imagem); ?>
                                <span class="hidden-xs"><?= "{$nome}"; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?= Check::ImageUserAvatar('../uploads/proprietarios/'.$_SESSION['userlogin']['imagem']); ?>
                                    <p><small><?= "{$nome}"; ?></small></p>
                                    <p><small><?= "{$email}"; ?></small></p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="painel.php?exe=proprietarios/update&userid=<?=$id?>" class="btn btn-default btn-flat">Perfil</a>
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
                        <?= Check::ImageUserAvatar('../uploads/proprietarios/'.$_SESSION['userlogin']['imagem']); ?>
                    </div>
                    <div class="pull-left info">
                        <p><?= "{$nome}"; ?></p>
                        <a href="painel.php?exe=condominios/update&userid=<?=$id?>"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <ul class="sidebar-menu">
                    <li class="header">Menu Principal</li>
                    <li><a href="painel.php?exe=home"><i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span></a></li>
                    <li><a href="painel.php?exe=proprietarios/update&userid=<?=$id?>"><i class="fa fa-id-card fa-fw"></i> <span>Cadastro</span></a></li>
                    <li><a href="painel.php?exe=unidades/index&userid=<?=$id?>"><i class="fa fa-building-o fa-fw"></i> <span>Propriedades</span></a></li>
                    <!--<li><a href="#"><i class="fa fa-money fa-fw"></i> <span>Boletos</span></a></li>--><!--<li><a href="#"><i class="fa fa-money fa-fw"></i> <span>Boletos</span></a></li>-->
                    <!--<li><a href="painel.php?exe=documentos/index"><i class="fa fa-address-book fa-fw"></i> <span>Documentos</span></a></li>-->
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
<script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="assets/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js"></script>
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
?>
    <script>
        $(document).ready(function(){
            $('.mask-date').mask('00/00/0000', {selectOnFocus: true});
            $('.mask-time').mask('00:00:00', {selectOnFocus: true});
            $('.mask-date_time').mask('00/00/0000 00:00:00', {selectOnFocus: true});
            $('.mask-cep').mask('00.000-000', {selectOnFocus: true});
            $('.mask-phone').mask('(00) 0000-0000', {selectOnFocus: true});
            $('.mask-cpf').mask('000.000.000-00', {reverse: true,selectOnFocus: true});
            $('.mask-cnpj').mask('00.000.000/0000-00', {reverse: true,selectOnFocus: true});
            //$('.mask-money').mask('000.000.000.000.000,00', {reverse: true,selectOnFocus: true});
            //$('.mask-money2').mask("#.##0,00", {reverse: true,selectOnFocus: true});
            $('.mask-ip_address').mask('099.099.099.099');
            $('.mask-percent').mask('##0,00%', {reverse: true,selectOnFocus: true});
            var phone9Behavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            };

            $(".mask-money").maskMoney({
                decimal: ",",
                thousands: '',
                allowNegative: true,
                affixesStay: false,
                formatOnBlur: false,
                allowEmpty: true,
                allowZero: true
            });

            $(".mask-money2").maskMoney({
                decimal: ",",
                thousands: '',
                allowNegative: true,
                affixesStay: false,
                formatOnBlur: false,
                allowEmpty: true,
                allowZero: true
            });

            $(".mask-money").on('blur', function(evt){
                if(evt.target.value == '') {
                    $(evt.target).val("0,00");
                }
            });

            $(".mask-money2").on('blur', function(evt){
                if(evt.target.value == '') {
                    $(evt.target).val("0,00");
                }
            });

            var phone9options = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(phone9Behavior.apply({}, arguments), options);
                }
            };

            $('.mask-phone9').mask(phone9Behavior, phone9options);

            var cpfCnpjBehavior = function (val) {
                return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-00';
            };

            var cpfCnpjOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(cpfCnpjBehavior.apply({}, arguments), options);
                }
            };
            $('.mask-cpfCnpj').on('keypress', function(evt) {
                setTimeout(function() {
                    $(evt.target).val(cpfCnpj($(evt.target).val()));
                }, 1);
            });
            $('.mask-date').datepicker({
                format: "dd/mm/yyyy",
                language: "pt-BR",
                autoclose: true
            });

            function cpfCnpj(v){

                //Remove tudo o que não é dígito
                v=v.replace(/\D/g,"")

                if (v.length <= 14) { //CPF

                    //Coloca um ponto entre o terceiro e o quarto dígitos
                    v=v.replace(/(\d{3})(\d)/,"$1.$2")

                    //Coloca um ponto entre o terceiro e o quarto dígitos
                    //de novo (para o segundo bloco de números)
                    v=v.replace(/(\d{3})(\d)/,"$1.$2")

                    //Coloca um hífen entre o terceiro e o quarto dígitos
                    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")

                } else { //CNPJ

                    //Coloca ponto entre o segundo e o terceiro dígitos
                    v=v.replace(/^(\d{2})(\d)/,"$1.$2")

                    //Coloca ponto entre o quinto e o sexto dígitos
                    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")

                    //Coloca uma barra entre o oitavo e o nono dígitos
                    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")

                    //Coloca um hífen depois do bloco de quatro dígitos
                    v=v.replace(/(\d{4})(\d)/,"$1-$2")

                }

                return v.substring(0, 18);
            }
        });
    </script>
                    <?php
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

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

    <script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="__jsc/jquery.maskMoney.min.js"></script>
    <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/fastclick/fastclick.min.js"></script>

    <script src="__jsc/validacpfcnpj.js?v=3"></script>

    <script src="__jsc/moment.js"></script>
    <script src="__jsc/app.js"></script>
    <script>
        $.ajax({
            type: 'POST',
            url: 'https://boleto-assertbh.mybluemix.net/atualizarDataVencimento'
        });
    </script>
    <style>
        .sweet-alert {
            margin-top: -263px !important;
            max-height: 90vh !important;
        }
    </style>
    </html>
<?php

ob_end_flush();