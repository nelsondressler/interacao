<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Banner Rodapé');
SystemLayout::setModule('pag_banner_rodape');

SystemLayout::addNavigate(SystemLayout::getTitle(), SystemLayout::getModule() .'.php');
SystemLayout::addNavigate('Cadastro');
SystemLayout::setBack( SystemLayout::getModule() .'.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$conteudo = new ConteudosAction();
$editor   = new EditorHtml();

$conteudo->setTipo('pag_banner_rodape');
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

  if ($_REQUEST['acao'] == 'excluir_assets') {
    $conteudo->excluirAssets($_REQUEST['cod_assets']);
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
  
  modalProcessing('Aguarde ...');
  
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
  <br />
    
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
      <tr>
        <td width="70" height="30" class="input_title">T&iacute;tulo:</td>
        <td height="30"><input name="nome" type="text" class="requerido" value="<? echo $row['nome'] ?>" size="100" maxlength="200" /></td>
      </tr>
    </table>
    <br />
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
          <td width="136" rowspan="2" align="center" valign="bottom" bgcolor="#F7F7F7">
            <img src="assets/img/crop.png" width="16" height="16" align="absmiddle" />
            <a href="javascript:cropArquivoAssets('1', '<? echo $row_assets[$i]['cod_cont_assets'] ?>', '254', '201')">Definir imagem</a><br><br>
            
            <img src="assets/img/excluir.png" width="16" height="16" align="absmiddle" />
            <a href="javascript:void(excluirArquivoAssets('<?php echo $row_assets[$i]['cod_cont_assets'] ?>'))">Excluir registro</a><br><br>
          </td>
        </tr>
        <tr>
          <td width="69" height="30" align="left" class="input_title">Ordem:</td>
          <td height="30" align="left"><input name="assets_lista_ordem[]" type="text" value="<?php echo $row_assets[$i]['ordem'] ?>" size="5" maxlength="5"  /></td>
          </tr>
        <tr>
          <td height="30" align="left" class="input_title">Link:</td>
          <td height="30" align="left"><input name="assets_lista_link[]" type="text" value="<?php echo $row_assets[$i]['link'] ?>" size="90"  /></td>
          <td align="center" valign="bottom" bgcolor="#F7F7F7">&nbsp;</td>
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
            <td width="69" height="30" align="left" class="input_title">Ordem:</td>
            <td height="30" align="left"><input name="assets_ordem[]" type="text" size="5" maxlength="5" /></td>
            <td align="center" bgcolor="#F7F7F7"><span id="item-excluir"><a><img src="assets/img/menos2.png" width="16" height="16" border="0" align="absmiddle" /> Retirar</a></span></td>
            <td align="center" bgcolor="#F7F7F7"><span id="item-adicionar"><a><img src="assets/img/mais2.png" width="16" height="16" border="0" align="absmiddle" /> Inserir</a></span></td>
          </tr>
          <tr>
            <td height="30" align="left" class="input_title">Link:</td>
            <td height="30" align="left"><input name="assets_link[]" type="text" size="80" /></td>
            <td align="center" bgcolor="#F7F7F7">&nbsp;</td>
            <td align="center" bgcolor="#F7F7F7">&nbsp;</td>
          </tr>
        </table>
  
       </div >
    </div>
    
    <input type="hidden" name="assets_arquivos" value="1">
    <input type="hidden" name="assets_arquivo1_largura" value="160">
    <input type="hidden" name="assets_arquivo1_altura" value="110">
    <input type="hidden" name="assets_arquivo1_original_largura" value="1000">
    <input type="hidden" name="assets_arquivo1_original_altura" value="1000">


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
    <input type="hidden" name="ordem" value="'. $row['ordem'] .'">
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