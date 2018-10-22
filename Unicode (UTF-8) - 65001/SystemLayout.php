<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class SystemLayout {
  
  
  public static $navigate;
  
  public static $back;
  
  private static $module;
  
  private static $title;
  
  private static $subtitle;
  
  
  public static function setModule($mod) {
    self::$module = $mod;
  }
  
  public static function getModule() {
    return self::$module;
  }
  
  public static function addNavigate($name = null, $link =null) {
    
    if ($name && $link) {
      self::$navigate .= '<li><a href="'. $link .'">'. $name .'</a></li> ';
    } else if ($name && !$link) {
      self::$navigate .= '<li><a href="javascript:void(0)">'. $name .'</a></li> ';
    }
    
  }
  
  
  public static function renderNavigate() {
    echo self::$navigate;
  }
  
  
  public static function setBack($link = null) {
    
    if ( $link) {
      self::$back = '<li><a href="'. $link .'"><img src="assets/img/voltar.png" width="16" height="16" border="0" align="absmiddle" /> Voltar</a></li> ';
    } else {
      self::$back = '';
    }
    
  }
  
  
  public static function getBack() {
    echo self::$back;
  }
  
  
  public static function setTitle($tit) {
    self::$title    = $tit;
    self::$subtitle = '';
  }
  
  
  public static function getTitle() {
    return self::$title;
  }
  
  
  public static function setSubTitle($sub) {
    self::$subtitle = $sub;
  }
  
  
  public static function getSubTitle() {
    return self::$subtitle;
  }
  
  
  public static function msgBox($html) {
    return '
      <table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="200" align="center">'. $html .'</td>
        </tr>
      </table>
      <br />
    ';
  }
  
  
  public static function getPermissao($permissao, $modulo = null) {
    
    /*
    1 Visualizar
    2 Inserir
    3 Alterar
    4 Excluir
    */
    
    if (!$modulo) {
      $modulo = SystemLayout::getModule();
    }
    
    if ($modulo && $permissao) {
      
      if (is_array($_SESSION["login_permissoes"][$modulo])) {
        foreach ($_SESSION["login_permissoes"][$modulo] as $list) {
          if ($list == $permissao) {
            return true;
          }
        }
      }
    }
    
    return false;
    
  }
  
}