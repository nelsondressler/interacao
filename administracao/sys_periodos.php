<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setModule('sys_periodos');

if ( !SystemLayout::getPermissao(1, 'sys_planos') ) {
  header('location: semacesso.php');
  exit;
}

$periodo = new PeriodosAction();

if ($_REQUEST['acao'] == 'excluir') {
  
  if ( SystemLayout::getPermissao(4, 'sys_planos') ) {
    $periodo->excluirSelecionados($_REQUEST['cod']);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<body>

<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td align="right">
  <?php
  if ( SystemLayout::getPermissao(2, 'sys_planos') ) {
    echo '<input type="button" onclick="location=\''. SystemLayout::getModule() .'_form.php\'" class="botao_add" value="Novo" /> &nbsp;';
  }
  if ( SystemLayout::getPermissao(4, 'sys_planos') ) {
    echo '&nbsp;<input type="button" onclick="excluirSelecionados(f)" class="botao_del" value="Excluir selecionados" />';
  }
  ?>
    </td>
  </tr>
</table>

<table width="550" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  
  <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
  <tr class="table_grid_top">
    <td width="70">&nbsp;</td>
    <td width="50">Vigente</td>
    <td width="200">Per&iacute;odo</td>
    <td>Data</td>
    <td width="25" align="center">
      <?php
      if ( SystemLayout::getPermissao(4, 'sys_planos') ) {
        echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
      }
      ?>
    </td>
  </tr>
  
  <?php
  foreach($periodo->listaPaginada($_REQUEST) as $row) {
    ?>
    <tr>
      <td valign="top">
        
        <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_periodo"] ?>" class="input_title">
        <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a>
        
      </td>
      <td><?php if ($row['vigente']) echo 'Sim'; ?></td>
      <td><?php echo $row['periodo'] ?></td>
      <td><?php echo Date::timestampToBr($row['data_inicio']) .' até '. Date::timestampToBr($row['data_fim'])?></td>
      <td align="center" valign="top">
        <?php
        if ( SystemLayout::getPermissao(4, 'sys_planos') ) {
          echo '<input type="checkbox" name="cod[]" value="'. $row['cod_periodo'] .'" />';
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

<?php echo $periodo->pagination->render( SystemLayout::getModule() .'.php' ) ?>

<script type="text/javascript">
var f = document.frm;

<?php
if ($periodo->getReturnMensage()) {
  echo 'alert("'. $periodo->getReturnMensage() .'");';
}
?>
</script>

</body>
</html>