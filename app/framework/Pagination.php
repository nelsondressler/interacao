<?php

class Pagination {
  
  private $pagina_atual;
  
  private $total;
  
  private $por_pagina;
  
  private $exibe_total;
  
  private $exibe_select;
  
  
  public function set($total, $rpp, $exibe_total = false, $exibe_select = false) {
    
    if ( $total ) {
      $this->total = $total;
    }
    
    if ($exibe_total) {
      $this->exibe_total = true;
    }
    
    if ($exibe_select) {
      $this->exibe_select = true;
    }
    
    $this->por_pagina = $rpp;
    
    if ($_REQUEST["pg"] != '') {
      $this->pagina_atual = $_REQUEST["pg"];
    } else {
      $this->pagina_atual = 0;
    }
    
  }
  

  public function getSQL() {
    
    return $this->por_pagina .' OFFSET '. ( $this->pagina_atual * $this->por_pagina);
    
  }

  public function getOffset() {
    
    return ( $this->pagina_atual * $this->por_pagina);
    
  }
  
  
  public function render( $url, $numeros = 5, $so_texto = false) {
    
    $numeros = ($numeros-1);
    
    if ($this->total) {
    
      $saida = '';
      
      if ( $this->total % $this->por_pagina == 0 ) {
        $paginas = intval($this->total / $this->por_pagina) -1;
      } else {
        $paginas = intval($this->total / $this->por_pagina);
      }
      
      if ( $this->total > 0 ) {
        $num_reg_inicial = ( $this->pagina_atual * $this->por_pagina ) + 1;
        
        if ( $this->pagina_atual <> $paginas ) {
          $num_reg_inicial = ($this->pagina_atual * $this->por_pagina) + $this->por_pagina;
        } else {
          $num_reg_inicial = $this->total;
        }
        
        if ( $this->pagina_atual <> 0 ) {
          $saida .= '<a href="'. $url .'?pg='. ($this->pagina_atual - 1) .'&'. $this->getLink() .'" xref="pg='. ($this->pagina_atual - 1) .'&'. $this->getLink() .'">Anterior</a> ';
        } else {
          $saida .= '<span class="desabilitado">Anterior</span> ';
        }
        
        if (!$so_texto) {
          
          for ($i = $this->pagina_atual - $numeros; $i < $this->pagina_atual; $i++) {
            if ($i >= 0) {
              $saida .= ' <a href="'. $url .'?pg='. $i .'&'. $this->getLink() .'" xref="pg='. $i .'&'. $this->getLink() .'" class="paglink">'. ($i + 1) .'</a> ';
            }
          }
  
          for ( $i = $this->pagina_atual; ($i <= $paginas && $i <= ($this->pagina_atual + $numeros)); $i++ ) {
            if ( $i == $this->pagina_atual ) {
              $saida .= ' <span class="paglink">'. ($i + 1) .'</span>  ';
            } else {
              $saida .= ' <a href="'. $url .'?pg='. $i .'&'. $this->getLink() .'" xref="pg='. $i .'&'. $this->getLink() .'" class="paglink">'. ($i + 1) .'</a> ';
            }
          }
          
        } else {
          
          $saida .=' Pág. '. $this->pagina_atual .' de '. $paginas .' ';
          
        }
        
        if ( $this->pagina_atual < $paginas ) {
          $saida .= ' <a href="'. $url .'?pg='. ($this->pagina_atual + 1) .'&'. $this->getLink() .'" xref="pg='. ($this->pagina_atual + 1) .'&'. $this->getLink() .'">Próximo</a> ';
        } else {
          $saida .= ' <span class="desabilitado">Próximo</span>';
        }
        
      }
      
      if ($this->exibe_total) {
        $total = '<b>'. $this->total .'</b> registros';
      }
      
      if ($this->exibe_select) {
        $saida .= "&nbsp; &nbsp; Páginas: <select name=\"select_paginacao\"
                   onchange=\"location='". $url ."?pg='+ this.value +'&". $this->getLink() ."'\">";
        
        for ($i=0; $i < ($paginas+1) ; $i++) {
          $selected = '';
          if ($i == $this->pagina_atual) {
            $selected = 'selected';
          }
          $saida .= '<option value="'. $i .'" '. $selected .'>'. ($i+1) .'</option>';
        }
        $saida .= '</select>';
      }
      
      if ($total) {
        $saida = '<div id="paginacao">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left">'. $saida .'</td>
                        <td align="right">'. $total .'</td>
                      </tr>
                    </table>
                  </div>';
      } else {
        $saida = '<div id="paginacao">'. $saida .'</div>';
      }
      
      return $saida;
    }
    
  }
  
  
  private function getLink() {
    
    $campos  = '';
    $request = array_merge($_POST, $_GET);
    
    foreach ($request as $v => $val) {
      if ($v!='pg') {
        if (is_array($val)) {
          $i = 0;
          foreach ($val as $sub_val) {
            $campos .= $v .'='. $sub_val .'&';
            $i++;
          }
          
        } else {
          $campos .= $v .'='. $val .'&';
        }
      }
    }
    
    return $campos;
    
  }
  
  

  
}
?>