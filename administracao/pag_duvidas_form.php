<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Dúvidas');
SystemLayout::setModule('pag_duvidas');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$conteudo = new ConteudosAction();
$editor   = new EditorHtml();

$conteudo->setTipo('pag_duvidas');
$cod = $_REQUEST['cod'];

// Inclui
if ($_POST['acao'] == 'incluir') {
  
  if ( SystemLayout::getPermissao(2) ) {
    $conteudo->grava(true, array_merge($_POST, $_FILES));
  }
  
  
// Altera
} else if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $conteudo->grava(false, array_merge($_POST, $_FILES));
  }
  
// Outros
} else {

  if ($cod) {
    $row = $conteudo->exibeConteudo($cod);
    
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<script type="text/javascript">
/*
 * Funcoes para o Conteudo
 */
function validaDados(f) {

  if(validaTexto(f.nome)) {
    return abreAlerta("Digite o Título.");
  }

  var oEditor = FCKeditorAPI.GetInstance('texto1');
  var text = oEditor.GetHTML(true);
  if(text == '') return abreAlerta("Digite o Texto.");
  
  modalProcessing('Aguarde ...');
  
}

</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<?php
if ($conteudo->getReturnMensage()) {
  
  echo SystemLayout::msgBox($conteudo->getReturnMensage());
  
} else {
?>
<br>

<form action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)" enctype="multipart/form-data">
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="70" height="30" class="input_title">Publicar:</td>
      <td height="30">
        <input name="status" type="radio" value="1" <? echo Html::checked($row['status'], 1, true) ?> class="checked" />
        Sim&nbsp;&nbsp;&nbsp;
        <input name="status" type="radio" value="0" <? echo Html::checked($row['status'], 0) ?> class="checked" />
        N&atilde;o </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Ordem:</td>
      <td height="30">
        <input name="ordem" type="text" class="requerido" id="ordem" value="<? echo $row['ordem'] ?>" size="5" maxlength="5" />
        </td>
    </tr>
  </table>
  <br />

    
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="70" height="30" class="input_title">T&iacute;tulo:</td>
      <td height="30"><input name="nome" type="text" class="requerido" value="<? echo $row['nome'] ?>" size="100" maxlength="200" /></td>
    </tr>
</table>
  <br>
  
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td class="input_title">Conte&uacute;do:</td>
    </tr>
    <tr>
      <td><?php $editor->create('texto1', $row['texto1'], 500); ?>
      </td>
    </tr>
  </table>
    

  <?php
  $acao = '';
    
  if ( SystemLayout::getPermissao(2) && !$cod) {
    $botao_submit = 'Incluir';
    $acao         = 'incluir';
  }
    
  if ( SystemLayout::getPermissao(3) && $cod) {
    $botao_submit = 'Alterar';
    $acao         = 'alterar';
  }
  
  if ($acao) {
    echo '<div id="painel_submit">
    <input name="button" type="submit" class="botao_submit" value="'. $botao_submit .'" />
    <input type="hidden" name="acao" value="'. $acao .'">
    <input type="hidden" name="cod" value="'. $cod .'">
    <input type="hidden" name="status" value="1">
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