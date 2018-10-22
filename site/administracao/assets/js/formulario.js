function abreAlerta(msg) {
  
  alert(msg);
  return false;
  
}

function colocaFoco(obj) {
  
  if (obj) {
    obj.style.borderColor     = '#cc0000';
    obj.style.backgroundColor = '#FFF0f0';
    obj.focus();
  }
  
}

function retiraFoco(obj) {
  
  if (obj) {
    obj.style.borderColor     = '#666666';
    obj.style.backgroundColor = '#ffffff';
  }
  
}

function validaTexto(obj){
  
  var caracter = obj.value;
  if (caracter.length == 0){
    return true;
  }
  return false;
  
}

function validaOpcao(obj) {
  
  var resp = true;
  for(var ii=0; ii < obj.length; ii++){
    if(obj[ii].checked) resp = false;
  }
  if(resp){
    return true;
  }else{
    return false;
  }
  
}

function validaSelecao(obj) {
  
  if(obj.options[obj.selectedIndex].value == ""){
    return true;
  }
  return false;
  
}

function validaData(obj) {
  
  var numero  = $(obj).val();
  var partes  = numero.split("/");
  
  if (partes.length==3){
    numeros = partes[0] + partes[1] + partes[2]
    if (numeros.length ==0 ){
      return true;
    }
    if (partes[0] < 1 || partes[0] > 31){
      return true;
    }
    if (partes[1] < 1 || partes[1] > 12){
      return true;
    }
    if (partes[2].length < 4){
      return true;
    }
    if (partes[2] < 1900){
      return true;
    }
  }else{
    return true;
  }
  return false;
  
}

function validaEmail(obj) {
  
  var invalid = Array("~","!","@","#","$","%","^","&","*","(",")","+","=","[","]",":",";",",","\"","'","|","{","}","\\","/","<",">","?"," ","ç","á","à","ã","â","é","è","ê","í","ì","î","ó","ò","ô","õ","ú","ù","û");
  
  var xemail = obj.value;

    
  if (xemail.indexOf("@")==-1){
    return true;
  } else {
    var partes=xemail.split("@");
    if(partes[0] == '' || partes[0].length < 3){
      return true;
    }else{
      for(var ii=0; ii < invalid.length; ii++){
        if(partes[0].indexOf(invalid[ii])!=-1){
          return true;
        }
      }
    }
    
    if(partes[1]==""){
      return true;
    }else{
      if (partes[1].indexOf(".")==-1){
        return true;
      }else{
        ponto=partes[1].split(".")
        if(ponto[0]=="" || ponto[0].length < 2){
          return true;
        }else{
          for(ii=0;ii < invalid.length; ii++){
            if(ponto[0].indexOf(invalid[ii])!=-1){
              return true;
            }
          }
        }
        if(ponto[1]==""){
          return true;
        }
      }
    }
    
  }
  return false;
}

function validaValor(obj) {
  
  var valor   = obj.value;
  var reMoeda = /^\d{1,3}(\.\d{3})*\,\d{2}$/;
  
  if (reMoeda.test(valor)) {
   
    return false;
  } else if (valor != null && valor != "") {

    return true;
  }
  

  return false;
}


function validaCep(obj) {
  
  var validos = Array("0","1","2","3","4","5","6","7","8","9");
  var valor   = obj.value;
  var partes  = valor.split("-");
  var resp    = 0;
  
  if (partes.length ==2){
    var numeros = partes[0] + partes[1];
    if (numeros.length ==0 ){
      return true;
    }
    for(var ii=0; ii < validos.length; ii++){
      for(var jj=0; jj < numeros.length; jj++){
        if(numeros.substring(jj,jj+1) == validos[ii]) { resp++ }
      }
    }
    if (numeros.length != resp){
      return true;
    }
    if (partes[0].length != 5){
      return true;
    }
    if (partes[1].length != 3){
      return true;
    }
  }else{
    return true;
  }
  return false;
}


function validaNumero(obj) {
  
  var numero = obj.value;
  var resp   = 0;
  
  if(numero.length==0){
    return true;
  }
  
  for(var ii=0; ii < numero.length; ii++){
    for(var jj=0; jj < 11; jj++){
      if (numero.substring(ii,ii+1) == jj) resp++;
    }
  }
  
  if (numero.length != resp){
    return true;
  }
  
  return false;
  
}

function validaCpf(obj) {
  
  if (isCpf(obj.value))
    return false;
  else
    return true;
  
}

function validaCnpj(obj) {
  
  if (isCnpj(obj.value))
    return false;
  else
    return true;

}

function validaImagem(obj) {

  var file = $(obj).val();
  var exts = ['gif','png','jpg','jpeg'];

  if ( file ) {
    var get_ext = file.split('.');
    get_ext = get_ext.reverse();
    
    if ( $.inArray( get_ext[0].toLowerCase(), exts ) > -1 ){
      return false;
    } else {
      return true;
    }
  }
 
  
}

function verificaTamanho(target, contador, total) {
  
  var StrLen;
  var adicional;
  StrLen = 0;
  
  if (document.getElementById(target).value.length != "" ){
    StrLen = StrLen + document.getElementById(target).value.length;
  }
  if (StrLen == 1 && document.getElementById(target).value.substring(0,1) == " "){ 
    document.getElementById(target).value = "";
    StrLen = StrLen - 1;
  }
  if (StrLen > total){
    document.getElementById(target).value = document.getElementById(target).value.substring(0,total);
    StrLen = StrLen - 1;
  }
  
  document.getElementById(contador).value = total - StrLen;
 
}

function pegaEndereco(f) {
  
  if($.trim($('input[name=cep]').val()) != "") {
    
    $('#cep_carregando').show();
    
    $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$('input[name=cep]').val(), function(){
      if(resultadoCEP["resultado"] && resultadoCEP["bairro"] != ""){
        $('input[name=endereco]').val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
        $('input[name=bairro]').val(unescape(resultadoCEP["bairro"]));
        $('input[name=cidade]').val(unescape(resultadoCEP["cidade"]));
        //$('input[name=estado]').val(unescape(resultadoCEP["uf"]));
        
        if (f) {
          var estado = resultadoCEP["uf"];
          var i = 0;
          
          $("#estado option").each(function() {
            if (estado == $(this).val()) {
              f.estado.selectedIndex = i
            }
            i++;
          });
        }
        
        $('#cep_carregando').hide();
      }else{
        alert("Endereço não encontrado");
        return false;
      }
    });
    
  } else {
    alert('Antes, preencha o campo CEP!');
  }

}

function formataPreco(preco){
  
  var st = new String(parseFloat(preco));
  var ponto = st.lastIndexOf(".");
  
  if(ponto == -1){
    st += ".00";
    ponto = st.lastIndexOf(".");
  }
  
  var val = new String(st.substr(0, ponto));
  var dec = st.substr(ponto + 1, 2);
  
  if(dec < 10) dec = new String(parseInt(dec)+"0");
  var tam = val.length;
  var nst = new String();
  
  while(tam > 3){
    tam -= 3;
    nst = "." + val.substr(tam, 3) + nst;
  }
  
  if(tam > 0) {
    nst = val.substr(0, tam) + nst;
  }
  
  return nst + "," + dec;
}


function formataPrecoJs(preco){
  
  var val = preco;
  val = val.replace('.','');
  val = val.replace(',','.');
  return val
  
}