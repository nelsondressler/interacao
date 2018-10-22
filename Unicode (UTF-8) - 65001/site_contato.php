<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <table width="600" border="0" cellpadding="4" cellspacing="0">
    <tr>
      <td width="89" align="left"><strong>Nome:</strong></td>
      <td width="495" align="left"><?php echo $row['nome'] ?></td>
    </tr>
    <tr>
      <td align="left"><strong>E-mail:</strong></td>
      <td align="left"> <?php echo $row['email'] ?> </td>
    </tr>
    <tr>
      <td align="left"><strong>Telefone:</strong></td>
      <td align="left"> <?php echo $row['telefone'] ?> </td>
    </tr>
    <tr>
      <td align="left"><strong>Assunto:</strong></td>
      <td align="left"> <?php echo $row['assunto'] ?> </td>
    </tr>
    <tr>
      <td align="left"><strong>Mensagem:</strong></td>
      <td align="left"><?php echo nl2br($row['mensagem']) ?></td>
    </tr>
  </table>
