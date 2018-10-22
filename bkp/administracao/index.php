<?php
require 'bootstrap.php';

if ($_GET['acao'] == 'logoff') {
  
  $_SESSION["login_cod"]        = null;
  $_SESSION["login_nome"]       = null;
  $_SESSION["login_permissoes"] = null;
  $_SESSION["login_idioma"]     = null;
  
}

require 'assets/includes/login.php';

// Lembrar de excluir estas váriaveis quando o site for para testes
$login = 'admin';
$senha = '1234';
?>

<?php require 'assets/blocks/header_abre.php'; ?>

<style>
body {
  overflow-x: hidden;
  overflow-y: hidden;
}
</style>

<style type="text/css">
#login {
  position: absolute;
  width: 300px;
  height: 280px;
  left: 50%;
  top: 50%;
  margin-left: -150px;
  margin-top: -140px;
}

.titulo {
  color: #2274ae;
  font: 25px Arial;
}
</style>

<script type="text/javascript">

function lembrarSenha() {
  
  if(validaTexto(f.login)) {
    return abreAlerta('Digite seu login e clique em "Não lembro minha senha"');
  }
  
  $.ajax({
    data: 'acao=lembra_senha&login='+ f.login.value,
    success: function(resposta) {
      resposta = trim(resposta);
      if(resposta) { alert(resposta); }
    }
  });
  
}

function verificaLogin() {
    
  if(validaTexto(f.login)) {
    return abreAlerta('Digite seu login.');
  }
  
  if(validaTexto(f.senha)) {
    return abreAlerta('Digite sua senha');
  }

  $.ajax({
    data: $(f).serialize(),
    success: function(resposta) {
      if(resposta) {
        alert(resposta);
      } else {
        f.submit();
      }
    }
  });
     
}

</script>

<?php require 'assets/blocks/header_fecha.php'; ?>

<body>

<div id="login">

<table width="300" border="0" cellpadding="0" cellspacing="0" background="assets/img/bg_login.gif">
  <tr>
    <td height="280" align="center" valign="middle">

    <form action="index.php" method="post" name="frm">
    <table width="280" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50" colspan="3" align="center" valign="middle" class="titulo"><?php echo SYS_NOME ?></td>
      </tr>
      <tr>
        <td height="10" colspan="3">
        <div class="linha"></div>
        </td>
      </tr>
      <tr>
        <td width="47" rowspan="2" align="center"><img src="assets/img/login.png" /></td>
        <td width="50" align="left">Login:</td>
        <td width="183" height="30" align="left">
        <input name="login" type="text" value="<?php echo $login ?>" size="20" style="width:120px"  /></td>
      </tr>
      <tr>
        <td height="30" align="left">Senha:</td>
        <td height="30" align="left">
        <input name="senha" type="password" value="<?php echo $senha ?>" size="20" style="width:120px" /></td>
      </tr>
      <tr>
        <td height="40" align="center">&nbsp;</td>
        <td height="40" align="left">&nbsp;</td>
        <td height="40" align="left">
          <input name="Button" type="button" class="botao" onClick="verificaLogin()" value="Entrar" style="width:120px" />
          <input type="hidden" name="acao" value="login" />
          <input type="hidden" name="idioma" value="br" />
        </td>
      </tr>
    </table>
    <table width="280" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="10" align="center">
        <div class="linha"></div>
        </td>
      </tr>
      <tr>
        <td height="30" align="center"><a href="javascript:void(0)" onClick="lembrarSenha()">N&atilde;o lembro minha senha </a></td>
      </tr>
    </table>
    </form>

    </td>
  </tr>
</table>

</div>

<script type="text/javascript">
var f = document.frm;
</script>

</body>
</html>
