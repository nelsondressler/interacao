<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Planos e Períodos');
SystemLayout::setModule('sys_planos');

SystemLayout::addNavigate('Planos e Períodos');
SystemLayout::setBack('home.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$plano = new PlanosAction();

if ($_REQUEST['acao'] == 'excluir') {
  
  if ( SystemLayout::getPermissao(4) ) {
    $plano->excluirSelecionados($_REQUEST['cod']);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<div id="painel_acoes">
  <?php
  if ( SystemLayout::getPermissao(2) ) {
    echo '<input type="button" onclick="redirect(\''. SystemLayout::getModule() .'_form.php\')" class="botao_add" value="Novo" /> &nbsp;';
    echo '<input name="button" onclick="modalIframe(555, 300, \'Períodos\', \'sys_periodos.php\', \'no\')" type="submit" class="botao_calendario" value="Períodos" />';
  }
  if ( SystemLayout::getPermissao(4) ) {
    echo '&nbsp;<input type="button" onclick="excluirSelecionados(f)" class="botao_del" value="Excluir selecionados" />';
  }
  ?>
</div>

<div id="painel_geral">
<table width="100%" cellspacing="0" cellpadding="0">
<form name="frm_busca" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
 <tr>
   <td height="25" class="input_title">Plano:</td>
   <td width="200" height="25" class="input_title">Per&iacute;odos:</td>
   <td width="200" class="input_title">&nbsp;</td>
   <td height="25" align="right">&nbsp;</td>
 </tr>
 <tr>
   <td height="25"><input name="plano" type="text" class="input_text" id="plano" value="<?php echo $_REQUEST['plano'] ?>" size="20" /></td>
   <td height="25"><?php echo Html::select('cod_periodo', $plano->listaPeriodos(), 'periodo', 'cod_periodo', $_REQUEST['cod_periodo']) ?></td>
   <td height="25">&nbsp;</td>
   <td height="25" align="right"><input name="Button" type="button" class="botao_cancelar" value="Limpar" onclick="limparBusca()" />
     <input name="Submit" type="submit" class="botao_busca" value="Busca" /></td>
 </tr>
</form>
</table>
</div>

<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  
  <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
  <tr class="table_grid_top">
    <td width="70">&nbsp;</td>
    <td>Per&iacute;odo</td>
    <td>Plano</td>
    <td>Valor</td>
    <td width="25" align="center">
      <?php
      if ( SystemLayout::getPermissao(4) ) {
        echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
      }
      ?>
    </td>
  </tr>
  
  <?php
  foreach($plano->listaPaginada($_REQUEST) as $row) {
    ?>
    <tr>
      <td valign="top">
        
        <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_plano"] ?>" class="input_title">
        <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a>
          
       </td>
      <td valign="top"><?php echo $row['periodo'] ?></td>
      <td valign="top"><?php echo $row['plano'] ?></td>
      <td valign="top">R$ <?php echo Number::formatCurrencyBr($row['valor']) ?></td>
      <td align="center" valign="top">
        <?php
        if ( SystemLayout::getPermissao(4) ) {
          echo '<input type="checkbox" name="cod[]" value="'. $row['cod_plano'] .'" />';
        }
        ?>
      </td>
    </tr>
    <?php
  }
  ?>
  <input type="hidden" name="acao" value="excluir">
  </form>
</table>

<?php echo $plano->pagination->render( SystemLayout::getModule() .'.php' ) ?>

<script type="text/javascript">
var f = document.frm;

<?php
if ($plano->getReturnMensage()) {
  echo 'alert("'. $plano->getReturnMensage() .'");';
}
?>
</script>

<?php require 'assets/blocks/body_fecha.php'; ?>