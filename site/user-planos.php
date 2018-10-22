<?php
require_once 'bootstrap.php';
require_once 'assets/includes/login.php';

$cliente = new SiteClientesAction();

$cod_cli_periodo = (integer) $_REQUEST['cod'];

if (!$cod_cli_periodo) exit;

$row_aquisicao = $cliente->listaAquisicao($cod_cli_periodo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
<title>InterA&Ccedil;&Atilde;O</title>

<?php include 'assets/includes/js_css.php' ?>
<script type="text/javascript" src="assets/js/cpf_cnpj.js"></script>
<script type="text/javascript" src="assets/js/formulario.js"></script>
<script type="text/javascript" src="assets/js/jquery_maskedinput.js"></script>

<script type="text/javascript">

</script>
</head>

<body>
  <table width="100%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="header">
        <?php include 'assets/includes/topo1.php' ?>
      </td>
    </tr>
  </table>
  <table width="980" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="75">&nbsp;</td>
    </tr>
  </table>
  <table width="980" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="bg_top_main2"><table width="972" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="td_main5">&Aacute;rea restrita<br /> <span class="td_main2">Para sócios</span></td>
            <td class="td_main1">conhe&ccedil;a os Planos <br /> <span class="td_main2">Compre o seu plano ON-LINE</span></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF">
      
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="36%" align="left"><span class="texto_destaque2">Planos anuais</span></td>
                  <td width="23%" align="right"><a href="user-periodos.php" class="texto_destaque2"><img src="assets/images/icones/home.png" width="24" height="24" border="0" align="absmiddle" />Voltar</a></td>
                  <td width="26%" align="right"><a href="user-cadastro.php" class="texto_destaque2"><img src="assets/images/icones/adim.png" width="24" height="24" border="0" align="absmiddle" />MeuS Dados</a></td>
                  <td width="15%" align="right"><a href="user-login.php?acao=logoff" class="texto_destaque2"><img src="assets/images/icones/cancel.png" width="24" height="24" border="0" align="absmiddle" />Sair</a></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main8">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="21%" class="texto_form">Per&iacute;odo:</td>
                  <td width="79%"><?php echo $row_aquisicao['periodo']['periodo'] ?></td>
                </tr>
                <tr>
                  <td class="texto_form">Planos:</td>
                  <td>
                  <?php
                  foreach ($row_aquisicao['planos'] as $row) {
                    echo $row['plano'] .', ';
                  }
                  ?>
                  </td>
                </tr>
                <tr>
                  <td class="texto_form">Adquirido em: </td>
                  <td><?php echo Date::timestampToBr($row_aquisicao['periodo']['data_inserido']) ?></td>
                </tr>
              </table>
              <br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="texto_destaque2">Parcelas</td>
                </tr>
              </table>
              <table width="558" border="0" align="center" cellpadding="2" cellspacing="0">

                <tr>
                  <td width="90" class="">&nbsp;</td>
                  <td width="90" align="left" class="texto_form" >Vencimento</td>
                  <td width="90" align="left" class="texto_form" >Valor</td>
                  <td align="left" class="texto_form" >Status</td>
                  <td width="100" align="center" class="texto_form" >N&ordm; sorteio</td>
                </tr>

              </table>
              <table width="558" border="0" align="center" cellpadding="2" cellspacing="0">
              <?php foreach ($row_aquisicao['parcelas'] as $row) { ?>
              <tr>
                  <td width="90" class="td_line2">
                  
                  <?php if ($row['cod_status']==4 || $row['cod_status']==5) { ?>
                  <img src="assets/images/icones/money.png" width="24" height="24" border="0" align="absmiddle" />&nbsp;
                  <a href="user-pagamento.php?p=<?php echo Security::encripty($row['cod_cli_parcelas']) ?>" class="texto_form">Pagar</a>
                  <?php } else { ?>
                  <img src="assets/images/icones/money_ok.png" width="24" height="24" border="0" align="absmiddle" />&nbsp;
                  <span style="color:#999999">Pago</span>
                  <?php } ?>
                  
                  </td>
                  <td width="90" align="left" class="td_line2 texto-plano" > <strong><?php echo Date::timestampToBr($row['data_vencimento']) ?></strong></td>
                  <td width="90" align="left" class="td_line2 texto-plano" ><strong>R$ <?php echo Number::formatCurrencyBr($row['valor_total']) ?></strong></td>
                  <td align="left" class="td_line2 texto-plano" >

                  <strong style="color:<?php echo '#'. Useful::statusCor($row['cod_status']) ?>"><?php echo $row['status'] ?></strong>
                  
                  <?php
                  if ($row['pagamento_status']) {
                    echo ' ('. $row['pagamento_nome'] .' - '. $row['pagamento_status'] .')';
                  }
                  ?>
                  
                  </td>
                  <td width="100" align="center" class="td_line2 texto-plano" >
                  <?php
                  if ($row['cod_status']==6) {
                    echo $row['cod_cli_parcelas'];
                  }
                  ?>
                  </td>
                </tr>
                <?php } ?>
              </table>
              
            </td>
          </tr>
        </table>


      </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100" height="34" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s de Boleto Banc&aacute;rio ou pelo BCash.</td>
          </tr>
          <tr>
            <td><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center"><img src="assets/images/planos/bcash.jpg" width="87" height="56" /></td>
                </tr>
              </table></td>
          </tr>
        </table>
        <?php include 'assets/includes/lateral.php' ?>
      </td>
      <td width="4">&nbsp;</td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#FFFFFF" class="td_line">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" valign="top" bgcolor="#FFFFFF">
        <?php include 'assets/includes/rodape1.php' ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div id="footer">
    <table width="900" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="40" valign="bottom" class="texto-footer"><nobr> <a href="index.php" class="link-footer">Home</a> | <a href="quem-somos.php" class="link-footer">Quem Somos </a> | <a href="plano-ferias.php" class="link-footer">Plano F&eacute;rias </a> | <a href="plano-luz.php" class="link-footer">Plano Luz </a> | <a href="plano-arte.php" class="link-footer">Plano Arte </a> | <a href="duvidas.php" class="link-footer">Dúvidas </a> | <a href="contato.html" class="link-footer">Contato </a> | <a
            href="area-restrita.html" class="link-footer">Área Restrita </a>
        
        </td>
      </tr>
      <tr>
        <td height="40" class="texto-footer">InterA&Ccedil;&Atilde;O © 2013 - Todos os direitos reservados | <a href="http://www.nannydesign.com.br/" target="_blank" class="link-nyd">Design by Nannydesign</a></td>
      </tr>
    </table>
  </div>
  
  </footer>
  
</body>

<script type="text/javascript">
var fl = document.frm_login;
</script>

</html>
