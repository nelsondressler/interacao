<?php

class ConteudoHelper
{
  
  
  public static function getHtmlConteudoImagem($opcoes, $row) {
    
    $html = '';
    
    if ($row['arquivo'. $opcoes['numero']]) {
      
      $html .= '
      <img src="'. SYS_SITE_CONTEUDO .'uploads/'. $row['arquivo'. $opcoes['numero']] .'" style="max-width: 300px" /> <br /><br />
      
      <img src="assets/img/excluir.png" align="absmiddle" />
      <a href="javascript:void(excluirArquivo(\''. $opcoes['numero'] .'\'))">Excluir</a>';
     
     if ($opcoes['crop']) {
       $html .= '
        &nbsp; &nbsp;<img src="assets/img/crop.png" width="16" height="16" align="absmiddle" />
        <a href="javascript:cropArquivo(\''. $opcoes['numero'] .'\', \''. $opcoes['largura'] .'\', \''. $opcoes['altura'] .'\')">Definir imagem</a>';
     }
     
    } else {
      
      $html .= '
      <input name="arquivo'. $opcoes['numero'] .'" type="file" size="50" />
      <input name="arquivo'. $opcoes['numero'] .'_largura" value="'. $opcoes['largura'] .'" type="hidden" />
      <input name="arquivo'. $opcoes['numero'] .'_altura" value="'. $opcoes['altura'] .'" type="hidden" />
      <input name="arquivo'. $opcoes['numero'] .'_resize_crop" value="'. $opcoes['crop'] .'" type="hidden" />';
    
    }
    
    return $html;
    
  }
  
  
  public static function getHtmlPlanoImagem($opcoes, $row) {
    
    $html = '';
    
    if ($row['arquivo'. $opcoes['numero']]) {
      
      $html .= '
      <img src="'. SYS_SITE_CONTEUDO .'uploads/'. $row['arquivo'. $opcoes['numero']] .'" style="max-width: 300px" /> <br /><br />
      
      <img src="assets/img/excluir.png" align="absmiddle" />
      <a href="javascript:void(excluirArquivo(\''. $opcoes['numero'] .'\'))">Excluir</a>';
     
     if ($opcoes['crop']) {
       $html .= '
        &nbsp; &nbsp;<img src="assets/img/crop.png" width="16" height="16" align="absmiddle" />
        <a href="javascript:cropArquivo(\''. $opcoes['numero'] .'\', \''. $opcoes['largura'] .'\', \''. $opcoes['altura'] .'\')">Definir imagem</a>';
     }
     
    } else {
      
      $html .= '<input name="arquivo'. $opcoes['numero'] .'" type="file" size="50" />';
    
    }
    
    return $html;
    
  }
  
  
  public static function getHtmlConteudoArquivo($numero, $row) {
    
    $html = '';
    
    if ($row['arquivo'. $numero]) {
      
      $html .= '
      <img src="assets/img/a_20.png" width="16" height="16" border="0" align="absmiddle" />
      <a href="'. SYS_SITE_CONTEUDO .'uploads/'. $row['arquivo'. $numero] .'" target="_blank">Visualizar o arquivo</a>
      
      <img src="assets/img/excluir.png" align="absmiddle" />
      <a href="javascript:void(excluirArquivo(\''. $numero .'\'))">Excluir</a>';
      
    } else {
      
      $html .= '
      <input name="arquivo'. $numero .'" type="file" size="50" />';
    
    }
    
    return $html;
    
  }
  
}
