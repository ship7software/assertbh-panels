<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'assertbh_site');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'assertbh_site');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '-P-QX2*GkNX?');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'gS];I!o1y&uu|KK+ioKv7ol;Ia1~@Id,|>,,s`{F8;BP%qn~_n.d{S7c*f6t(Oo!');
define('SECURE_AUTH_KEY',  'BhpErd=6}S~+>%2#wSf]fP& pY>;sEo#N,_tYa8m72Tc&+d!jp;OqhCFL|g2)Vr-');
define('LOGGED_IN_KEY',    '8$u@4r$hr|~l+NPaF`t8vF+4pH$q=1c!$T6-1l e8U/lko&D;%<?7dOXPH8KwoAp');
define('NONCE_KEY',        'QnH$2O%Yq-QAqphN`3,ct5=%K2JpKQSyUn7K10kr3P+&Fd&f2brc Uqx4d7JK;=x');
define('AUTH_SALT',        'dL3Lr]F_ac7g:XC/a07-qJY-$i(uMe/K~K4`9PQZ.%Q?`K lBF)KNa #P{5 a[yw');
define('SECURE_AUTH_SALT', 'UT]JMcS7%Yf?OfYQ+x]gd2,bBIp]{R2:3jjmA E<$J-0^+3N[~r9hUB^giH[jz6]');
define('LOGGED_IN_SALT',   '0nM:={RA%h[m|#YWZ4A)PN`^(kBs@Q<zh|b::4*G)F1b7RYFJ].<o0imynB(- Rb');
define('NONCE_SALT',       'oa]yyJ];M:~V,TVk|^H^5!EW2k!^~c$j+Uj)H+Bs*;@Dp[s, Ez^[_BW:2|<ZJN5');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
