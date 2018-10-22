<?php

class PaginationUri {
  
  private $pagina_atual;
  
  private $total;
  
  private $por_pagina;
  
  
  public function set($total, $rpp) {
    
    if ( $total ) {
      $this->total = $total;
    }
    
    $this->por_pagina = $rpp;
    
    $requesturi = explode('?', $_SERVER['REQUEST_URI']);
    $requesturi = $requesturi[1];
    
    parse_str($requesturi, $output);
    $pagina = $output['pag'];
    
    if ($pagina) {
      $this->pagina_atual = $pagina;
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
  
  
  public function render($url, $numeros = 5) {
    
    $url     = SYS_HTTP . $url;
    $url     = rtrim(trim($url), '/');
    
    //echo $url;
    $numeros = ($numeros-1);
    
    if ($this->total) {
    
      $saida = '<ul>';
      
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
          $saida .= ' <li class="prev"><a href="'. $url .'?pag='. ($this->pagina_atual - 1) .'"> < </a></li> ';
        } else {
          $saida .= ' <li class="prev"><a> < </a></li> ';
        }
          
        for ($i = $this->pagina_atual - $numeros; $i < $this->pagina_atual; $i++) {
          if ($i >= 0) {
            $saida .= ' <li><a href="'. $url .'?pag='. $i .'">'. ($i + 1) .'</a></li> ';
          }
        }

        for ( $i = $this->pagina_atual; ($i <= $paginas && $i <= ($this->pagina_atual + $numeros)); $i++ ) {
          if ( $i == $this->pagina_atual ) {
            $saida .= ' <li><a class="ativo">'. ($i + 1) .'</a></li> ';
          } else {
            $saida .= ' <li><a href="'. $url .'?pag='. $i .'">'. ($i + 1) .'</a></li> ';
          }
        }
        
        if ( $this->pagina_atual < $paginas ) {
          $saida .= ' <li class="next"><a href="'. $url .'?pag='. ($this->pagina_atual + 1)  .'"> > </a></li> ';
        } else {
          $saida .= ' <li class="next"><a> > </a></li> ';
        }
        
      }

      $saida .= '</ul>';
      
      return $saida;
    }
    
  }

}
?>