<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Lista Contatos');
SystemLayout::setModule('frm_contato');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Resultado');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

$contato = new ContatosAction();
$cod     = $_REQUEST['cod'];

if ($cod) {
  $row = $contato->exibe($cod);
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<br>
<table width="700" border="0" align="center" cellpadding="2" cellspacing="0" class="table_form">
  <tr>
    <td height="30" align="left" class="input_title">Data:</td>
    <td height="30" align="left"><?php echo Date::timestampToBr($row['data']) ?></td>
  </tr>
  <tr>
    <td width="77" height="30" align="left" class="input_title">Nome:</td>
    <td height="30" align="left"> <?php echo $row['nome'] ?>  </td>
  </tr>
  <tr>
    <td height="30" align="left" class="input_title">E-mail:</td>
    <td height="30" align="left"><?php echo $row['email'] ?> </td>
  </tr>
  <tr>
    <td height="30" align="left" class="input_title">Telefone:</td>
    <td height="30" align="left"> <?php echo $row['telefone'] ?> </td>
  </tr>
  <tr>
    <td height="30" align="left" class="input_title">Assunto:</td>
    <td height="30" align="left"> <?php echo $row['assunto'] ?> </td>
  </tr>
  <tr>
    <td height="30" align="left" class="input_title">Mensagem: </td>
    <td height="30" align="left"><?php echo nl2br($row['mensagem']) ?> </td>
  </tr>
</table>
<br />
<?php require 'assets/blocks/body_fecha.php'; ?>