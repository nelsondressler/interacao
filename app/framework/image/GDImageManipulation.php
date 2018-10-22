<?php

Class GDImageManipulation
{
    /*
     * Variable declarations
     */

    private $image_file         = ""; // Filename and path for disc-input
    private $image_object       = ""; // Input image object
    private $image_width        = ""; // Input image width
    private $image_height       = ""; // Input image height

    /*
     * Function declaration
     */

    public function set_image_asFile($filename)
    {
        $this->image_file = $filename;
        
        // Para imagens Png
        if ($this->get_extension()=='png') {
          
          $this->image_object = imagecreatefrompng($this->image_file);
          
        } else {
        
          $handle = fopen($filename, "r");
          $this->image_object = imagecreatefromstring(fread($handle, filesize($filename)));
          fclose($handle);
          
        }
        
        $this->image_width  = imagesx($this->image_object);
        $this->image_height = imagesy($this->image_object);
        
        //echo 'width: '. $this->image_width .'<br>height: '. $this->image_height;
        //exit;
        return true;
        
    } // function set_image_file

  
    public function set_image_asString($string)
    {
        $this->image_object = imagecreatefromstring($string);
        $this->image_width = imagesx($this->image_object);
        $this->image_height = imagesy($this->image_object);
        return true;
    } // function set_image_string


    public function set_image_asObject($object)
    {
        $this->image_object = $object;
        $this->image_width  = imagesx($this->image_object);
        $this->image_height = imagesy($this->image_object);
        return true;
        
    } // function set_image_string

    
    public function get_png()
    {
        if ($this->image_object)
        {
            return imagepng($this->image_object);
        } else {
        return false;
        }
    } // function get_png


    public function get_gd2()
    {
        if ($this->image_object)
        {
            return imagegd2($this->image_object);
        } else {
        return false;
        }
    } // function get_gd2


    public function get_gd()
    {
        if ($this->image_object)
        {
            return imagegd($this->image_object);
        } else {
        return false;
        }
    } // function get_gd


    public function get_gif()
    {
        if ($this->image_object)
        {
            return imagegif($this->image_object);
        } else {
        return false;
        }
    } // function get_gif


    public function get_jpeg()
    {
        if ($this->image_object)
        {
            return imagejpeg($this->image_object);
        } else {
        return false;
        }
    } // function get_jpg


    public function get_inlineTag_png($alt)
    {
        if ($this->image_object)
        {
            ob_start();
            imagepng($this->image_object);
            $raw = ob_get_clean();
            ob_end_clean();
            $data = chunk_split(base64_encode($raw));
            //$data = str_replace(array('+','/','='),array('-','_',),$data);
            $tag  = '<img src="data:image/png;base64,'.$data.'"';
            $tag .= ' width="'.imagesx($this->image_object).'"';
            $tag .= ' height="'.imagesy($this->image_object).'"';
            $tag .= ' alt="'.$alt.'" />';
            
            return $tag;
        } else {
        return false;
        }
    }


    public function get_inlineTag_gif($alt)
    {
        if ($this->image_object)
        {
            ob_start();
            imagegif($this->image_object);
            $raw = ob_get_clean();
            ob_end_clean();
            $data = chunk_split(base64_encode($raw));
            //$data = str_replace(array('+','/','='),array('-','_',),$data);
            $tag  = '<img src="data:image/gif;base64,'.$data.'"';
            $tag .= ' width="'.imagesx($this->image_object).'"';
            $tag .= ' height="'.imagesy($this->image_object).'"';
            $tag .= ' alt="'.$alt.'" />';
            
            return $tag;
        } else {
        return false;
        }
    }

    public function get_inlineTag_jpeg($alt)
    {
        if ($this->image_object)
        {
            ob_start();
            imagejpeg($this->image_object);
            $raw = ob_get_clean();
            ob_end_clean();
            $data = chunk_split(base64_encode($raw));
            //$data = str_replace(array('+','/','='),array('-','_',),$data);
            $tag  = '<img src="data:image/jpeg;base64,'.$data.'"';
            $tag .= ' width="'.imagesx($this->image_object).'"';
            $tag .= ' height="'.imagesy($this->image_object).'"';
            $tag .= ' alt="'.$alt.'" />';
            
            return $tag;
            
        } else {
          return false;
        }
    }

    public function fit_width($width, $enlarge)
    {
        if ( $this->image_width > $width or ($enlarge and $this->image_width < $width))
        {
            $nwidth = $width;
            $nheight = intval(($width / $this->image_width) * $this->image_height);
            
            if ($this->get_extension()=='png') {
              
              if ( imageistruecolor($this->image_object) ) {
                
                  $scaledImage = ImageCreateTrueColor($nwidth, $nheight);
                  imagealphablending($scaledImage, false);
                  imagesavealpha($scaledImage, true);
                  
              } else {
                
                $scaledImage = imagecreate($nwidth, $nheight);
                imagealphablending($scaledImage, false );
                $transparent = imagecolorallocatealpha($scaledImage, 0, 0, 0, 127 );
                
                imagefill($scaledImage, 0, 0, $transparent );
                imagesavealpha($scaledImage, true );
                imagealphablending($scaledImage, true );
    
              }
              
            } else {
            
              $scaledImage = ImageCreateTrueColor($nwidth, $nheight);
              
            }
            
            ImageCopyResampled($scaledImage, $this->image_object, 0, 0, 0, 0, $nwidth, $nheight, $this->image_width, $this->image_height);
            $this->set_image_asObject($scaledImage);
            
        }
        
        return true;
        
    } // function fit_width


    public function fit_height($height, $enlarge)
    {
        if ( $this->image_height > $height or ($enlarge and $this->image_height < $height))
        {
            $nheight = $height;
            $nwidth = intval(($height / $this->image_height) * $this->image_width);
            
            if ($this->get_extension()=='png') {
              
              if ( imageistruecolor($this->image_object) ) {
                
                  $scaledImage = ImageCreateTrueColor($nwidth, $nheight);
                  imagealphablending($scaledImage, false);
                  imagesavealpha($scaledImage, true);
                  
              } else {
                
                $scaledImage = imagecreate($nwidth, $nheight);
                imagealphablending($scaledImage, false );
                $transparent = imagecolorallocatealpha($scaledImage, 0, 0, 0, 127 );
                
                imagefill($scaledImage, 0, 0, $transparent );
                imagesavealpha($scaledImage, true );
                imagealphablending($scaledImage, true );
    
              }
              
            } else {
              
              $scaledImage = ImageCreateTrueColor($nwidth, $nheight);
              
            }
            
            ImageCopyResampled($scaledImage, $this->image_object, 0, 0, 0, 0, $nwidth, $nheight, $this->image_width, $this->image_height);
            $this->set_image_asObject($scaledImage);
            
        }
        return true;
        
    } // function fit_height


    public function resize($factor)
    {
        $nheight = intval($this->image_height * $factor);
        $nwidth  = intval($this->image_width * $factor);
        $scaledImage = ImageCreateTrueColor($nwidth, $nheight);
        ImageCopyResampled($scaledImage, $this->image_object, 0, 0, 0, 0,
                           $nwidth, $nheight, $this->image_width, $this->image_height);
        $this->set_image_asObject($scaledImage);
        return true;
    } // function resize


    public function cropSquare($size)
    {
      $src_width  = intval($this->image_width);
      $src_height = intval($this->image_height);
      
      $src_w = $src_width;
      $src_h = $src_height;
      $src_x = 0;
      $src_y = 0;
      
      $dst_w = $size;
      $dst_h = $size;
        
      if($src_width > $src_height) {
        
        $src_x = ceil(($src_width - $src_height)/2);
        $src_w=$src_height;
        $src_h=$src_height;
        
      } else {
        
        $src_y = ceil(($src_height - $src_width)/2);
        $src_w = $src_width;
        $src_h = $src_width;
        
      }
        
      $dst_im = ImageCreateTrueColor($dst_w, $dst_h);
      
      ImageCopyResampled($dst_im, $this->image_object, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
      
      $this->set_image_asObject($dst_im);
      return true;
        
    } // function crop square
    
    
    public function flip_vertical()
    {
        $dest = imagecreatetruecolor(imagesx($this->image_object), imagesy($this->image_object));
        ImageCopyResampled($dest, $this->image_object, 0, 0, 0,
                            (imagesy($dest)-1), imagesx($dest), imagesy($dest), imagesx($dest),
                            (0-imagesy($dest)));
        $this->set_image_asObject($dest);
        return true;
    }


    public function flip_horizontal()
    {
        $dest = imagecreatetruecolor(imagesx($this->image_object), imagesy($this->image_object));
        ImageCopyResampled($dest, $this->image_object, 0, 0,
                            (imagesx($dest)-1), 0, imagesx($dest),
                            imagesy($dest), (0-imagesx($dest)), imagesy($dest));
        $this->set_image_asObject($dest);
        return true;
    }


    public function rotate($angle, $r=255, $g=255, $b=255, $ignore_transparent=-1)
    {
        if ($this->image_object) {
            $bgcolor = imagecolorallocate($this->image_object, $r, $g, $b);
            $this->image_object = imagerotate($this->image_object, $angle, $bgcolor, $ignoretransparent);
            $bgcolor = imagecolorallocate($this->image_object, $r, $g, $b);
            return true;
        } else {
            return false;
        }
    
    }


    public function convert_sepia($dither = true)
    {
        // Credits: derek at idreams dot co dot uk
        // Source: http://de.php.net/manual/en/function.imagecolorsforindex.php#79511

        if (!($t = imagecolorstotal($this->image_object))) {
            $t = 256;
            imagetruecolortopalette($this->image_object, $dither, $t);
        }

        $total = imagecolorstotal( $this->image_object );

        for ( $i = 0; $i < $total; $i++ ) {
            $index = imagecolorsforindex( $this->image_object, $i );
                $red = ( $index["red"] * 0.393 + $index["green"] * 0.769 + $index["blue"] * 0.189 );
                $green = ( $index["red"] * 0.349 + $index["green"] * 0.686 + $index["blue"] * 0.168 );
                $blue = ( $index["red"] * 0.272 + $index["green"] * 0.534 + $index["blue"] * 0.131 );

        if ($red > 255) { $red = 255; }
        if ($green > 255) { $green = 255; }
        if ($blue > 255) { $blue = 255; }
        imagecolorset( $this->image_object, $i, $red, $green, $blue );
        }
    }


    public function convert_colorize($tint_r=0, $tint_g=0, $tint_b=0, $tint_alpha=0)
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_COLORIZE, $tint_r, $tint_g, $tint_b);
            return true;
        } else {
            return false;
        }
    }


    public function convert_negate()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_NEGATE);
            return true;
        } else {
            return false;
        }
    }

    public function convert_grayscale()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_GRAYSCALE);
            return true;
        } else {
            return false;
        }
    }


    public function convert_brightness($level)
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_BRIGHTNESS, $level);
            return true;
        } else {
            return false;
        }
    }


    public function convert_contrast($level)
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_CONTRAST, $level);
            return true;
        } else {
            return false;
        }
    }


    public function convert_edgedetect()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_EDGEDETECT);
            return true;
        } else {
            return false;
        }
    }


    public function convert_emboss()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_EMBOSS);
            return true;
        } else {
            return false;
        }
    }

    public function convert_gaussian_blur()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_GAUSSIAN_BLUR);
            return true;
        } else {
            return false;
        }
    }

    public function convert_selective_blur()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_SELECTIVE_BLUR);
            return true;
        } else {
            return false;
        }
    }

    public function convert_mean_removal()
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_MEAN_REMOVAL);
            return true;
        } else {
            return false;
        }
    }

    public function convert_smooth($level)
    {
        if ($this->image_object) {
            imagefilter ($this->image_object, IMG_FILTER_SMOOTH, $level);
            return true;
        } else {
            return false;
        }
    }


    public function save_png($filename, $overwrite)
    {
        if (!$overwrite and file_exists($filename)) {
            return false;
        }

        if ($this->image_object) {
            
            if ( imageistruecolor($this->image_object) ) {
                
                //echo '1';
                $img = ImageCreateTrueColor($this->image_width, $this->image_height);
                imagealphablending($img, false);
                imagesavealpha($img, true);
                
            } else {
              
              //echo '2';
              $img = imagecreate($this->image_width, $this->image_height);
              imagealphablending($img, false );
              $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127 );
              
              imagefill($img, 0, 0, $transparent );
              imagesavealpha($img, true );
              imagealphablending($img, true );
  
            }
            
            ImageCopyResampled($img, $this->image_object, 0, 0, 0, 0, $this->image_width, $this->image_height, $this->image_width, $this->image_height);
            $this->set_image_asObject($img);
            
            imagepng($this->image_object, $filename);
            return true;
            
        } else {
            return false;
        }
    }


    public function save_gd2($filename, $overwrite)
    {
        if (!$overwrite and file_exists($filename)) {
            return false;
        }

        if ($this->image_object) {
            imagegd2($this->image_object, $filename);
            return true;
        } else {
            return false;
        }
    }

    public function save_gd($filename, $overwrite)
    {
        if (!$overwrite and file_exists($filename)) {
            return false;
        }

        if ($this->image_object) {
            imagegd($this->image_object, $filename);
            return true;
        } else {
            return false;
        }
    }

    public function save_gif($filename, $overwrite)
    {
        if (!$overwrite and file_exists($filename)) {
            return false;
        }

        if ($this->image_object) {
            imagegif($this->image_object, $filename);
            return true;
        } else {
            return false;
        }
    }

    public function save_jpeg($filename, $overwrite)
    {
        if (!$overwrite and file_exists($filename)) {
            return false;
        }

        if ($this->image_object) {
            imagejpeg($this->image_object, $filename, 100);
            return true;
        } else {
            return false;
        }
    }

    
    public function RedimensionaPng($tmp, $name, $largura, $pasta) {
      
      $img = imagecreatefrompng($tmp);
      $x     = imagesx($img);
      $y      = imagesy($img);
      $altura = ($largura*$y) / $x;
      $nova = imagecreatetruecolor($largura, $altura);
      
      imagealphablending ($nova, true);
      $transparente = imagecolorallocatealpha ($nova, 0, 0, 0, 127);
      
      imagefill ($nova, 0, 0, $transparente);
      imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
      imagesavealpha($nova, true);
      imagepng($nova, "$pasta/$name");
      imagedestroy($img);
      imagedestroy($nova);
      return($name);
      
    }
    
    
    public function get_extension() {
      
      if ($this->image_file) {
        return strtolower( substr(strrchr($this->image_file, '.'), 1) );
      }
      
      return false;
      
    }
    
}
