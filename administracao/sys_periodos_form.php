<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setModule('sys_periodos');

if ( !SystemLayout::getPermissao(1, 'sys_planos') ) {
  header('location: semacesso.php');
  exit;
}

$periodo = new PeriodosAction();
$cod     = $_REQUEST['cod'];

// Inclui
if ($_POST['acao'] == 'incluir') {
  
  if ( SystemLayout::getPermissao(2, 'sys_planos') ) {
    $periodo->grava(true, array_merge($_POST, $_FILES));
  }
  
  
// Altera
} else if ($_POST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3, 'sys_planos') ) {
    $periodo->grava(false, array_merge($_POST, $_FILES));
  }
  
// Outros
} else {

  if ($cod) {
    $row = $periodo->exibe($cod);
    
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>


<script type="text/javascript">
function validaDados(f) {

  if(validaTexto(f.periodo)) {
    return abreAlerta("Digite o Nome do período.");
  }

  if(validaData(f.data_inicio)) {
    return abreAlerta("Digite a data Inicial.");
  }

  if(validaData(f.data_fim)) {
    return abreAlerta("Digite a data Final.");
  }
  
}

$(function($) {

  $('#data_inicio').mask("99/99/9999");
  $('#data_fim').mask("99/99/9999");
  
});
</script>

<?php require 'assets/blocks/header_fecha.php'; ?>
<body>

<?php
if ($periodo->getReturnMensage()) {
  
  echo '
  <table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
    <tr>
      <td height="150" align="center">'. $periodo->getReturnMensage() .'</td>
    </tr>
  </table>';
  
} else {
?>
<br>

<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td align="right"><input type="button" onClick="location='<?php echo SystemLayout::getModule() ?>.php'" class="botao_del" value="Cancelar" /></td>
  </tr>
</table>

<form action="<?php echo System::thisFile() ?>" method="post" onSubmit="return validaDados(this)" enctype="multipart/form-data">
  
  <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="table_form">
    <tr>
      <td height="30" class="input_title">Vigente:</td>
      <td height="30">
        <input name="vigente" type="radio" value="1" <? echo Html::checked($row['vigente'], 1) ?> class="checked" />
Sim&nbsp;&nbsp;&nbsp;
<input name="vigente" type="radio" value="0" <? echo Html::checked($row['vigente'], 0, true) ?> class="checked" />
N&atilde;o &nbsp;&nbsp;&nbsp;&nbsp;(Período que esta em execução atualmente)</td>
    </tr>
    <tr>
      <td width="80" height="30" class="input_title">Periodo: </td>
      <td height="30"><input name="periodo" type="text" class="requerido" id="periodo" value="<? echo $row['periodo'] ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr>
      <td height="30" class="input_title">Data Inicial:</td>
      <td height="30">
        <input name="data_inicio" type="text" class="requerido" id="data_inicio" value="<? echo Date::timestampToBr($row['data_inicio']) ?>" size="10" maxlength="10" />
      </td>
    </tr>
    <tr>
      <td height="30" class="input_title">Data final:</td>
      <td height="30">
        <input name="data_fim" type="text" class="requerido" id="data_fim" value="<? echo Date::timestampToBr($row['data_fim']) ?>" size="10" maxlength="10" />
      </td>
    </tr>
  </table>
  
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td align="center">
  <?php
  $acao = '';
    
  if ( SystemLayout::getPermissao(2, 'sys_planos') && !$cod) {
    $botao_submit = 'Incluir';
    $acao         = 'incluir';
  }
    
  if ( SystemLayout::getPermissao(3, 'sys_planos') && $cod) {
    $botao_submit = 'Alterar';
    $acao         = 'alterar';
  }
  
  if ($acao) {
    echo '
    <input name="button" type="submit" class="botao_submit" value="'. $botao_submit .'" />
    <input type="hidden" name="acao" value="'. $acao .'">
    <input type="hidden" name="cod" value="'. $cod .'">
    ';
  }
  ?>
    </td>
  </tr>
</table>

  
</form>
  
  <script type="text/javascript">
  var f = document.frm;
  </script>
  
  <?php
}
?>

</body>
</html>