<?php
/**
 * dreamCode - Neodream Framework
 *
 * @copyright Copyright(c) 2005-2010 Neodream Web solution Ltda.
 * @link http://www.neodream.com
 * @author Fernando Rotermund
 * @license Todos os direitos reservados
 * @version v 2.5
 *
 */

class FileSystem
{
  
  public function le($caminho) {
    
    if (is_readable($caminho)) {
      
      $leitura = fopen($caminho, "r");
      $tamanho = filesize($caminho);
      
      if ($tamanho < 1) $tamanho = 1;
      
      $saida = fread ($leitura, $tamanho);
      fclose($leitura);
      return $saida;
      
    } else {
      
      //echo "O arquivo não pode ser lido: <br><b>". $caminho ."</b>";
      
    }
  }
  
  
  public function grava($caminho, $conteudo) {
    
    
    if ($caminho !='' ) {
      
      if(file_exists($caminho)) {
        if (is_file($caminho)) {
          $this->grava($caminho, $conteudo);
        }
      } else {
        $this->cria($caminho, $conteudo);
      }
      
    }
   
  }

  
  public function altera($caminho, $conteudo) {
    
    if ($conteudo) {
      if (is_writable($caminho)) {
        
        if (!$gravacao = fopen($caminho, 'w')) {
          echo "Houve um erro ao abrir o arquivo: <br><b>". $caminho ."</b>";
          return false;
          
        }
        
        if (!fwrite($gravacao, stripslashes($conteudo) )) {
          echo "Houve um erro ao configurar o arquivo: <br><b>". $caminho ."</b>";
          return false;
          
        }
        
        return true;
        fclose($gravacao);
        
      } else {
        echo "O arquivo não pode ser gravado: <br><b>". $caminho ."</b>";
        return false;
        
      }
    }
  }
  
  
  
  public function cria($caminho, $conteudo = null) {
    
    if (!$conteudo) {
      $conteudo = 'erro';
    }
    
    if (!$criacao = fopen($caminho, 'x+')) {
      echo "Houve um erro ao criar o arquivo.";
      return false;
      
    }
    
    if (!fwrite($criacao, stripslashes($conteudo) )) {
      echo "Houve um erro ao configurar o arquivo.";
      return false;
      
    }
    
    return true;
    fclose($criacao);
    
  }
  
  
  public function excluir($caminho) {
    
    if ($caminho !='' ) {
      if(file_exists($caminho)) {
        if (is_file($caminho)) {
          unlink($caminho);
        }
      }
    }
    
  }
  
  
  public function rename($caminho, $destino) {
    
    if ($caminho !='' ) {
      if(file_exists($caminho)) {
        if (is_file($caminho)) {
          rename($caminho, $destino);
        }
      }
    }
    
  }
  
  
  public function criaDiretorio($caminho) {
    
    mkdir($caminho, 0700);
    
  }
  
  
  public function excluiDiretorio($caminho) {
    
    //rmdir($caminho);
    /*$files = array_diff(scandir($caminho), array('.', '..'));
    foreach ($files as $file) {
      (is_dir($caminho .'/'. $file)) ? $this->excluiDiretorio($caminho .'/'. $file) : unlink($caminho .'/'. $file);
    }
    return rmdir($caminho);*/
    
    if (!file_exists($caminho)) return true;
    if (!is_dir($caminho) || is_link($caminho)) return unlink($caminho);
    
    foreach (scandir($caminho) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!$this->excluiDiretorio($caminho . "/" . $item)) {
            chmod($caminho . "/" . $item, 0777);
            if (!$this->excluiDiretorio($caminho . "/" . $item)) return false;
        };
    }
    
    return @rmdir($caminho);
    return @rmdir($caminho);
    
  }

  
}
?>