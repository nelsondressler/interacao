<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require 'bootstrap.php';
require 'assets/includes/login.php';

SystemLayout::setTitle('<img src="assets/img/ico_usuarios_b.gif" align="absmiddle" /> Usuários da administração');
SystemLayout::setModule('adm_usuarios');

SystemLayout::addNavigate('Usuários da administração');
SystemLayout::setBack('home.php');

if ( !SystemLayout::getPermissao(1) ) {
  header('location: semacesso.php');
  exit;
}

$usuarios = new AdministracaoUsuariosAction();

if ($_POST['acao'] == 'excluir') {
  
  if ( SystemLayout::getPermissao(4) ) {
    $usuarios->excluirLista($_POST['cod']);
  }
  
}
?>

<?php require 'assets/blocks/header_abre.php'; ?>
<?php require 'assets/blocks/header_fecha.php'; ?>
<?php require 'assets/blocks/body_abre.php'; ?>

<div id="painel_acoes">
  <?php
  if ( SystemLayout::getPermissao(2) ) {
    echo '<input type="button" onclick="redirect(\''. SystemLayout::getModule() .'_form.php\')" class="botao_add" value="Novo" />';
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
    <td> Nome </td>
    <td> Login </td>
    <td> E-mail </td>
    <td width="25" align="center">
      <?php
      if ( SystemLayout::getPermissao(4) ) {
        echo '<input type="checkbox" onclick="selecionarTodos(this,f)" name="checkbox" /> ';
      }
      ?>
   </td>
  </tr>
  
  <?php foreach($usuarios->lista() as $row) { ?>
  <tr>
    <td>
      
      <a href="<?php echo SystemLayout::getModule() ?>_form.php?cod=<? echo $row["cod_usuario"] ?>" class="input_title">
      <img src="assets/img/ver.png" align="absmiddle" border="0"/> Editar</a>
      
    </td>
    <td> <?php echo $row['nome'] ?> </td>
    <td> <?php echo $row['login'] ?> </td>
    <td> <?php echo $row['email'] ?> </td>
    <td align="center">
      <?php
      if ( SystemLayout::getPermissao(4) ) {
        if ($row['cod_usuario'] != 1) {
          echo '<input type="checkbox" name="cod[]" value="'. $row['cod_usuario'] .'" />';
        }
      }
      ?>
    </td>
  </tr>
  <?php } ?>
  <input type="hidden" name="acao" value="excluir">
  </form>
  
</table>

<script type="text/javascript">
var f = document.frm;
</script>

<?php require 'assets/blocks/body_fecha.php'; ?>