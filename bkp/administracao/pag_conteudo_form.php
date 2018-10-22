<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Teste');
SystemLayout::setModule('pag_conteudo');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$conteudo = new ConteudosAction();
$editor   = new EditorHtml();

$conteudo->setTipo('pag_conteudo');
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
  
  if ($_REQUEST['acao'] == 'excluir_assets') {
    $conteudo->excluirAssets($_REQUEST['cod_assets']);
  }
  
  if ($cod) {
    $row = $conteudo->exibeConteudo($cod);
    $data = $row['data'];
    $row['data'] = Date::timestampToBr($data);
    $row['hora'] = Time::timestampToBr($data);
    
  } else {
    $row['ordem'] = $conteudo->proximaOrdenacao();
    $row['data']  = date('d/m/Y');
    $row['hora']  = date('H:i');
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
 * Funcoes para o conteudo Assets
 */
function excluirArquivoAssets(cod){
 msg = confirm("* ATENÇÃO *\n\nDeseja realmente excluir a imagem?");
 if(msg){
  parent.location = '<? echo System::thisFile() ?>?acao=excluir_assets&cod=<? echo $cod ?>&cod_assets='+ cod;
 }
}

function cropArquivoAssets(num, cod, w, h) {
  
  modalIframe(567, 500, 'Crop de imagens', 'assets/includes/modal_conteudo_assets_crop.php?targ_w='+ w +'&targ_h='+ h +'&numero='+ num +'&cod='+ cod, 'no', 'location.href="<?php echo System::thisFile() .'?cod='. $cod ?>&tab=arquivo_assets"');
  
}

/*
 * Inicio
 */
$(document).ready(function() {

  $('input[name=ordem]').numeric();
  $("#lista_assets").simplesAddLista();

  $('.tabs a').click(function(){
    switch_tabs($(this));
  });
 
  switch_tabs($('.defaulttab'));
  
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

<div class="wrapper">
  <?php
  if ($_REQUEST['acao'] == 'excluir_assets' || $_REQUEST['tab'] == 'arquivo_assets') {
    $tabs2 = 'defaulttab';
  } else {
    $tabs1 = 'defaulttab';
  }
  ?>
  <ul class="tabs">
    <li><a href="#" rel="tabs1" class="<?php echo $tabs1 ?>">Conteúdo</a></li>
    <li><a href="#" rel="tabs2" class="<?php echo $tabs2 ?>">Imagens</a></li>
  </ul>

  <!-- Geral -->
  <div class="tab-content" id="tabs1">

    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
      <tr>
        <td width="70" height="30" class="input_title">Publicar:</td>
        <td height="30">
          <input name="status" type="radio" value="1" <? echo Html::checked($row['status'], 1, true) ?> class="checked" />  Sim&nbsp;&nbsp;&nbsp;
          <input name="status" type="radio" value="0" <? echo Html::checked($row['status'], 0) ?> class="checked" />N&atilde;o
        </td>
      </tr>
      <tr>
        <td height="30" class="input_title">Principal:</td>
        <td height="30">
          <input name="principal" type="radio" value="1" <? echo Html::checked($row['principal'], 1) ?> class="checked" />Sim&nbsp;&nbsp;&nbsp;
          <input name="principal" type="radio" value="0" <? echo Html::checked($row['principal'], 0, true) ?> class="checked" />N&atilde;o
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
        <td height="30" class="input_title">Data:</td>
        <td height="30">
          <input name="data" type="text" class="requerido" id="data" value="<? echo $row['data'] ?>" size="10" maxlength="10" />&aacute;s
          <input name="hora" type="text" class="requerido" id="hora" value="<? echo $row['hora'] ?>" size="5" maxlength="5" />
        </td>
      </tr>
      <tr>
        <td width="70" height="30" class="input_title">T&iacute;tulo:</td>
        <td height="30"><input name="nome" type="text" class="requerido" value="<? echo $row['nome'] ?>" size="100" maxlength="200" /></td>
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
            'largura'=>'350',
            'altura' =>'200',
            'crop'   =>'1'
          );
          
          echo ConteudoHelper::getHtmlConteudoImagem($opcoes, $row);
          ?>
        </td>
      </tr>
    </table>
    <br>
    
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
      <tr>
        <td width="70" height="30" class="input_title">Arquivo:</td>
        <td height="30">
          <?php
          echo ConteudoHelper::getHtmlConteudoArquivo(2, $row);
          ?>
        </td>
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
    
  </div>
  
  <!-- Imagens -->
  <div class="tab-content" id="tabs2">
  
    <?php
    $row_assets = $conteudo->listaAssets($cod);
    $total      = count($row_assets);
    if ($total > 0) {
    ?>
    
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
      <tr>
        <td>Imagens</td>
      </tr>
    </table>
    
    <?php for ($i = 0; $i < $total; $i++) { ?>
      <table width="770" border="0" align="center" cellpadding="2" cellspacing="0" style="border: #CCCCCC solid 1px; margin-bottom: 10px;" >
        <tr>
          <td width="69" height="30" align="left" class="input_title">Arquivo:</td>
          <td height="30" align="left">
            <img src="<? echo SYS_SITE_CONTEUDO .'uploads/'. $row_assets[$i]['arquivo1'] ?>" style="max-width:200px" />
            <input name="cod_cont_assets[]" type="hidden" value="<?php echo $row_assets[$i]['cod_cont_assets'] ?>" />
          </td>
          <td width="136" rowspan="3" align="center" valign="bottom" bgcolor="#F7F7F7">
            <img src="assets/img/crop.png" width="16" height="16" align="absmiddle" />
            <a href="javascript:cropArquivoAssets('1', '<? echo $row_assets[$i]['cod_cont_assets'] ?>', '254', '201')">Definir imagem</a><br><br>
            
            <img src="assets/img/excluir.png" width="16" height="16" align="absmiddle" />
            <a href="javascript:void(excluirArquivoAssets('<?php echo $row_assets[$i]['cod_cont_assets'] ?>'))">Excluir registro</a><br><br>
          </td>
        </tr>
        <tr>
          <td height="30" align="left" class="input_title">T&iacute;tulo:</td>
          <td height="30" align="left"><input name="assets_lista_nome[]" type="text" value="<?php echo $row_assets[$i]['nome'] ?>" size="60" maxlength="100" /></td>
          </tr>
        <tr>
          <td width="69" height="30" align="left" class="input_title">Ordem:</td>
          <td height="30" align="left"><input name="assets_lista_ordem[]" type="text" value="<?php echo $row_assets[$i]['ordem'] ?>" size="5" maxlength="5"  /></td>
          </tr>
      </table>
      <br>
        <?php
        }
      }
      ?>
        
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" id="painel_subtitulo">
      <tr>
        <td>Inserir nova imagem</td>
      </tr>
    </table>
  
    <div id="lista_assets">
      <div id="item-0" class="item-list">
  
        <table width="770" border="0" align="center" cellpadding="2" cellspacing="0" style="border: #CCCCCC solid 1px; margin-top: 10px;">
          <tr>
            <td width="69" height="30" align="left" class="input_title">Arquivo:</td>
            <td height="30" align="left"><input name="assets_upload[]" type="file" size="50" /></td>
            <td width="61" align="center" bgcolor="#F7F7F7"></td>
            <td width="70" align="center" bgcolor="#F7F7F7"></td>
          </tr>
          <tr>
            <td width="69" height="30" align="left" class="input_title">T&iacute;tulo:</td>
            <td height="30" align="left"><input name="assets_nome[]" type="text" size="60" maxlength="100" /></td>
            <td align="center" bgcolor="#F7F7F7">&nbsp;</td>
            <td align="center" bgcolor="#F7F7F7">&nbsp;</td>
          </tr>
          <tr>
            <td width="69" height="30" align="left" class="input_title">Ordem:</td>
            <td height="30" align="left"><input name="assets_ordem[]" type="text" size="5" maxlength="5" /></td>
            <td align="center" bgcolor="#F7F7F7"><span id="item-excluir"><a><img src="assets/img/menos2.png" width="16" height="16" border="0" align="absmiddle" /> Retirar</a></span></td>
            <td align="center" bgcolor="#F7F7F7"><span id="item-adicionar"><a><img src="assets/img/mais2.png" width="16" height="16" border="0" align="absmiddle" /> Inserir</a></span></td>
          </tr>
        </table>
  
       </div >
    </div>
    
    <input type="hidden" name="assets_arquivos" value="1">
    <input type="hidden" name="assets_arquivo1_largura" value="254">
    <input type="hidden" name="assets_arquivo1_altura" value="212">
    <input type="hidden" name="assets_arquivo1_original_largura" value="1000">
    <input type="hidden" name="assets_arquivo1_original_altura" value="1000">
      
  </div>

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