<?php
define('DB_HOST', 'mysql02.lubavitch.org.br');
define('DB_PORT', '3306');
define('DB_USERNAME', 'lubavitch1');
define('DB_PASSWORD', 'inte@r1a1cao');
define('DB_DATABASE', 'lubavitch1');

// Framework
define('SYS_NOME', 'InterAวรO');
define('SYS_DOMINIO', 'interacao.gani.org.br');
define('SYS_HTTP', 'http://'. $_SERVER['SERVER_NAME'] .'/site/');
define('SYS_PATH', '/home/storage/d/cc/bf/lubavitch/public_html/interacao/site/');

define('SYS_FRAMEWORK', SYS_PATH .'app/framework/');
define('SYS_SITE', SYS_HTTP);

// Diversas
define('SYS_SITE_CONTEUDO', SYS_HTTP .'assets/conteudo/');
define('SYS_CONTEUDO', SYS_PATH .'assets/conteudo/');
define('SYS_EDITOR', SYS_SITE .'app/framework/editorhtml/');

session_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html; charset=ISO-8859-1');
?>