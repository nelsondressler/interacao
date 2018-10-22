<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />/**
 * Setup do ajax para adm
 */ 
$.ajaxSetup({
  type: "POST",
  url: 'assets/includes/ajax.php'
});


/**
 * Janela modal com iFrame
 */
function modalIframe(largura, altura, title, src, scrolling, jsclose) {
  
  var iframeAltura = altura -27;
  var modaltop;
  
  if (!scrolling) {
    scrolling = 'auto';
  }
  
  modaltop  = '<div id="modaltop">';
  modaltop += '  <div id="modaltitle" style="width: '+ (largura-68)  +'px">'+ title +'</div>';
  modaltop += '  <div id="modalclose"><a href="#" class="simplemodal-close"><img src="assets/img/bt_fechar.png" border="0" /></a></div>';
  modaltop += '</div>';
  
  $.modal('<iframe src="'+ src +'" height="'+ iframeAltura +'" width="'+ largura +'" scrolling="'+ scrolling +'" frameborder="0" marginheight="4" marginwidth="4" vspace="0" hspace="0">', {
    closeHTML: modaltop,
    containerCss: {
      backgroundColor: "#ffffff",
      height: altura,
      width: largura,
      padding: 0
    },
    
    opacity: 40,
    overlayClose: true,
    
    onClose: function () {
      if (jsclose) {
        eval(jsclose);
      }
      this.close();
    },
  });
  
}


function modalClose() {
  $.modal.close();
}

function modalProcessing(msg) {
  
  var altura = 100;
  var tableAltura = altura-27;
  var largura = 250;
  var html;
  var title = 'Aguarde ...';
  var content = '<b>'+ msg +'</b>';
  
  //$('body').css({'overflow-x':'hidden','overflow-y':'hidden'});
  
  html  = '<div id="modaltop">';
  html += '  <div id="modaltitle" style="width: '+ (largura-68)  +'px">'+ title +'</div>';
  html += '</div>';
  html += '<div><table width="'+ largura +'" border="0" cellspacing="0" cellpadding="0">';
  html += '  <tr>';
  html += '    <td height="'+ tableAltura +'" align="center">'+ content +'</td>';
  html += '  </tr>';
  html += '</table></div>';

  $.modal(html, {
    containerCss: {
      backgroundColor: "#ffffff",
      height: altura,
      width: largura,
      padding: 0
    },
    opacity: 40
  });
}


function modal(largura, altura, title, content) {
  
  var tableAltura = altura -27;
  var html;
  
  html  = '<div id="modaltop">';
  html += '  <div id="modaltitle" style="width: '+ (largura-68)  +'px">'+ title +'</div>';
  html += '</div>';
  html += '<div><table width="'+ largura +'" border="0" cellspacing="0" cellpadding="0">';
  html += '  <tr>';
  html += '    <td height="'+ tableAltura +'" align="center">'+ content +'</td>';
  html += '  </tr>';
  html += '</table></div>';

  $.modal(html, {
    containerCss: {
      backgroundColor: "#ffffff",
      height: altura,
      width: largura,
      padding: 0
    },
    opacity: 40
  });
}


/*
function var_dump(obj) {
  if(typeof obj == "object") {
     return "Type: "+typeof(obj)+((obj.constructor) ? "\nConstructor: "+obj.constructor : "")+"\nValue: " + obj;
  } else {
     return "Type: "+typeof(obj)+"\nValue: "+obj;
  }
}

function jsonDispatch(values) {
  
  $.getJSON('actions/AjaxAction.php?'+ values, function(data) {    
    
    if(data) {
      if(data.msg) {
        alert(data.msg);
      }
      if(data.js) {
        eval(data.js);
      }
    }
    
  });
}
*/

/**
 * Retira espaços em branco do fim e do inicio de uma string 
 */
function trim(str, chars) {
  return ltrim(rtrim(str, chars), chars);
}


/**
 * Retira espaços em branco a esquerda de uma string 
 */
function ltrim(str, chars) {
  chars = chars || "\\s";
  return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}


/**
 * Retira espaços em branco a direira de uma string 
 */
function rtrim(str, chars) {
  chars = chars || "\\s";
  return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}