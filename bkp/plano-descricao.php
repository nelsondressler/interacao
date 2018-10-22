<?php
require_once 'bootstrap.php';

$cod = (integer) $_REQUEST['cod'];
if (!$cod) exit;

$plano     = new SitePlanosAction();
$row_plano = $plano->exibe($cod);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
  <title>InterA&Ccedil;&Atilde;O</title> <?php include 'assets/includes/js_css.php' ?>

</head>

<body>
  <table width="100%" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="header"><?php include 'assets/includes/topo1.php' ?>
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
            <td class="td_main5"><?php echo $row_plano['plano'] ?> <br /> <span class="td_main2"><?php echo $row_plano['texto3'] ?> </span></td>
            <td class="td_main1">adquira O <?php echo $row_plano['plano'] ?><br /> <span class="td_main2">Compre o seu plano ON-LINE</span></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF"><table width="100%" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="34" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF"><img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row_plano['arquivo2'] ?>" width="558" height="251" /></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6 area_editor"><?php echo $row_plano['texto1'] ?>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6"><table align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="button_cp"><a href="contato.php">                  ENVIAREMOS UM EMAIL PARA VOC&Ecirc; NO LAN&Ccedil;AMENTO DOS PLANOS</a></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100" height="34" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_destaque3">Compre o <?php echo $row_plano['plano'] ?> On-Line e escolha pagar atrav&eacute;s de Boleto Banc&aacute;rio ou pelo BCash.</td>
          </tr>
          <tr>
            <td><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="150" align="center"><img src="assets/images/planos/icone_bbancario.gif" width="130" height="56" /></td>
                  <td width="150" align="center"><img src="assets/images/planos/bcash.jpg" width="87" height="56" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="td_line2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="td_main1">OUTROS PLANOS</td>
          </tr>
        </table>
        
        <?php
        $row_lista_planos = $plano->lista();
        
        for ($i = 0; $i < count($row_lista_planos); $i++) {
          if ($row_lista_planos[$i]['cod_plano']!=$cod) {
          ?>
          <table width="300" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="bg_fts_qs"><img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row_lista_planos[$i]['arquivo1'] ?>" width="290" height="131" /></td>
            </tr>
            <tr>
              <td colspan="2" class="titulo_planos_qs"><?php echo $row_lista_planos[$i]['plano'] ?></td>
            </tr>
            <tr>
              <td class="texto_planos_qs"><?php echo $row_lista_planos[$i]['texto2'] ?></td>
              <td width="100" class="botao_planos_qs">
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td class="button_qs"><a href="plano-descricao.php?cod=<?php echo $row_lista_planos[$i]['cod_plano'] ?>">Saiba mais</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <?php
          }
        }
        ?>
        
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
      <td colspan="2" valign="top" bgcolor="#FFFFFF"><?php include 'assets/includes/rodape1.php' ?>
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
  </div>
  </div>
  </div>
  </div>
  </footer>
</body>
</html>
