<?
require 'bootstrap.php';
require 'assets/includes/login.php';

$contato = new ContatosAction();

header('Content-type: application/vnd.ms-excel');
header('Content-type: application/force-download');
header('Content-Disposition: attachment; filename=contato_'. date('Y-m-d') .'.xls');
header('Pragma: no-cache');
?>
<html>
<body>

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td bgcolor="#666666"><font color="#FFFFFF">Data</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Nome</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">E-mail</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Telefone</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Assunto</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Mensagem</font></td>
  </tr>
  <?php foreach($contato->listaExcel() as $row) { ?>
  <tr>
    <td><?php echo Date::timestampToBr($row['data']) ?></td>
    <td><?php echo $row['nome'] ?></td>
    <td><?php echo $row['email'] ?></td>
     <td><?php echo $row['telefone'] ?>&nbsp;</td>
    <td><?php echo $row['assunto'] ?>&nbsp;</td>
    <td><?php echo $row['mensagem'] ?>&nbsp;</td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
