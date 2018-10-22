<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Lista Contatos');
SystemLayout::setModule('frm_contato');

SystemLayout::addNavigate('Lista Contatos');
SystemLayout::setBack('home.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$contato = new ContatosAction();

if ($_POST['acao'] == 'excluir') {
  
  if ( SystemLayout::getPermissao(4) ) {
    $contato->excluirLista($_POST['cod']);
  }
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<style type="text/css">
.lojas {
  width: 250px
}
</style>

<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<div id="painel_acoes">
  <input type="button" onclick="redirect('frm_contato_excel.php')" class="botao" value="Exportação para Excel" />
  <input type="button" onclick="excluirSelecionados(f)" class="botao_del" value="Excluir selecionados" />
</div>

<div id="painel_geral">
<table width="100%" cellspacing="0" cellpadding="0">
<form name="frm_busca" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
 <tr>
   <td width="200" height="25" class="input_title">
     Nome:          </td>
   <td width="200" height="25" class="input_title">E-mail:</td>
   <td height="25" class="input_title">Data:</td>
   <td height="25" align="right">&nbsp;</td>
 </tr>
 <tr>
   <td height="25"><input name="nome" type="text" value="<?php echo $_REQUEST['nome'] ?>" class="input_text" size="30" /></td>
   <td height="25"><input name="email" type="text" id="email" value="<?php echo $_REQUEST['email'] ?>" size="30" /></td>
   <td height="25"><input name="data_contato1" type="text" value="<?php echo $_REQUEST['data_contato1'] ?>" size="9" maxlength="10" /> 
   a
   <input name="data_contato2" type="text" value="<?php echo $_REQUEST['data_contato2'] ?>" size="9" maxlength="10" /></td>
   <td height="25" align="right">
     <input name="Button" type="button" class="botao_cancelar" value="Limpar" onclick="limparBusca()" />
     <input name="Submit" type="submit" class="botao_busca" value="Busca" /></td>
 </tr>
</form>
</table>
</div>

<form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  <tr class="table_grid_top">
    <td width="70">&nbsp;</td>
    <td width="100">Data</td>
    <td width="250">Nome</td>
    <td>E-mail</td>
    <td width="25" align="center">
    <?php
      if ( SystemLayout::getPermissao(4) ) {
        echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
      }
      ?>
    </td>
  </tr>
  
  <?php foreach($contato->lista($_REQUEST) as $row) { ?>
  <tr>
    <td>
      
      <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_formulario"] ?>" class="input_title">
        <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a>
      
    </td>
    <td><?php echo Date::timestampToBr($row['data']) ?></td>
    <td><?php echo $row['nome'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td align="center">
     <?php
        if ( SystemLayout::getPermissao(4) ) {
          echo '<input type="checkbox" name="cod[]" value="'. $row['cod_formulario'] .'" />';
        }
        ?>
     </td>
  </tr>
  <?php } ?>
  <input type="hidden" name="acao" value="excluir">
</table>
</form>

<?php echo $contato->pagination->render( SystemLayout::getModule() .'.php' ) ?>

<script type="text/javascript">
var f = document.frm;

</script>

<?php require 'assets/blocks/body_fecha.php'; ?>