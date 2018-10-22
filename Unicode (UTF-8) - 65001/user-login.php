<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require_once 'bootstrap.php';

if ($_REQUEST['acao']=='logoff') {
  unset($_SESSION["site_cod_cliente"]);
}

$cod = (integer) $_SESSION["site_cod_cliente"];

if ($cod) {
  header ("Location: user-periodos.php");
  exit;
}

$cliente = new SiteClientesAction();

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

function verificaLogin() {

  if(validaTexto(fl.email)) {
    return abreAlerta('Digite seu E-mail.');
  }
  
  if(validaTexto(fl.senha)) {
    return abreAlerta('Digite sua Senha');
  }

  $('#load_login').show();
  $.ajax({
    data: $(frm_login).serialize(),
    success: function(resposta) {
      $('#load_login').hide();
      if(resposta) {
        alert(resposta);
      } else {
        window.location = 'user-periodos.php';
      }
    }
  });
  
}

function lembrarSenha() {
  
  if(validaEmail(fl.email)) {
    return abreAlerta('Digite seu E-mail');
  }

  fl.acao.value = 'lembra_senha';
  $('#load_senha').show();
  
  $.ajax({
    data: $(frm_login).serialize(),
    success: function(resposta) {
      resposta = trim(resposta);
      if(resposta) {
        $('#load_senha').hide();
        alert(resposta);
        fl.acao.value = 'site_login';
      }
    }
  });
  
}


$(function($) {

  $('input[name=cep]').mask("99999-999");
  
});
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
            <td bgcolor="#FFFFFF" class="td_main6"><span class="texto_destaque2">se voc&ecirc; j&aacute; &eacute; s&oacute;cio da intera&ccedil;&atilde;o, digite seu login e senha</span></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><table width="558" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="368" valign="top">
                  
                  <form id="frm_login" name="frm_login" method="post" action="<?php echo System::thisFile() ?>" onsubmit="return false">
                      <table width="368" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="80" class="texto_form">E-mail:</td>
                          <td colspan="3" class="texto_form"><input name="email" type="text" class="form" id="email" /></td>
                        </tr>
                        <tr>
                          <td width="80" class="texto_form">Senha:</td>
                          <td width="160" class="texto_form"><input name="senha" type="password" class="form" id="senha" /></td>
                          <td width="21" align="center"></td>
                          <td width="107" align="center">
                            <input name="button" type="button" class="form" id="button" value="OK" onclick="verificaLogin()" style="width: 50px" />
                            <img src="assets/images/load1.gif" name="load_cadastro" align="absmiddle" id="load_login" style="display: none" />
                            <input type="hidden" name="acao" value="site_login" />
                          </td>
                        </tr>
                      </table>
                    </form>
                    
                  </td>
                  <td width="190" align="center">
                  <a href="javascript:void(0)" onclick="lembrarSenha()" class="link-esqueci-senha">Esqueci minha senha</a>
                  <img src="assets/images/load1.gif" name="load_senha" align="absmiddle" id="load_senha" style="display: none" />
                  </td>
                </tr>
              </table></td>
          </tr>
        </table>


      </td>
      <td width="324" valign="top" bgcolor="#FFFFFF"><table width="300" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100" height="34" class="td_line">&nbsp;</td>
          </tr>
          <tr>
            <td class="texto_destaque3">Compre os Planos da InterA&Ccedil;&Atilde;O On-Line e escolha pagar atrav&eacute;s do Pagseguro.</td>
          </tr>
          <tr>
            <td><table width="300" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center"><img src="assets/images/planos/pagseguro.png" alt="" width="120" height="133" /></td>
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
