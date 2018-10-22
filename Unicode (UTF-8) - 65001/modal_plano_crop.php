<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?
require 'bootstrap.php';
require '../includes/login.php';

$plano = new PlanosModel();
$filesys  = new FileSystem();

$cod    = $_REQUEST['cod'];
$targ_w = $_REQUEST['targ_w'];
$targ_h = $_REQUEST['targ_h'];
$numero = $_REQUEST['numero'];
$ratio  = abs($targ_w/$targ_h);

$plano->selectOne('*', $plano->getPrimaryKeyName() .'='. $cod);
$row = $plano->getResults();

if ($_POST['acao'] == 'cortar') {

  $filesys->excluir(SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero]);
  
  $src       = SYS_CONTEUDO .'uploads/'. $row['arquivo'. $numero .'_original'];
  $ext       = strtolower(substr(strrchr($src, '.'), 1));
  $novo_nome = uniqid() .'.'. $ext;

  $image = new Image();
  $image->createFromFile($src);
  $image->crop($_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
  $image->save(SYS_CONTEUDO .'uploads/'. $novo_nome);
  $plano->update(array('arquivo'. $numero => $novo_nome), $plano->getPrimaryKeyName() .'='. $cod);
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" type="text/css" href="../css/layout.css"/>
<link rel="stylesheet" type="text/css" href="../css/html.css"/>

<script src="../js/Jcrop/js/jquery.min.js"></script>
<script src="../js/Jcrop/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" href="../js/Jcrop/css/jquery.Jcrop.css" type="text/css" />
 
<script language="Javascript">

$(function(){

  $('#cropbox').Jcrop({
    aspectRatio: <?php echo $ratio ?>,
    onSelect: updateCoords,
    boxWidth: 500,
    boxHeight: 450
  });

});

function updateCoords(c)
{
  $('#x').val(c.x);
  $('#y').val(c.y);
  $('#w').val(c.w);
  $('#h').val(c.h);
};

function checkCoords()
{
  if (parseInt($('#w').val())) return true;
  alert('Selecione a região na imagem.');
  return false;
};

</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


<?php if ($_POST['acao'] == 'cortar') { ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="425" align="center">
    <img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $novo_nome ?>" border="0" style="max-height: 400px; max-width: 400px"/>
      <br><br>
      <span class="input_title">A imagem foi cortada com sucesso!</span><br>
      <br>
    <a href="javascript:void(parent.$.modal.close())">Clique aqui para continuar</a>    </td>
  </tr>
</table>

<?php } else {?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="425" align="center"><img src="<?php echo SYS_SITE_CONTEUDO .'uploads/'. $row['arquivo'. $numero .'_original'] ?>" id="cropbox" /></td>
  </tr>
</table>

<form action="<?php echo System::thisFile() ?>" method="post" onSubmit="return checkCoords();" style="padding: 0px; margin:0px">
  
  <input type="hidden" id="x" name="x" />
  <input type="hidden" id="y" name="y" />
  <input type="hidden" id="w" name="w" />
  <input type="hidden" id="h" name="h" />
  <input type="hidden" name="acao" value="cortar" />
  <input type="hidden" name="cod" value="<?php echo $cod ?>" />
  <input type="hidden" name="targ_w" value="<?php echo $targ_w ?>" />
  <input type="hidden" name="targ_h" value="<?php echo $targ_h ?>" />
  <input type="hidden" name="numero" value="<?php echo $numero ?>" />
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ECF3F8">
    <tr>
      <td height="50" align="center"><input type="submit" class="botao" value=" Cortar imagem " /></td>
    </tr>
  </table>
  
</form>

<?php } ?>

</body>

</html>
