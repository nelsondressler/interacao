<?php
require_once 'bootstrap.php';

$cod_cli_parcelas = (integer) Security::decripty($_REQUEST['p']);
if (!$cod_cli_parcelas) exit;

$plano     = new SitePlanosAction();
$row_dados = $plano->parcelaDados($cod_cli_parcelas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
<title>InterA&Ccedil;&Atilde;O</title>

<?php include 'assets/includes/js_css.php' ?>

<script type="text/javascript">
function escolherPagamento(forma) {

  if (forma=='Itau-Shopline') {
    alert('Forma de pagamento indisponível no momento');
    return false
  }
  
  if (forma) {
    document.frm_pagamento.pagamento.value = forma;
    document.frm_pagamento.submit();
  }
  
}
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
            <td class="td_main5">Pagamento de parcela</td>
            <td class="td_main1">conhe&ccedil;a os Planos <br /> <span class="td_main2">Compre o seu plano ON-LINE</span></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF">
      
        <table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><span class="texto_destaque2">Clique na forma de pagamento que deseja</span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">
              <table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="98"  class="texto_form"> Vencimento:</td>
                  <td width="460" class="texto-plano"><?php echo Date::timestampToBr($row_dados['data_vencimento']) ?></td>
                </tr>
                <tr>
                  <td class="texto_form">Valor:</td>
                  <td class="texto-plano"><?php echo Number::formatCurrencyBr($row_dados['valor']) ?></td>
                </tr>
                <tr>
                  <td  class="texto_form">Planos:</td>
                  <td class="texto-plano">
                  <?php
                  foreach ($row_dados['planos'] as $row) {
                    echo $row['plano'] .', ';
                  }
                  ?></td>
                </tr>
              </table>
              <br />
              
              <form action="user-pagamento-finaliza.php" name="frm_pagamento" method="post" onsubmit="return false" target="_blank">
              <table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="162" class="texto_form_titulo">  BCash            </td>
                  <td width="396" class="texto_form_titulo"></td>
                </tr>
                <tr>
                  <td  class="texto_form_titulo"><a href="javascript:void(0)" onclick="escolherPagamento('BCash')"><img src="assets/images/bcash1.jpg" width="107" height="45" border="0" /></a></td>
                  <td class="texto_form_titulo"></td>
                </tr>
              </table>
              <input type="hidden" name="p" value="<?php echo $_REQUEST['p'] ?>" />
              <input type="hidden" name="pagamento" value="" />
              </form>

            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6">&nbsp;</td>
          </tr>
        </table>

        </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td height="34" colspan="2" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s de Boleto Banc&aacute;rio ou pelo BCash.</td>
          </tr>
          <tr>
            <td colspan="2"><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center"><img src="assets/images/planos/bcash.jpg" width="87" height="56" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="2" class="td_line2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="titulo_planos_qs">d&uacute;vidas sobre os planos</td>
          </tr>
          <tr>
            <td class="texto_planos_qs">Perguntas e respostas sobre a aquisi&ccedil;&atilde;o dos Planos.</td>
            <td width="100" class="botao_planos_qs"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_qs"><a href="duvidas.php">Acesse aqui</a></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="titulo_outros_planos_comprando3">conhe&ccedil;a a intera&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="td_main7"><span class="texto_destaque3">InterAÇÃO</span> mantém o elo de gratidão entre o ex-aluno e sua escola, entre o pai e o professor, entre a comunidade e a escola judaica religiosa. Ao adquirir um dos planos <span class="texto_destaque3">- FÉRIAS, LUZ ou ARTE -</span>, você contribui para as Escolas e patrocina o aprendizado de um aluno. Ao final, um prêmio referente a cada pacote será sorteado. É uma influência recíproca, uma manifestação de reconhecimento,
              uma maneira de interagir com quem fez parte de sua história.</td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_qs"><a href="quem-somos.php">Saiba mais</a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
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
</html>
