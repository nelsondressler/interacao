function adicionaElement(num, maximo) {
  
  contador ++;
  var principal = document.getElementById("lista_de_itens");
  var novo_nome = "lista_item_"+ contador;
  var div_novo  = document.createElement('div');
  div_novo.setAttribute("id", novo_nome);
  principal.appendChild(div_novo);
  
  var conteudo = document.getElementById(num).innerHTML;
  conteudo = conteudo.replace(/value=(.*?)\ /g,'');
  conteudo = conteudo.replace(/removeElement\((.*?)\)/g,'removeElement(\''+ novo_nome  +'\',\''+ maximo +'\')');
  conteudo = conteudo.replace(/adicionaElement\((.*?)\)/g,'adicionaElement(\''+ novo_nome  +'\',\''+ maximo +'\')');
  div_novo.innerHTML = conteudo;
  redefineLista(maximo);

}

function removeElement(num, maximo) {
  if (num) {
    var d = document.getElementById('lista_de_itens');
    d.removeChild( document.getElementById(num) );
    redefineLista(maximo);
  }
}

function redefineLista(maximo) {
  
  var contar_div = document.getElementById("lista_de_itens").getElementsByTagName("div");
  var spans;
  
  for (var i=0; i < contar_div.length; i++) {
    
    spans = contar_div[i].getElementsByTagName("span");
    span_display(spans, 'link_excluir', 'block');

      // Primeiro itens da lista
      if (i==0) {
        
        if (contar_div.length == 1) {
          span_display(spans, 'link_excluir', 'none');
          span_display(spans, 'link_adicionar', 'block');
          
        } else {
          span_display(spans, 'link_excluir', 'block');
          span_display(spans, 'link_adicionar', 'none');
        }
        
      // Último itens da lista
      } else if (i == (contar_div.length-1) ) {
        if (contar_div.length < maximo) {
          span_display(spans, 'link_adicionar', 'block');
        } else {
          span_display(spans, 'link_adicionar', 'none');
        }
      // Demais itens da lista
      } else {
        span_display(spans, 'link_adicionar', 'none');
      }
    
  }
  
}

function span_display(obj, str, op) {
  for (var a=0; a < obj.length; a++) {
    if (obj[a].id == str) {
      obj[a].style.display = op;
    }
  }
}