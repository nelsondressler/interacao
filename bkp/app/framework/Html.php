<?php

class Html
{
  
  public static function checked($data = '', $value = '', $default = false) {
    
    (string) $data;
    (string) $value;
    
    if (!is_null($data)) {
      if ($value == $data) {
        return 'checked';
      }
    } else {
      if ($default) {
        return 'checked';
      }
    }
    
  }
  
  
  public static function select($name, $values, $value_name, $value_id, $default = null, $class = null, $js = null) {
    
    if ($name) {
      
      $class = ($class) ? ' class="'. $class .'" ' : '';
      $js    = ($js) ? ' onchange="'. $js .'" ' : '';
      
      $html = '<select name="'. $name .'" id="'. $name .'" '. $class . $js .'><option value="">...</option>';
      
      if ($values) {
        foreach ($values as $list) {
          
          $select = '';
          if ($list[$value_id] == $default) {
            $select = ' selected';
          }
          $html .='<option value="'. $list[$value_id] .'"'. $select .'>'. $list[$value_name] ."</option>\n";
        }
      }
      
      return $html ."</select>\n";
      
    }
    
  }
  
  
  public static function selectOption($values, $value_name, $value_id, $default = null) {
    

    $html = '<option value="">...</option>';
    
    if ($values) {
      foreach ($values as $list) {
        
        $select = '';
        if ($list[$value_id] == $default) {
          $select = ' selected';
        }
        $html .='<option value="'. $list[$value_id] .'"'. $select .'>'. $list[$value_name] ."</option>\n";
      }
    }
    
    return $html;

    
  }
  
  
  public static function img($path, $file, $width = null, $height = null, $id = null) {
    
    $width  = ($width)  ? ' width="'. $width .'" ' : '';
    $height = ($height) ? ' height="'. $height .'" ' : '';
    $id     = ($id)     ? ' id="'. $id .'" ' : '';
    
    if ($file) {
      return '<img src="'. $path . $file .'" '. $width . $height . $id .' border="0" />';
    } else {
      return '<img src="assets/img/sem_img.gif" '. $width . $height .' border="0" />';
    }
    
  }
  
}