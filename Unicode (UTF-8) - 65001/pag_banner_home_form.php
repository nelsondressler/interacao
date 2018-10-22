<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Banner Home');
SystemLayout::setModule('pag_banner_home');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$conteudo = new ConteudosAction();
$editor   = new EditorHtml();

$conteudo->setTipo('pag_banner_home');
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
  
  if ($_REQUEST['acao'] == 'excluir_arquivo') {
    $conteudo->excluirArquivoConteudo($cod, $_REQUEST['num'] );
  }

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

  if(validaSelecao(f.cod_conteudo_categoria)) {
    return abreAlerta("Escolha a Categoria.");
  }

  modalProcessing('Aguarde ...');
  
}

function excluirArquivo(num){
  msg = confirm("* ATENÇÃO *\n\nDeseja realmente excluir a imagem?");
  if(msg){
    parent.location = '<? echo System::thisFile() ?>?acao=excluir_arquivo&cod=<? echo $cod ?>&num='+ num;
  }
}

function cropArquivo(num, w, h) {
  
  modalIframe(567, 500, 'Crop de imagens', 'assets/includes/modal_conteudo_crop.php?targ_w='+ w +'&targ_h='+ h +'&numero='+ num +'&cod=<? echo $cod ?>', 'no', 'location.href="<?php echo System::thisFile() .'?cod='. $cod ?>"');
  
}

/*
 * Inicio
 */
$(document).ready(function() {

  $('input[name=ordem]').numeric();

});
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
          <input name="status" type="radio" value="1" <? echo Html::checked($row['status'], 1, true) ?> class="checked" />  Sim&nbsp;&nbsp;
          <input name="status" type="radio" value="0" <? echo Html::checked($row['status'], 0) ?> class="checked" />N&atilde;o
        </td>
      </tr>
      <tr>
        <td height="30" class="input_title">Ordem:</td>
        <td height="30"><input name="ordem" type="text" class="requerido" id="ordem" value="<? echo $row['ordem'] ?>" size="5" maxlength="5" /> </td>
      </tr>
    </table>
    <br />
    
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
      <tr>
        <td width="70" height="30" class="input_title">Texto1:</td>
        <td height="30">
          <textarea name="nome" cols="100" rows="2"><? echo $row['nome'] ?></textarea>
        </td>
      </tr>
      <tr>
        <td height="30" class="input_title">Texto2:</td>
        <td height="30">
          <textarea name="texto1" cols="100" rows="2" id="texto1"><? echo $row['texto1'] ?></textarea>
        </td>
      </tr>
      <tr>
        <td height="30" class="input_title">Texto3:</td>
        <td height="30">
          <textarea name="texto2" cols="100" rows="2" id="texto2"><? echo $row['texto2'] ?></textarea>
        </td>
      </tr>
      <tr>
        <td height="30" class="input_title">Texto4:</td>
        <td height="30">
          <textarea name="texto3" cols="100" rows="2" id="texto3"><? echo $row['texto3'] ?></textarea>
        </td>
      </tr>
    </table>
    <br />
    
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
      <tr>
        <td width="70" height="30" class="input_title">Imagem:</td>
        <td height="30">
          <?php
          $opcoes = array(
            'numero' =>'1',
            'largura'=>'800',
            'altura' =>'360',
            'crop'   =>'1'
          );
 
          echo ConteudoHelper::getHtmlConteudoImagem($opcoes, $row);
          ?>
        </td>
      </tr>
    </table>
    <br>
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