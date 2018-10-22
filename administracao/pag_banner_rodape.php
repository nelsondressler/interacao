<?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('Banner Rodapé');
SystemLayout::setModule('pag_banner_rodape');

SystemLayout::addNavigate('Banner Rodapé');
SystemLayout::setBack('home.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$conteudo = new ConteudosAction();
$conteudo->setTipo('pag_banner_rodape');

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

<table width="783" border="0" cellpadding="0" cellspacing="0" class="table_grid">
  
  <form name="frm" action="<?php echo SystemLayout::getModule() ?>.php" method="post">
  <tr class="table_grid_top">
    <td width="70">&nbsp;</td>
    <td>T&iacute;tulo</td>
    <td width="25" align="center">
    </td>
  </tr>
  
  <?php
  foreach($conteudo->lista() as $row) {
    ?>
    <tr>
      <td valign="top">
        
        <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_conteudo"] ?>" class="input_title">
          <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a></td>
      <td valign="top"><?php echo $row['nome'] ?></td>
      <td align="center" valign="top">&nbsp;</td>
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