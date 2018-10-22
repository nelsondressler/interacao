<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />function checkboxAjax(obj, cod, acao, tipo, num, cat) {
  
  $('body').css('cursor', 'wait'); 
  
  if (obj.checked) {
    flag = 1;
  } else {
    flag = 0;
  }
  
  if (!cat) cat = '';
  
  $.ajax({
    data: 'acao='+ acao +'&cod='+ cod +'&flag='+ flag +'&tipo='+ tipo +'&num='+ num +'&cat='+ cat,
    success: function(resposta) {  $('body').css('cursor', 'default');  }
  });
  
}


function excluirSelecionados(frm) {
  
  msg = confirm("* ATENÇÃO *\n\nDeseja realmente excluir os registros selecionados?");
  if(msg) {
    frm.submit();
  }
  
}


function selecionarTodos(obj, frm) {
  
  for (var i=0; i< $(frm['cod[]']).length; i++) {
    $(frm['cod[]'])[i].checked = obj.checked;
  }
  
}


function redirect(page) {
  
  parent.location = page;
  
}


function enviaBusca(objName1, objName2, objName3) {
  
  var f = document.frm_busca;
  var tipo = '';
  var nome = '';
  
  for(i=0; i < f.elements.length; i++) {
    tipo = f.elements[i].type;
    nome = f.elements[i].name;
    if (tipo == 'text') {
      if (nome != objName1 && nome != objName2 && nome != objName3) 
        f.elements[i].value = '';
    } else if (tipo == 'select-one') {
      if (nome != objName1 && nome != objName2 && nome != objName3) 
        f.elements[i].selectedIndex = 0;
    }
  }
  f.submit();
  
}

function limparBusca() {
  
  var f = document.frm_busca;
  var tipo = '';
  var nome = '';
  
  for(i=0; i < f.elements.length; i++) {
    tipo = f.elements[i].type;
    nome = f.elements[i].name;
    if (tipo == 'text') {
      f.elements[i].value = '';
    } else if (tipo == 'select-one') {
      f.elements[i].selectedIndex = 0;
    }
  }
  f.submit();
  
}