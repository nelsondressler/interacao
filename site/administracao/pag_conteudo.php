<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Teste');
SystemLayout::setModule('pag_conteudo');

SystemLayout::addNavigate('Teste');
SystemLayout::setBack('home.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$conteudo = new ConteudosAction();
$conteudo->setTipo('pag_conteudo');

if ($_REQUEST['acao'] == 'excluir') {
  
  if ( SystemLayout::getPermissao(4) ) {
    $conteudo->excluirConteudosSelecionados($_REQUEST['cod']);
  }
  
} else if ($_REQUEST['acao'] == 'alterar') {
  
  if ( SystemLayout::getPermissao(3) ) {
    $conteudo->alterarOrdem($_REQUEST);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<script type="text/javascript">
function alterar() {

  for (var i=0; i< $(f['cod[]']).length; i++) {
    $(f['cod[]'])[i].checked = true;
  }
  
  f.acao.value = 'alterar';
  f.submit();
}

$(function($){

  for (var i=0; i< $(f['ordem[]']).length; i++) {
    $($(f['ordem[]'])[i]).numeric();
  }
  
});
</script>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<div id="painel_acoes">
  <?php
  if ( SystemLayout::getPermissao(2) ) {
    echo '<input type="button" onclick="redirect(\''. SystemLayout::getModule() .'_form.php\')" class="botao_add" value="Novo" /> &nbsp;';
  }
  if ( SystemLayout::getPermissao(3) ) {
    echo '&nbsp;<input type="button" onclick="alterar()" class="botao_ok" value="Alterar ordem" />';
  }
  if ( SystemLayout::getPermissao(4) ) {
    echo '&nbsp;<input type="button" onclick="excluirSelecionados(f)" class="botao_del" value="Excluir selecionados" />';
  }
  ?>
</div>
<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  
  <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
  <tr class="table_grid_top">
    <td width="70">&nbsp;</td>
    <td width="50" align="center">Ordem</td>
    <td width="50" align="center">Publicar</td>
    <td width="50" align="center">Principal</td>
    <td>T&iacute;tulo</td>
    <td width="25" align="center">
      <?php
      if ( SystemLayout::getPermissao(4) ) {
        echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
      }
      ?>
    </td>
  </tr>
  
  <?php
  foreach($conteudo->lista() as $row) {
    ?>
    <tr>
      <td valign="top">
        
        <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_conteudo"] ?>" class="input_title">
        <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a></td>
      <td align="center" valign="top"><input name="ordem[]" value="<?php echo $row['ordem'] ?>" type="text" size="2" maxlength="2" /></td>
      <td align="center" valign="top"><input type="checkbox" name="set_status" onclick="checkboxAjax(this, '<?php echo $row["cod_conteudo"] ?>', 'set_status', '<?php echo $conteudo->getTipo() ?>')" <? echo Html::checked($row['status'], 1) ?> /></td>
      <td align="center" valign="top"><input type="radio" name="set_principal" onclick="checkboxAjax(this, '<?php echo $row["cod_conteudo"] ?>', 'set_principal', '<?php echo $conteudo->getTipo() ?>')" <? echo Html::checked($row['principal'], 1) ?> /></td>
      <td valign="top"><?php echo $row['nome'] ?></td>
      <td align="center" valign="top">
        <?php
        if ( SystemLayout::getPermissao(4) ) {
          echo '<input type="checkbox" name="cod[]" value="'. $row['cod_conteudo'] .'" />';
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

<script type="text/javascript">
var f = document.frm;
</script>

<?php require 'assets/blocks/body_fecha.php'; ?>