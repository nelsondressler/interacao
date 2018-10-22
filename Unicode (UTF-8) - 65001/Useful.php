<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class Useful
{
  
  public static function formatCnpj($str) {
    
     return self::mascara( str_pad(trim($str), 15, '0', STR_PAD_LEFT) , 'XXX.XXX.XXX/XXXX-XX');
    
  }
  
  public static function formatCpf($str) {
    
    return self::mascara( str_pad(trim($str), 11, '0', STR_PAD_LEFT) , 'XXX.XXX.XXX-XX');
    
  }
  
  private static function mascara($expr, $mask) {
    
    $ret = '';
    $j   = 0;
    
    for ($i = 0; $i < strlen($expr); $i++) {
      if ($mask[$j] != '9' and $mask[$j] != 'X') {
        $ret .= $mask[$j];
        $j++;
      }
      
      $ret .= $expr[$i];
      $j++;
    }
    
    return $ret;
  }
  
  
  public static function estadoIndiceJs($sigla) {
    
    $indice = 0;
    $values = array("AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG","PA","PB",
                    "PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO");
    
    for ($i = 0; $i < count($values); $i++) {
      if ($sigla == $values[$i]) {
        $indice = ($i+1);
      }
    }
    
    return $indice;
  }
  
  
  public static function listaEstados() {
    
    $values = array (
        array("nome"=>"Acre",               "sigla"=>"AC"),
        array("nome"=>"Alagoas",            "sigla"=>"AL"),
        array("nome"=>"Amapá",              "sigla"=>"AP"),
        array("nome"=>"Amazonas",           "sigla"=>"AM"),
        array("nome"=>"Bahia",              "sigla"=>"BA"),
        array("nome"=>"Ceará",              "sigla"=>"CE"),
        array("nome"=>"Distrito Federal",   "sigla"=>"DF"),
        array("nome"=>"Espírito Santo",     "sigla"=>"ES"),
        array("nome"=>"Goias",              "sigla"=>"GO"),
        array("nome"=>"Maranhão",           "sigla"=>"MA"),
        array("nome"=>"Mato Grosso",        "sigla"=>"MT"),
        array("nome"=>"Mato Grosso do Sul", "sigla"=>"MS"),
        array("nome"=>"Minas Gerais",       "sigla"=>"MG"),
        array("nome"=>"Pará",               "sigla"=>"PA"),
        array("nome"=>"Paraíba",            "sigla"=>"PB"),
        array("nome"=>"Paraná",             "sigla"=>"PR"),
        array("nome"=>"Pernambuco",         "sigla"=>"PE"),
        array("nome"=>"Piauí",              "sigla"=>"PI"),
        array("nome"=>"Rio de Janeiro",     "sigla"=>"RJ"),
        array("nome"=>"Rio Grande do Norte","sigla"=>"RN"),
        array("nome"=>"Rio Grande do Sul",  "sigla"=>"RS"),
        array("nome"=>"Rondônia",           "sigla"=>"RO"),
        array("nome"=>"Roraima",            "sigla"=>"RR"),
        array("nome"=>"Santa Catarina",     "sigla"=>"SC"),
        array("nome"=>"São Paulo",          "sigla"=>"SP"),
        array("nome"=>"Sergipe",            "sigla"=>"SE"),
        array("nome"=>"Tocantins",          "sigla"=>"TO")
      );
    
      return $values;
      
  }
  
  public static function selectEstados($name, $default = null, $class = null, $js = null) {
    
    if ($name) {
      
      $values = self::listaEstados();
      
      $class = ($class) ? ' class="'. $class .'" ' : '';
      $js    = ($js) ? ' onchange="'. $js .'" ' : '';
      
      $html = '<select name="'. $name .'" id="'. $name .'" '. $class . $js .'><option value="">...</option>';
      
      foreach ($values as $list) {
        
        $select = '';
        if ($list['sigla'] == $default) {
          $select = ' selected';
        }
        $html .='<option value="'. $list['sigla'] .'"'. $select .'>'. $list['nome'] ."</option>\n";
      }
      
      return $html ."</select>\n";
    }
    
  }
  
  
  public static function getExtensionString($str) {
    return substr(strrchr($str, '.'), 1);
  }
  
  
  public static function limpaString($str) {
    
    $str = trim($str);
    
    if ($str != '') {
      
      $str = str_replace(chr(34),'', $str);
      $str = str_replace(chr(39),'', $str);
      $str = str_replace(chr(92),'', $str);
      
    }
    
    return $str;
    
  }
  
  
  public static function limpaDocumento($str) {
    
    $str = trim($str);
    
    if ($str != '') {
      
      $str = str_replace('/','', $str);
      $str = str_replace('\\','', $str);
      $str = str_replace('.','', $str);
      $str = str_replace('_','', $str);
      $str = str_replace('-','', $str);
      
    }
    
    return $str;
    
  }
  
  
  public static function limpaLink($str) {
    
    $str = trim($str);
    
    if ($str != '') {
      
      $str = str_replace('http://','', $str);
      
    }
    
    return $str;
    
  }
  
  
  public static function convertRequestToHidden($excluir = null) {
    
    $campos  = "\n<!-- Inicio Request Hiddem -->\n";
    $request = array_merge($_POST, $_GET);
    
    foreach ($request as $v => $val) {
      
      $exibir = true;
      
      if ($excluir) {
        foreach ($excluir as $list) {
          if ($v == $list) $exibir = false;
        }
      }
      
      if ($v!='pg') {
        
        if (is_array($val)) {
          
          $i = 0;
          foreach ($val as $sub_val) {
            $campos .= '<input type="hidden" name="'. $v .'[]" value="'. $sub_val .'">'."\n";
            $i++;
          }
          
        } else {
          
          if ($exibir) {
            $campos .= '<input type="hidden" name="'. $v .'" value="'. $val .'">'."\n";
          }
          
        }
      }
    }
    
    $campos .= "<!-- Fim Request Hiddem -->\n";
    return $campos;
    
  }
  
  
  
  public static function convertRequestToLink() {
    
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
  
  
  public static function limpaUrlRewrite($str) {
    
    $str = trim($str);
    
    if ($str != '') {
      
      $str = str_replace(chr(34),'', $str);
      $str = str_replace(chr(39),'', $str);
      $str = str_replace(chr(92),'', $str);
      $str = str_replace('?','', $str);
      
    }
    
    return $str;
    
  }
  
  
  public static function requestRewrite() {
    
    $requesturi = explode('?', $_SERVER['REQUEST_URI']);
    $requesturi = $requesturi[0];
    
    $uri = substr($requesturi, 1, strlen($requesturi));
    $uri = str_replace(SYS_URLBASE, '', $requesturi); // comente esta linha quando for para o domínio
    
    if ($uri) {
      return explode('/', $uri);
    }
    
  }
  
  
  public static function convertNameToUrl($string) {

    $result = '';
    
    if ($string) {
  
      $result = strtolower($string);
      
      $c_acento = array('à','á','ã','â','é','ê','í','ó','õ','ô','ú','ü','ç','-');
      $s_acento = array('a','a','a','a','e','e','i','o','o','o','u','u','c','');
      
      for ($i=0; $i < count($c_acento); $i++) {
        $result = ereg_replace($c_acento[$i], $s_acento[$i], $result);
      }
      
      $result = ereg_replace('[^a-z0-9-]', '', ereg_replace(' +', '-', $result) );
      
    }
    
    return $result;
    
  }
  
  
  public static function hrefRewrite($string = null) {
    
    $return = str_replace('.php', '', $string);
    
    if ($string) {
      
      if (strpos($string, '?')) {
        
        $partes_url  = explode('?', $string);
        $partes_link = explode('&', $partes_url[1]);
        
        $partes_arquivo = explode('.', $partes_url[0]);
        $return         = $partes_arquivo[0];
        
        foreach ($partes_link as $lista) {
          $partes_valor = explode('=', $lista);
          $return .='/'.$partes_valor[1];
        }
        
      }
      
    }
    
    return SYS_HTTP . $return;
    
  }
  
  
  public static function exibeMaximoChr($string, $max) {
    
    if (strlen($string) > $max) {
      return substr($string, 0, $max) .'...';
    } else {
      return $string;
    }
  }
  
  
  public static function getMesNome($mes) {
    
    $mes = (integer) $mes;
    
    $array = array(
      array('nome'=>'Janeiro','sigla'=>'Jan'),
      array('nome'=>'Fevereiro','sigla'=>'Fev'),
      array('nome'=>'Março','sigla'=>'Mar'),
      array('nome'=>'Abril','sigla'=>'Abr'),
      array('nome'=>'Maio','sigla'=>'Mai'),
      array('nome'=>'Junho','sigla'=>'Jun'),
      array('nome'=>'Julho','sigla'=>'Jul'),
      array('nome'=>'Agosto','sigla'=>'Ago'),
      array('nome'=>'Setembro','sigla'=>'Set'),
      array('nome'=>'Outubro','sigla'=>'Out'),
      array('nome'=>'Novembro','sigla'=>'Nov'),
      array('nome'=>'Dezembro','sigla'=>'Dez')
    );
    return $array[ $mes-1 ];
    
  }
  
  
  public static function getEmbeddedPlayer($url, $height = 300, $width = 400) {
      
    $return = array();
    
    $youtubereplace = str_replace('feature=player_embedded&', '', $url);
    $youtubereplace = str_replace('&feature=player_embedded', '', $url);
    
    preg_match('/watch\?v=([a-zA-Z0-9\-_]+)/', $youtubereplace, $youtube);
    preg_match('/vimeo/', 'http://'. $url, $vimeo);
   
    if ($youtube) {

      $return['html'] = '<iframe name="iframevideo" id="iframevideo" width="'. $width .'" height="'. $height .'" src="http://www.youtube.com/embed/'. $youtube[1] .'?rel=0" frameborder="0" allowfullscreen></iframe>';
      $return['link'] = 'http://www.youtube.com/embed/'. $youtube[1] .'?rel=0';
      
    } else if ($vimeo) {

      preg_match('/^http:\/\/(www\.)?vimeo\.com\/(clip\:)?(\d+).*$/', 'http://'. $url, $vimeo);
      if (!$vimeo) {
        
        preg_match('/(\d+)/', $url, $vimeo);
        $id_vimeo = $vimeo[1];
        $return['link'] = 'http://player.vimeo.com/video/'. $id_vimeo;
        
      } else {
        
        $id_vimeo = $vimeo[3];
        $return['link'] = 'http://player.vimeo.com/video/'. $id_vimeo;
        
      }
      
      $return['html'] = '<iframe name="iframevideo" id="iframevideo" src="'. $return['link'] .'" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe>';
      
    } else {
      
      $return['html'] = '<iframe name="iframevideo" id="iframevideo" src="'. $url .'" width="'. $width .'" height="'. $height .'" frameborder="0"></iframe>';
      $return['link'] = $url;
    }
    
    return $return;
  }
  
  
  public static function fullUpper($str){
     // convert to entities
     $subject = htmlentities($str,ENT_QUOTES);
     $pattern = '/&([a-z])(uml|acute|circ';
     $pattern.= '|tilde|ring|elig|grave|slash|horn|cedil|th);/e';
     $replace = "'&'.strtoupper('\\1').'\\2'.';'";
     $result = preg_replace($pattern, $replace, $subject);
     // convert from entities back to characters
     $htmltable = get_html_translation_table(HTML_ENTITIES);
     foreach($htmltable as $key => $value) {
        $result = ereg_replace(addslashes($value),$key,$result);
     }
     return(strtoupper($result));
  }
  
  
  public static function statusCor($cod_status) {
    
    if ($cod_status==4) {
      return '069';
    } else if ($cod_status==5) {
      return 'C00';
    } else if ($cod_status==6) {
      return '0C0';
    }
    
    return '000';
    
  }
  
}
