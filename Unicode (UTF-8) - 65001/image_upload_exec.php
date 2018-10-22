<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require_once 'bootstrap.php';

$arquivo = $_FILES['arquivo'];

if($arquivo["name"] != "") {
  
  $ext = strtolower(substr(strrchr($arquivo["name"], '.'), 1));

  if($ext == 'gif' || $ext == 'jpg' || $ext == 'png') {
    $upload = new Upload();
    $upload->saveResize(2000, 2000, $arquivo, SYS_CONTEUDO .'uploads_editor/');
    
  }
  
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<script language="javascript" type="text/javascript">
<?
if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
  echo 'parent.frames["fra_manager"].location.href = parent.frames["fra_manager"].location.href;';
else
  echo 'parent.document.getElementById("fra_manager").src = parent.document.getElementById("fra_manager").src;';
?>
</script>
<body bgcolor="#F7F7F7" leftmargin="0" topmargin="0" rightmargin="5" bottommargin="5" marginwidth="0" marginheight="0">
  
  <p align="center">&nbsp;</p>
  <p align="center"><font size="2" face="Verdana">A imagem foi enviada com sucesso!</font></p>
  <p align="center"><font size="2" face="Verdana"><a href="image_upload.php">Clique aqui para voltar</a></font>.</p>
</body>
</html>
