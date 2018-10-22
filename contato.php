<?php
require_once 'bootstrap.php';

$contato = new SiteContatosAction();

if($_REQUEST['acao']=='enviar') {
  
  $contato->enviaContato($_REQUEST);
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=9">
<title>InterA&Ccedil;&Atilde;O</title>

<?php include 'assets/includes/js_css.php' ?>
<script type="text/javascript" src="assets/js/formulario.js"></script>

<script type="text/javascript">
function validaDados() {

  var f = document.frm_contato;
  
  if(validaTexto(f.nome))
    return abreAlerta("Digite o nome.");
  
  if(validaEmail(f.email))
    return abreAlerta("Digite o e-mail.");
    
  if(validaTexto(f.assunto))
    return abreAlerta("Digite o assunto.");

  if(validaTexto(f.mensagem))
    return abreAlerta("Digite sua mensagem.");
  
  f.submit();
  
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
            <td class="td_main5">Contato<br />
            </td>
            <td class="td_main1">ESCOLHA O SEU Plano</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF">
      
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="34" bgcolor="#FFFFFF" >&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" class="td_main6">
              <table width="558" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="368" valign="top">
                  
        <?php
        if (!$contato->getReturnMensage()) {
        ?>
                    <form id="frm_contato" name="frm_contato" method="post" action="<?php echo System::thisFile() ?>" onsubmit="return false">
                      <table width="500" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height="30" colspan="2" align="left" valign="top" class="texto-footer">* campos obrigat&oacute;rios</td>
                        </tr>
                        <tr>
                          <td width="100" height="30" align="left" valign="top" class="texto_form">Nome: <span class="texto-footer">*</span></td>
                          <td height="30" align="left" valign="top" class="texto_form">
                            <input name="nome" type="text" class="form" id="nome" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="30" align="left" valign="top" class="texto_form">E-mail: <span class="texto-footer">*</span></td>
                          <td height="30" align="left" valign="top" class="texto_form">
                            <input name="email" type="text" class="form" id="email" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="30" align="left" valign="top" class="texto_form">Telefone:</td>
                          <td height="30" align="left" valign="top" class="texto_form">
                            <input name="telefone" type="text" class="form" id="telefone" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td width="100" height="30" align="left" valign="top" class="texto_form">Assunto: <span class="texto-footer">*</span></td>
                          <td height="30" align="left" valign="top" class="texto_form">
                            <input name="assunto" type="text" class="form" id="assunto" maxlength="100" />
                          </td>
                        </tr>
                        <tr>
                          <td height="30" align="left" valign="top" class="texto_form">Mensagem: <span class="texto-footer">*</span></td>
                          <td height="30" align="left" valign="top" class="texto_form">
                            <textarea name="mensagem" rows="4" class="form" id="mensagem"></textarea>
                          </td>
                        </tr>
                      </table>
                      <input type="hidden" name="acao" value="enviar" />
                    </form>
                    
                    <br />
                    <table align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td class="button_cp"> <a href="javascript:void(0)" onclick="validaDados()">Enviar e-mail <img src="assets/images/load2.gif" name="load_cadastro" align="absmiddle" id="load_cadastro" style="display: none" /></a> </td>
                      </tr>
                    </table>
        <?php
        } else {
        ?>
        
        <p class="texto_form_mensagens"><?php echo $contato->getReturnMensage() ?></p>
        
        <?php
        }
        ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        
        </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><?php include 'assets/includes/lateral.php' ?></td>
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
      <td colspan="2" valign="top" bgcolor="#FFFFFF"><?php include 'assets/includes/rodape1.php' ?></td>
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
