<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?
require 'bootstrap.php';
require 'assets/includes/login.php';

$clientes = new ClientesAction();

header('Content-type: application/vnd.ms-excel');
header('Content-type: application/force-download');
header('Content-Disposition: attachment; filename=clientes_'. date('Y-m-d') .'.xls');
header('Pragma: no-cache');
?>
<html>
<body>

<table border="1" cellpadding="4" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td bgcolor="#666666"><font color="#FFFFFF">Data cadastro</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Nome</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">E-mail</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">CPF</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Telefone</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Celular</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Indica&ccedil;&atilde;o</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">CEP</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Endere&ccedil;o</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">N&uacute;mero</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Complemento</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Estado</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Cidade</font></td>
    <td bgcolor="#666666"><font color="#FFFFFF">Bairro</font></td>
  </tr>
  <?php foreach($clientes->lista() as $row) { ?>
  <tr>
    <td><?php echo Date::timestampToBr($row['data_cadastro']) ?></td>
    <td><?php echo $row['nome'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['cpf'] ?></td>
    <td><?php echo $row['telefone'] ?></td>
    <td><?php echo $row['celular'] ?></td>
    <td><?php echo $row['indicacao'] .' - '. $row['indicacao_qual'] ?></td>
    <td><?php echo $row['cep'] ?></td>
    <td><?php echo $row['endereco'] ?></td>
    <td><?php echo $row['numero'] ?></td>
    <td><?php echo $row['complemento'] ?></td>
    <td><?php echo $row['estado'] ?></td>
    <td><?php echo $row['cidade'] ?></td>
    <td><?php echo $row['bairro'] ?></td>			<?php // inclusão planos	$cliente = new SiteClientesAction();	$row_aquisicao = $cliente->listaAquisicao($cod_cli_periodo);	?>	<td><?php /*foreach ($row_aquisicao['planos'] as $plan_cod) {                      echo 'P'.substr($plan_cod['plano'], 6, 1).substr(md5($plan_cod['plano']), 6, 2);                      echo $row['cod_cli_parcelas'] .', ';					} */?></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
