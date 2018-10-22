/**
 * jQuery Simples Add Lista
 * Written by Fernando Rotermund
 * Date: 2012/07/12
 *
 * @author Fernando Rotermund
 * @version 1.2
 *
 **/

(function($) {

  $.fn.simplesAddLista = function(settings) {

    var config = {
      'maximo': 10,
      'callback': ''
    };
    
    if ( settings ){$.extend(config, settings);}
    
    var obj      = this;
    var obj_nome = this.attr('id');
    var contador = 0;
    
    function inicia() {
      
      var nome = '#'+ obj_nome +' #'+ primeiroId();
      
      $(nome +' #item-excluir a').attr('href', 'javascript:void(0)');
      $(nome +' #item-adicionar a').attr('href', 'javascript:void(0)');
      
      $(nome +' #item-excluir a').css({'display':'none','text-decoration':'none'});
      $(nome +' #item-adicionar a').css({'text-decoration':'none'});
      
      $(nome +' #item-excluir a').click(function() {
        removeElement(nome);
      });
      
      $(nome +' #item-adicionar a').click(function() {
        adicionaElement();
      });
      
      var itens = obj.children('.item-list');

      if (itens.length > 1) {
        contador = itens.length;
      }
      
      var nome_outros;
      
      itens.each(function(index) {
        
        nome_outros = '#'+ obj_nome +' #'+ $(this).attr('id');
        
        if (primeiroId() != $(this).attr('id')) {
          $(nome_outros +' #item-excluir a').click(function() {
            removeElement(nome_outros);
          });
          
          $(nome_outros +' #item-adicionar a').click(function() {
            adicionaElement();
          });
        }
        
      })
      
      redefineLista();
      
    }
    
    function primeiroId() {
      
      var itens = obj.children('.item-list');
      var count = itens.length;
      var i     = 0;
      var primeiro;
      
      if (count) {
        
        itens.each(function(index) {
          if (i==0){ 
            primeiro = $(this).attr('id');
          }
          i++;
        });
        
        return primeiro;
      }
      
    }
    
    function adicionaElement() {
      
      contador ++;
      var primeiro = obj.children('#'+ primeiroId());
      var nome     = 'item-'+ contador;
      var divn     = document.createElement('div');
      //alert(nome)
      
      divn.setAttribute('id', nome);
      divn.setAttribute('class', 'item-list');
      obj.append(divn);
      
      $('#'+ obj_nome +' #'+ nome).html( primeiro.html() );
      
      $('#'+ obj_nome +' #'+ nome +' #item-excluir a').css({'display':'inline'});
      $('#'+ obj_nome +' #'+ nome +' #item-excluir a').click(function() {
        removeElement(nome);
      });
      
      $('#'+ obj_nome +' #'+ nome +' #item-adicionar a').click(function() {
        adicionaElement();
      });
      
      redefineLista();
      clear(nome);
      
    };
    
    function removeElement(id) {
      if (id) {
        obj.children('#'+ id).remove();
        redefineLista();
      }
    };
    
    function redefineLista() {
      
      var itens = obj.children('.item-list');
      var total = itens.length;
      var i     = 0;
      var nome;
      
      itens.each(function(index) {
        
        nome = '#'+ obj_nome +' #'+ $(this).attr('id');
        $(nome +' #item-excluir a').css({'display':'inline'});
        
        // Primeiro itens da lista
        if (i==0) {
          
          if (total == 1) {
            $(nome +' #item-excluir a').css({'display':'none'});
            $(nome +' #item-adicionar a').css({'display':'inline'});
          } else {
            $(nome +' #item-excluir a').css({'display':'inline'});
            $(nome +' #item-adicionar a').css({'display':'none'});
          }
          
        // Último itens da lista
        } else if (i == (total-1) ) {
          if (total < config.maximo) {
            $(nome +' #item-adicionar a').css({'display':'inline'});
          } else {
            $(nome +' #item-adicionar a').css({'display':'none'});
          }
          
        // Demais itens da lista
        } else {
          $(nome +' #item-adicionar a').css({'display':'none'});
        }
        
        i++;
        
      });
      
      //if (config.callback) {
        eval(config.callback);
      //}
    }
    
    function clear(nome) {
      
      var itens_input    = $('#'+ obj_nome +' #'+ nome +' input');
      var itens_select   = $('#'+ obj_nome +' #'+ nome +' select');
      var itens_textarea = $('#'+ obj_nome +' #'+ nome +' textarea');
      var tipo           = '';
      
      itens_input.each(function(index) {
        
        tipo = $(this).attr('type');
        if (tipo == 'text') {
          $(this).attr('value', '');
        } else if (tipo == 'checkbox') {
          $(this).attr('checked', '');
        } else if (tipo == 'radio') {
          $(this).attr('checked', '');
        }
        
      });
      
      itens_select.each(function(index) {
        
        tipo = $(this).attr('type');
        if (tipo == 'select-one') {
          $(this).attr('selectedIndex', 0);
        }  
        
      });
      
      itens_textarea.each(function(index) {
        
        tipo = $(this).attr('type');
        if (tipo == 'textarea') {
          $(this).attr('value', '');
        }  
        
      });
      
    }
    
    inicia();
    
  };

})(jQuery);