<?php
require_once 'bootstrap.php';

$conteudo = new SiteConteudosAction();

$conteudo->setTipo('pag_duvidas');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
<title>InterA&Ccedil;&Atilde;O</title>

<?php include 'assets/includes/js_css.php' ?>

<link rel="stylesheet" type="text/css" href="assets/css/info.css" media="screen, print" />
<script type="text/javascript" src="assets/js/global.js"></script>
<!--======fim topicos=======-->
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
            <td class="td_main5">d&uacute;vidas <br /> <span class="td_main2">Tire suas d&uacute;vidas aqui ou <a href="contato.php" class="link-bco">contate-nos</a> para mais informa&ccedil;&otilde;es </span></td>
            <td class="td_main1">ESCOLHA O SEU Plano</td>
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
            <td align="center" bgcolor="#FFFFFF"><img src="assets/images/quem_somos/top.jpg" width="558" height="213" /></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="texto_destaque4">principais perguntas e respostas sobre o InterAÇÃO</td>
          </tr>

          <tr>
            <td bgcolor="#FFFFFF"><table width="558" align="center" cellpadding="0" cellspacing="0">

                <tr>
                  <td><ul id="topicos" class="perguntas">
                      
                      <?php
                      $row_conteudo = $conteudo->lista();
                      for ($i = 0; $i < count($row_conteudo); $i++) {
                      ?>
                      <li>
                        <h5><?php echo ($i+1) .'. '. $row_conteudo[$i]['nome'] ?></h5>
                        <div>
                          <span class="area_editor"><?php echo $row_conteudo[$i]['texto1'] ?></span>
                        </div>
                      </li>
                      <?php
                      }
                      ?>

                      
                  </ul></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      <td width="324" valign="top" bgcolor="#FFFFFF">
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
</html>
