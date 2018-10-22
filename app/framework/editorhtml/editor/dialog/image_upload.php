<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="generator" content="HTML Tidy for Windows (vers 14 February 2006), see www.w3.org" />
  <title>
    Inserir/Atualizar Imagens
  </title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body bgcolor="#F7F7F7" leftmargin="0" topmargin="0" rightmargin="5" bottommargin="5" marginwidth="0" marginheight="0">
  <div id="aquarde" style="position:absolute; left:99px; top:136px; z-index:1; visibility: hidden;">
    <table width="200" height="50" border="0" cellpadding="0" cellspacing="1" bgcolor="black">
      <tr>
        <td align="center" bgcolor="#FFFF99">
          <b>AGUARDE...</b>
        </td>
      </tr>
    </table>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td>
        
        <form action="image_upload_exec.php" name="frm_upload" enctype="multipart/form-data" method="post" onSubmit="return ValidarUpload(this)">
          <font size="2" face="Verdana">Enviar ao Servidor</font><br>
          <br />
          <input name="arquivo" type="file" id="arquivo" style="width: 100%" size="20" />
          <br>
          <br />
          <input name="envia" type="submit" value="Enviar ao servidor" />
        </form>
        
      </td>
    </tr>
  </table>
  
  <script language="javascript" type="text/javascript">
  //<![CDATA[
  function ValidarUpload(frm) {
    
    f    = document.frm_upload;
    nome = (f.arquivo.value).split("\\");
    
    if (nome.value == "") {
      return false;
    } else {
      valido = false
      // Verifica espaço//
      for (i= 0; i < nome[nome.length-1].length; i++) {
        if (nome[nome.length-1].substring(i,i+1)==" ") valido = true;
      }
      
      if (valido) {
        alert("Não são permitidos espaços no nome da imagem.");
        return false;
      }
      //Verifica a extesão //
      tam = (f.arquivo.value).length;
      ext = ((f.arquivo.value).substr(tam-4,4)).toUpperCase();
      
      if(ext != ".GIF" && ext != ".JPG" && ext != "JPEG" && ext != ".PNG"){
        alert("Para a imagem é somente aceitos os formatos .JPG, .GIF ou .PNG");
        return false;
      }
    }
    
    f.envia.disabled = true;
    document.getElementById("aquarde").style.visibility= "visible";
  }
  //]]>
  </script>
</body>
</html>
