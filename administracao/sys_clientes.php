<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Clientes');
SystemLayout::setModule('sys_clientes');

SystemLayout::addNavigate('Clientes');
SystemLayout::setBack('home.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$clientes = new ClientesAction();

if ($_REQUEST['acao'] == 'excluir') {
  
  if ( SystemLayout::getPermissao(4) ) {
    $clientes->excluirSelecionados($_REQUEST['cod']);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<div id="painel_acoes">
  <input type="button" onclick="redirect('sys_clientes_excel.php')" class="botao_excel" value="Exportar para Excel" />
  <?php
  if ( SystemLayout::getPermissao(2) ) {
    echo '<input type="button" onclick="redirect(\''. SystemLayout::getModule() .'_form.php\')" class="botao_add" value="Novo" /> &nbsp;';
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
   <td height="25" class="input_title">Nome:</td>
   <td width="200" height="25" class="input_title">CPF:</td>
   <td width="200" class="input_title">E-mail:</td>
   <td height="25" align="right">&nbsp;</td>
 </tr>
 <tr>
   <td height="25"><input name="nome" type="text" class="input_text" id="nome" value="<?php echo $_REQUEST['nome'] ?>" size="20" /></td>
   <td height="25">
     <input name="cpf" type="text" class="input_text" id="cpf" value="<?php echo $_REQUEST['cpf'] ?>" size="20" />
   </td>
   <td height="25">
     <input name="email" type="text" class="input_text" id="email" value="<?php echo $_REQUEST['email'] ?>" size="20" />
   </td>
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
    <td width="75">&nbsp;</td>
    <td width="200">Nome</td>
    <td width="110">CPF</td>
    <td>E-mail</td>
    <td width="25" align="center">
      <?php
      if ( SystemLayout::getPermissao(4) ) {
        echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
      }
      ?>
    </td>
  </tr>
  
  <?php
  foreach($clientes->listaPaginada($_REQUEST) as $row) {
    ?>
    <tr>
      <td valign="top">
        
        <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_cliente"] ?>" class="input_title">
        <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a>
          
       </td>
      <td valign="top">
      
        <a href="sys_clientes_planos.php?cod_cliente=<? echo $row["cod_cliente"] ?>" class="input_title">
        <img src="assets/img/package.png" align="absmiddle" border="0"/> Planos</a>
        
      </td>
      <td valign="top"><?php echo $row['nome'] ?></td>
      <td valign="top"><?php echo $row['cpf'] ?></td>
      <td valign="top"><?php echo $row['email'] ?></td>
      <td align="center" valign="top">
        <?php
        if ( SystemLayout::getPermissao(4) ) {
          echo '<input type="checkbox" name="cod[]" value="'. $row['cod_cliente'] .'" />';
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

<?php echo $clientes->pagination->render( SystemLayout::getModule() .'.php' ) ?>

<script type="text/javascript">
var f = document.frm;
</script>

<?php require 'assets/blocks/body_fecha.php'; ?>