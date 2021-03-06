<?php
// CONFIGURAÇÕES DO SITE ####################

define('THEME', 'assertbh');
define('SITENAME', 'AssertBH');
define('SITEDESC', 'AssertBH');

/*define('HOME', 'http://assertbh.app/acessocondominio');
define('BASE', 'http://assertbh.app');*/

define('BASE', 'https://www.assertbh.com.br');
define('HOME', 'https://www.assertbh.com.br/acessocondominio');

define('INCLUDE_PATH', BASE . DIRECTORY_SEPARATOR .'themes' . DIRECTORY_SEPARATOR . THEME);
define('REQUIRE_PATH', 'themes'. DIRECTORY_SEPARATOR . THEME);

// CONFIGRAÇÕES DO BANCO ####################

define('HOST', 'localhost');
define('USER', 'assertbh_admin');
define('PASS', 'yw+#ei[H(O@s');
define('DBSA', 'assertbh_admin');

/*define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'twincept');
define('DBSA', 'assertbh');*/

// DEFINE SERVIDOR DE E-MAIL ################
define('MAILUSER', 'contato@assertbh.com.br');
define('MAILPASS', '');
define('MAILPORT', '587');
define('MAILHOST', 'www.assertbh.com.br');


// AUTO LOAD DE CLASSES ####################
function __autoload($Class) {

    $cDir = ['Conn', 'Helpers', 'Models',];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php') && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php')):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('DS_ACCEPT', 'alert alert-success');
define('DS_INFOR', 'alert alert-info');
define('DS_ALERT', 'alert alert-warning');
define('DS_ERROR', 'alert alert-danger');

//DSErro :: Exibe erros lançados :: Front

function DSErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? DS_INFOR : ($ErrNo == E_USER_WARNING ? DS_ALERT : ($ErrNo == E_USER_ERROR ? DS_ERROR : $ErrNo)));

    echo "<div class=\"trigger {$CssClass} alert-dismissible\" role=\"alert\">";
    echo "{$ErrMsg}";
    echo "</div>";
    if ($ErrDie):
        die;
    endif;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? DS_INFOR : ($ErrNo == E_USER_WARNING ? DS_ALERT : ($ErrNo == E_USER_ERROR ? DS_ERROR : $ErrNo)));
    echo "<div class=\"trigger {$CssClass} alert-dismissible\" role=\"alert\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Fechar\"><span aria-hidden=\"true\">&times;</span></button>";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "</div>";
    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');