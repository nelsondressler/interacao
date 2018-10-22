<?
require_once 'bootstrap.php';

if ($_GET["op"] == "Excluir") {
  unlink(SYS_CONTEUDO .'uploads_editor/'. $_GET["arq"]);
  header("Location: image_manager.php");
}

$diretorio = opendir(SYS_CONTEUDO .'uploads_editor/');
$tamanho   = 0;

while(($arquivos = readdir($diretorio)) !== false) {
  if($arquivos=="." or $arquivos=="..") continue; {
    $file[] = $arquivos;
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Inserir/Atualizar Imagens</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <style>
  table {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10px;
  }
  
  #lista {
    font-size: 10px;
    overflow: auto;
    height: 237px;
    width: 275px;
  }
  
  #preview {
    overflow: auto;
    width: 220px;
    height: 237px;
  }

  </style>
</head>

<body bgcolor=#ffffff leftmargin=0 topmargin=0 rightmargin=5 bottommargin=5 marginwidth="0" marginheight="0">
<table width="100%" border=0 cellpadding=0 cellspacing=1 bgcolor="#CCCCCC">
  <tr>
    <td width="220" height="237" align="center" bgcolor="#FFFFFF">
      <div id="preview"></div>
    </td>
    <td valign=top bgcolor="#FFFFFF">
      <div id="lista">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <?php
        if (count($file) > 0) {
          sort($file);
          
          foreach ($file as $arquivos) {
            
            if (substr( strtolower($arquivos), -3) == 'gif' || substr( strtolower($arquivos), -3) == 'jpg' || substr( strtolower($arquivos), -3) == 'jpeg' || substr( strtolower($arquivos), -3) == 'png') {
              
              $tamanho = filesize(SYS_CONTEUDO .'uploads_editor/'. $arquivos) / 1024;
              ?>
              <tr>
                <td width="20%" rowspan="2" onclick="selectImage('<?php echo SYS_SITE_CONTEUDO ."uploads_editor/". $arquivos ?>')">
                  <a href="javascript:selectImage('<?php echo SYS_SITE_CONTEUDO ."uploads_editor/". $arquivos ?>')">
                  <img src="<?php echo SYS_SITE_CONTEUDO .'uploads_editor/'. $arquivos ?>" width="50" border="0"></a>
                </td>
                <td width="80%">
                  <?php echo number_format($tamanho, 2, ",", ".") .'kb - '. $arquivos ?>
                </td>
              </tr>
              <tr>
                <td>
                  <a href="javascript:onclick=deleteImage('<?php echo $arquivos ?>')"><img src='excluir.png' border="0" align="absmiddle"> Excluir </a>                </td>
              </tr>
              <?php
            }
          }
        }
        ?>
        </table>
     </div>
    </td>
  </tr>
</table>
<script language="JavaScript">

function deleteImage(sURL) {
  if (confirm("Deseja realmente excluir a imagem '"+ sURL +"' ?") == true){
    this.location= 'image_manager.php?op=Excluir&arq='+ sURL;
  }
}
  
function selectImage(sURL) {
  parent.document.getElementById("txtUrl").value = sURL;
  document.getElementById('preview').innerHTML = "<img src='" + sURL + "'>";
}

if (parent.document.getElementById("txtUrl").value != '') {
  document.getElementById('preview').innerHTML = '<img src="'+  parent.document.getElementById("txtUrl").value +'">';
}
  
</script>
</body>
</html>