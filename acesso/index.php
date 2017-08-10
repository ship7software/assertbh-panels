<?php
ob_start();
/*session_save_path("/tmp");*/
session_start();
require('_app/Config.inc.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= SITENAME; ?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="shortcut icon" href="img/favicon.ico">
    <link href='//fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
</head>
<body>

<div class="main">
    <div class="login">
        <div class="login-top">
            <img src="img/p.png">
        </div>
        <h1>Acesso do Proprietário</h1>

        <?php
        $login = new Login();

        if ($login->CheckLogin()):
            header('Location: painel.php');
        endif;

        $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dataLogin['AdminLogin'])):

            $login->ExeLogin($dataLogin);
            if (!$login->getResult()):
                DSErro($login->getError()[0], $login->getError()[1]);
            else:
                header('Location: painel.php');
            endif;

        endif;

        $get = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);
        if (!empty($get)):
            if ($get == 'restrito'):
                DSErro('<b>Oppsss:</b> Acesso negado. Favor efetue login para acessar o painel!', DS_ALERT);
            elseif ($get == 'logoff'):
                DSErro('<b>Sucesso ao deslogar:</b> Sua sessão foi finalizada. Volte sempre!', DS_ACCEPT);
            endif;
        endif;
        ?>

        <div class="login-bottom">
            <form role="form" name="AdminLoginForm" action="" method="post">
                <input type="text" placeholder="E-mail" required=" " name="user" autofocus>
                <input type="password" class="password" placeholder="Password" required=" " name="pass">
                <input type="submit" name="AdminLogin" value="Entrar">
            </form>
            <!--<a href="#"><p>Forgot your password? Click Here</p></a>-->
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy 2015 Assertbh . All rights reserved</p>
</div>

</body>
</html>
<?php
ob_end_flush();
