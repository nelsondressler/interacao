<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Planos e Períodos');
SystemLayout::setModule('sys_planos');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$plano = new PlanosAction();
$editor   = new EditorHtml();

$cod     = $_REQUEST['cod'];

// Inclui
if ($_POST['acao'] == 'incluir') {
  
  if ( SystemLayout::getPermissao(2) ) {
    $plano->grava(true, array_merge($_POST, $_FILES));
  }
  
  
// Altera
} else if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $plano->grava(false, array_merge($_POST, $_FILES));
  }
  
// Outros
} else {

  if ($_REQUEST['acao'] == 'excluir_arquivo') {
    $plano->excluirArquivo($cod, $_REQUEST['num'] );
  }
  
  if ($cod) {
    $row = $plano->exibe($cod);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<script type="text/javascript">
function validaDados(f) {

  if(validaSelecao(f.cod_periodo)) {
    return abreAlerta("Escolha o Período.");
  }
  
  if(validaTexto(f.plano)) {
    return abreAlerta("Digite o Nome do plano.");
  }

  if(validaValor(f.valor)) {
    return abreAlerta("Digite Um valor válido (Ex.: 1.999,99).");
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
  
  modalIframe(567, 500, 'Crop de imagens', 'assets/includes/modal_plano_crop.php?targ_w='+ w +'&targ_h='+ h +'&numero='+ num +'&cod=<? echo $cod ?>', 'no', 'location.href="<?php echo System::thisFile() .'?cod='. $cod ?>"');
  
}

$(function($) {

  
});
</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<?php
if ($plano->getReturnMensage()) {
  
  echo SystemLayout::msgBox($plano->getReturnMensage());
  
} else {
?>
<br>

<form name="frm" action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)" enctype="multipart/form-data">
<div id="painel_geral">
  Campos na cor cinza, são obrigatórios
</div>

  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>
        Dados do gerais
      </td>
    </tr>
  </table>
 <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="110" height="30" class="input_title">Per&iacute;odo:</td>
      <td width="712" height="30"><?php echo Html::select('cod_periodo', $plano->listaPeriodos(), 'periodo', 'cod_periodo', $row['cod_periodo'], 'requerido') ?></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Plano: </td>
      <td height="30"><input name="plano" type="text" class="requerido" id="plano" value="<? echo $row['plano'] ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Valor:</td>
      <td height="30"><input name="valor" type="text" class="requerido" id="valor" value="<? echo Number::formatCurrencyBr($row['valor']) ?>" size="12" maxlength="12" /></td>
    </tr>
  </table>
  <br />
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
    <tr>
      <td>
        Conteúdo
      </td>
    </tr>
  </table>
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="110" height="30" class="input_title">Imagem pequena:</td>
      <td height="30">
        <?php
          $opcoes = array(
            'numero' =>'1',
            'largura'=>'290',
            'altura' =>'131',
            'crop'   =>'1'
          );
          echo ConteudoHelper::getHtmlPlanoImagem($opcoes, $row);
          ?>
      </td>
    </tr>
  </table>
  <br />
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td width="110" height="30" class="input_title">Imagem grande:</td>
      <td height="30">
        <?php
          $opcoes = array(
            'numero' =>'2',
            'largura'=>'558',
            'altura' =>'251',
            'crop'   =>'1'
          );
          echo ConteudoHelper::getHtmlPlanoImagem($opcoes, $row);
          ?>
      </td>
    </tr>
  </table>
  <br />
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td height="30" class="input_title">Sub t&iacute;tulo:</td>
      <td height="30">
        <input name="texto3" type="text" id="texto3" value="<? echo $row['texto3'] ?>" size="100" maxlength="100" />
      </td>
    </tr>
    <tr>
      <td width="110" height="30" class="input_title">Descri&ccedil;&atilde;o:</td>
      <td height="30">
        <textarea name="descricao" cols="100" rows="2" id="descricao"><? echo $row['descricao'] ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="110" height="30" class="input_title">Texto lateral:</td>
      <td height="30">
        <textarea name="texto2" cols="100" rows="2" id="texto2"><? echo $row['texto2'] ?></textarea>
      </td>
    </tr>
</table>
  <br />
  <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td class="input_title">Conte&uacute;do:</td>
    </tr>
    <tr>
      <td>
        <?php $editor->create('texto1', $row['texto1'], 500); ?>
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