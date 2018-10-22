<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Parcelas atrasadas');
SystemLayout::setModule('sys_rel_atrasados');

SystemLayout::addNavigate('Parcelas atrasadas');
SystemLayout::addNavigate('Relatório');

SystemLayout::setBack('home.php');
SystemLayout::setSubTitle($row_cliente['nome']);

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<br />
<igframe>
<br />

<?php require 'assets/blocks/body_fecha.php'; ?>