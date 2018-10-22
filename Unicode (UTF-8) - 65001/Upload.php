<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
class Upload {
  
  
  public function save($upload, $folder = null) {
    
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
        $file = $this->clean($upload["name"] .'_'. uniqid()) .'.'. $ext;
        @copy($upload["tmp_name"], $folder . $file);
      }
      
    }
    
    return $file;
    
  }
  
  
  public function saveResize($width_max, $height_max, $upload, $folder = null) {
    
    $name = null;
    
    if ($upload["name"]) {
      
      $name = $this->save($upload, $folder);
      
      if ($name) {
        $image = new Image();
        $image->createFromFile($folder . $name);
        $image->fit_width($width_max);
        $image->fit_height($height_max);
        //$image->resize($width_max, $height_max);
        $image->save($folder . $name);
      }
      
    }
    
    return $name;
    
  }
  
  
  public function saveResizeCrop($width, $height, $upload, $folder = null) {
    
    $name = null;
    
    if ($upload["name"]) {
      
      $name = $this->save($upload, $folder);
      
      if ($name) {
        
        $image = new Image();
        $image->createFromFile($folder . $name);
        
        $info = $image->getInfos();
        
        $ratio = (($info['width'] / $info['height']) < ($width / $height)) ?  $width / $info['width'] : $height / $info['height'];
        $x     = max(0, round($info['width'] / 2 - ($width / 2) / $ratio));
        $y     = max(0, round($info['height'] / 2 - ($height / 2) / $ratio));
        
        $image->crop($x, $y, $width, $height, round($width / $ratio, 0), round($height / $ratio));
        $image->fit_width($width);
        $image->fit_height($height);
        
        $image->save($folder . $name);
      }
      
    }
    
    return $name;
    
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
  
}
?>