<?php
class UploadFotos {
  
  
  public function save($upload, $folder = null, $thumb = false) {
    
    $file = null;
    
    if ($upload["name"]) {
      
      $ext  = $this->getExtensao($upload["name"]);
      
      if ($ext == 'jpeg' ||
          $ext == 'jpg' ||
          $ext == 'gif' ||
          $ext == 'bmp' ||
          $ext == 'png' ||
          $ext == 'pdf' ||
          $ext == 'txt' ||
          $ext == 'doc' ||
          $ext == 'docx' ||
          $ext == 'pps' ||
          $ext == 'ppsx' ||
          $ext == 'ppt' ||
          $ext == 'pptx' ||
          $ext == 'xls' ||
          $ext == 'xlsx'
        ) {
        
        $data = date('Y-m-d');
        
        if ($thumb) {
          
          $nome = $this->getNome($upload["name"]);
          $file['name'] = $nome .' Thumb '. $data .'.'. $ext ;
          $file['ref']  = '';
          
        } else {
          
          $nome = $this->getNome($upload["name"]);
          $file['name'] = $nome .' '. $data .'.'. $ext ;
          $file['ref']  = $upload["name"];
          
        }
        
        @copy($upload["tmp_name"], $folder . $file['name']);
        
      }
      
    }
    
    return $file;
    
  }
  
  
  public function saveImagem($width_max, $height_max, $upload, $folder = null) {
    
    $new_image = array();
    
    if ($upload["name"]) {
      
      $upload_save       = $this->save($upload, $folder);
      $new_image['name'] = $upload_save['name'];
      $new_image['ref']  = $upload_save['ref'];
      
      if ($new_image['name']) {
        $image = new Image();
        $image->createFromFile($folder . $new_image['name']);
        
        $info                = $image->getInfos();
        $new_image['width']  = $info['width'];
        $new_image['height'] = $info['height'];
        
        if ($info['width'] > $info['height']) {
          $image->fit_width($width_max);
          $image->fit_height($height_max);
        } else {
          $image->fit_width($height_max);
          $image->fit_height($width_max);
        }
        
        $image->save($folder . $new_image['name']);
        
      }
      
    }
    
    return $new_image;
    
  }
  
  
  public function saveThumb($width, $height, $upload, $folder = null) {
    
    $new_image = array();
    
    if ($upload["name"]) {
      
      $upload_save       = $this->save($upload, $folder, true);
      $new_image['name'] = $upload_save['name'];
      $new_image['ref']  = $upload_save['ref'];
      
      if ($new_image['name']) {
        
        $image = new Image();
        $image->createFromFile($folder . $new_image['name']);
        
        $info                = $image->getInfos();
        $new_image['width']  = $info['width'];
        $new_image['height'] = $info['height'];
        
        $ratio = (($info['width'] / $info['height']) < ($width / $height)) ?  $width / $info['width'] : $height / $info['height'];
        $x     = max(0, round($info['width'] / 2 - ($width / 2) / $ratio));
        $y     = max(0, round($info['height'] / 2 - ($height / 2) / $ratio));
        
        $image->crop($x, $y, $width, $height, round($width / $ratio, 0), round($height / $ratio));
        $image->fit_width($width);
        $image->fit_height($height);
        
        $image->save($folder . $new_image['name']);
      }
      
    }
    
    return $new_image;
    
  }
  
  
  private function clean($string) {
   
    $string = strtolower($string);
    
    $c_acento = array('à','á','ã','â','é','ê','í','ó','õ','ô','ú','ü','ç');
    $s_acento = array('a','a','a','a','e','e','i','o','o','o','u','u','c');
    
    for ($i=0; $i < count($c_acento); $i++) {
      $string = str_replace($c_acento[$i], $s_acento[$i], $string);
    }
      
    $string = str_replace(" ", "-", $string);
    $string = str_replace("jpg", "", $string);
    $string = str_replace("pdf", "", $string);
    $string = str_replace("doc", "", $string);
    $string = str_replace("gif", "", $string);
    $string = str_replace("_", "", $string);
    $string = str_replace("/", "", $string);
    $string = str_replace("\\", "", $string);
    $string = str_replace("\"", "", $string);
    $string = str_replace("\'", "", $string);
    $string = str_replace(".", "", $string);
    $string = str_replace("~", "", $string);
    
    return trim($string);
    
  }
  

  public static function normalizeArray($entry) {
    
    if(isset($entry['name']) && is_array($entry['name'])) {
      $files = array();
      foreach($entry['name'] as $k => $name) {
        $files[$k] = array(
          'name'     => $name,
          'tmp_name' => $entry['tmp_name'][$k],
          'size'     => $entry['size'][$k],
          'type'     => $entry['type'][$k],
          'error'    => $entry['error'][$k]
        );
      }
      return $files;
    }
    return $entry;
  }
  
  
  public function getExtensao($string) {
    
    $partes = explode('.', $string);
    return strtolower($partes[ count($partes)-1 ]);
    
  }
  
  
  public function getNome($string) {
    
    $ext   = $this->getExtensao($string);
    $total = strlen($ext);
    $total ++;
    return substr($string, 0, -$total);
    
  }
  
}
?>