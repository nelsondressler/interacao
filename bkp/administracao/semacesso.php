<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Sem acesso!');
SystemLayout::addNavigate('Sem acesso!');
SystemLayout::setBack('home.php');

?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="200" align="center" class="input_title">
      <p class="sub_titulo">Area restrita.</p>
      <p>Você não tem acesso a esta parte do sistema. </p>
    </td>
  </tr>
</table>

<?php require 'assets/blocks/body_fecha.php'; ?>