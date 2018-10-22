<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('<img src="assets/img/ico_usuarios_b.gif" align="absmiddle" /> Usuários da administração');

SystemLayout::setModule('adm_usuarios');

SystemLayout::addNavigate('Usuários da administração', SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
}

$usuarios = new AdministracaoUsuariosAction();

// Inclui
if ($_POST['acao'] == 'incluir') {
  
  if ( SystemLayout::getPermissao(2) ) {
    $usuarios->grava(true, $_POST);
  }
  
// Altera
} else if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $usuarios->grava(false, $_POST);
  }
  
// Outros
} else {
  
  if ($_GET["cod"]) {
    $row = $usuarios->exibe($_GET["cod"]);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>

<script type="text/javascript">
function validaDados(f){
  
  if(validaTexto(f.nome))
    return abreAlerta("O nome é obrigatório.");

  if(validaTexto(f.email))
    return abreAlerta("O email é obrigatório (Digite um email válido).");
  
  if(validaTexto(f.login))
    return abreAlerta("O login é obrigatório.");
    
  if(validaTexto(f.senha))
    return abreAlerta("A senha é obrigatória.");
}


function selecionaTudo(modulo, op) {

  $('input[menu='+ modulo +']').each(function (i) {
    if (op==1) {
      $(this).attr('checked','checked');
    } else {
      $(this).attr('checked','');
    }
  });

}
</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<?php
if ($usuarios->getReturnMensage()) {
  
  echo SystemLayout::msgBox($usuarios->getReturnMensage());
  
} else {
?>

<div id="painel_geral">
  Campos na cor cinza, são obrigatórios
</div>

<form action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)">
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>
        Dados do usu&aacute;rio
      </td>
    </tr>
  </table>
<table width="770" border="0" cellspacing="0" cellpadding="0" class="table_form" align="center">
  <tr>
    <td width="55" height="30" class="input_title">
      Nome:  </td>
    <td width="728" height="30">
      <input name="nome" type="text" class="requerido" value="<? echo $row['nome'] ?>" size="20" maxlength="20" />    </td>
  </tr>
  <tr>
    <td height="30" class="input_title">E-mail:</td>
    <td height="30"><input name="email" type="text" class="requerido" value="<? echo $row['email'] ?>" size="100" maxlength="100" /></td>
  </tr>
  <tr>
    <td height="30" class="input_title">Login:</td>
    <td height="30">
      <input name="login" type="text" class="requerido" value="<? echo $row['login'] ?>" size="20" maxlength="20" />    </td>
  </tr>
  <tr>
    <td height="30" class="input_title">Senha:</td>
    <td height="30"><input name="senha" type="password" class="requerido" value="<? echo Security::decripty($row['senha']) ?>" size="20" maxlength="20" />
    </td>
  </tr>
</table>
  <br />
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>
        Permiss&otilde;es do usu&aacute;rio
      </td>
    </tr>
  </table>
  
  <?php
  foreach (AdministracaoHelper::listaMenu() as $list_titulo) {
  ?>
    
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_grid">
      <tr>
        <td width="160" align="left" bgcolor="#F0F0F0" class="input_title"><span class="arial15"><strong><?php echo $list_titulo['nome'] ?></strong></span></td>
        <td align="left" bgcolor="#F0F0F0" class="input_title">Permiss&otilde;es</td>
        <td align="left" bgcolor="#F0F0F0" class="input_title">&nbsp;</td>
        <td align="left" bgcolor="#F0F0F0" class="input_title">&nbsp;</td>
        <td align="right" bgcolor="#F0F0F0">
          <a href="javascript:void(0)" onclick="selecionaTudo('<?php echo $list_titulo['menu'] ?>', 1)">Selecionar tudo</a>
        </td>
      </tr>
      <?php
      foreach (AdministracaoHelper::listaPermissoes() as $list_menu) {
        
        if ($list_menu['menu'] == $list_titulo['menu'] && !$list_menu['divisor']) {
        ?>
        <tr>
          <td align="left"><?php echo $list_menu['nome'] ?></td>
          <td width="100" align="left">
           <input name="<?php echo $list_menu['modulo'] ?>[]" menu="<?php echo $list_menu['menu'] ?>" type="checkbox" value="1" <?php if ($usuarios->getPermissao($list_menu['modulo'], 1, $_GET["cod"])) {echo 'checked';} ?> />
            Visualizar
          </td>
          <td width="100" align="left">
          <input name="<?php echo $list_menu['modulo'] ?>[]" menu="<?php echo $list_menu['menu'] ?>" type="checkbox" value="2" <?php if ($usuarios->getPermissao($list_menu['modulo'], 2, $_GET["cod"])) {echo 'checked';} ?> />
            Inserir
          </td>
          <td width="100" align="left">
          <input name="<?php echo $list_menu['modulo'] ?>[]" menu="<?php echo $list_menu['menu'] ?>" type="checkbox" value="3" <?php if ($usuarios->getPermissao($list_menu['modulo'], 3, $_GET["cod"])) {echo 'checked';} ?> />
            Alterar
          </td>
          <td align="left">
            <input name="<?php echo $list_menu['modulo'] ?>[]" menu="<?php echo $list_menu['menu'] ?>" type="checkbox" value="4" <?php if ($usuarios->getPermissao($list_menu['modulo'], 4, $_GET["cod"])) {echo 'checked';} ?> />
            Excluir
          </td>
        </tr>
        <?php
        }
      }
      ?>

    </table>
  <?php
  }
  ?>
  
  
<?php
$acao = '';
  
if ( SystemLayout::getPermissao(2) && !$_GET["cod"]) {
  $botao_submit = 'Incluir';
  $acao         = 'incluir';
}
  
if ( SystemLayout::getPermissao(3) && $_GET["cod"]) {
  $botao_submit = 'Alterar';
  $acao         = 'alterar';
}

if ($acao) {
  echo '<div id="painel_submit">
  <input name="button" type="submit" class="botao_submit" value="'. $botao_submit .'" />
  <input type="hidden" name="acao" value="'. $acao .'">
  <input type="hidden" name="cod" value="'. $_GET["cod"] .'">
  </div>';
}
?>
</form>
<script type="text/javascript">
var f = document.frm;
</script>

<?php
}
?>

<?php require 'assets/blocks/body_fecha.php'; ?>