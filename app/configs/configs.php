<?php

//Produção
//define('DB_HOST', 'mysql02.lubavitch.org.br');
//
//define('DB_PORT', '3306');
//
//define('DB_USERNAME', 'lubavitch1');
//
//define('DB_PASSWORD', 'inte@r1a1cao');
//
//define('DB_DATABASE', 'lubavitch1');

//Desenvolvimento
define('DB_HOST', 'localhost');

define('DB_PORT', '3306');

define('DB_USERNAME', 'root');

//define('DB_PASSWORD', ''); //XAMPP (PHP 5.6)
define('DB_PASSWORD', 'adm123'); //Bitnami WAMP Stack (PHP 7)

define('DB_DATABASE', 'lubavitch1');



// Pagseguro

define('PAG_USUARIO', 'info@interacao.gani.org.br');

define('PAG_TOKEN_PROD', 'FADF9EAD1AA649109CCE7E9B01E0F687');

define('PAG_TOKEN_SAND', 'D5EAAC83371A432A826DB7CA28348084');

define('PAG_AMBIENTE', 'producao'); //producao ou sandbox



// Framework

define('SYS_NOME', 'InterAÇÃO');

define('SYS_DOMINIO', 'interacao.gani.org.br');

define('SYS_HTTP', 'http://'. $_SERVER['SERVER_NAME'] .'/');

//define('SYS_PATH', '/home/storage/d/cc/bf/lubavitch/public_html/interacao/');
define('SYS_PATH', $_SERVER['DOCUMENT_ROOT'] . '/interacao/');
define('SYS_PATH_LOAD_ROOT', './');

//define('SYS_URLBASE', '/wwwnanny/interacao.gani.org.br/');



define('SYS_FRAMEWORK', SYS_PATH .'app/framework/');

define('SYS_SITE', SYS_HTTP);



// Diversas

// define('SYS_SITE_CONTEUDO', SYS_HTTP .'assets/conteudo/');
define('SYS_SITE_CONTEUDO', SYS_PATH_LOAD_ROOT .'assets/conteudo/');

define('SYS_CONTEUDO', SYS_PATH_LOAD_ROOT .'assets/conteudo/');

define('SYS_EDITOR', SYS_SITE .'app/framework/editorhtml/');



session_start();



header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");

header("Cache-Control: no-store, no-cache, must-revalidate");

header("Cache-Control: post-check=0, pre-check=0", false);

header("Pragma: no-cache");

header('Content-Type: text/html; charset=ISO-8859-1');

?>
