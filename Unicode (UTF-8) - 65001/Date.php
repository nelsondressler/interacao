<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class Date
{
  
  public static function brTotimestamp($data = null) {
    
    if ($data) {
      $partes = explode("/", $data);
      return $partes[2] ."-". $partes[1] ."-". $partes[0];
    } else {
      return 'null';
    }
    
  }
  
  
  public static function timestampToBr($data = null, $separador = '/') {
    
    $null = (integer) $data;
    
    if ($null) {
      return date("d". $separador ."m". $separador ."Y", strtotime($data));
    } else {
      return '';
    }
    
  }
  
  
  /*
   * Calcula a quantidade de dias entre 2 datas
   */
  public static function diff($data_fim, $data_inicio) {
    
    if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $data_fim, $sep)) {
      
      $dia_fim = $sep[1];
      $mes_fim = $sep[2];
      $ano_fim = $sep[3];
      
    } else {
      
      //echo "Formato Inválido de Data ". $data_fim;
      
    }
    
    if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $data_inicio, $sep)) {
      
      $dia_inicio = $sep[1];
      $mes_inicio = $sep[2];
      $ano_inicio = $sep[3];
      
    } else {
      
      //echo "Formato Inválido de Data ". $data_inicio;
      
    }
    
    $data1 = mktime(0, 0, 0, $mes_fim, $dia_fim, $ano_fim);
    $data2 = mktime(0, 0, 0, $mes_inicio, $dia_inicio, $ano_inicio);
    
    $dias = ($data1 - $data2) / 86400;
    
    return $dias;
    
  }
  
  
  /*
   * Calcula a quantidade de meses entre 2 datas
   */
  public static function diffMes($data_fim, $data_inicio) {
    
    if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $data_fim, $sep)) {
      
      $dia_fim = $sep[1];
      $mes_fim = $sep[2];
      $ano_fim = $sep[3];
      
    } else {
      
      //echo "Formato Inválido de Data ". $data_fim;
      
    }
    
    if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $data_inicio, $sep)) {
      
      $dia_inicio = $sep[1];
      $mes_inicio = $sep[2];
      $ano_inicio = $sep[3];
      
    } else {
      
      //echo "Formato Inválido de Data ". $data_inicio;
      
    }
    
    $a1 = ($ano_fim - $ano_inicio)*12;
    $m1 = ($mes_fim - $mes_inicio)+1;
    $meses = ($m1 + $a1);

    return $meses;
    
  }
  
  
  /*
   * Adiciona dias em uma data
   */
  public static function add($dias, $data) {
  
    if (ereg ("([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})", $data, $sep)) {
      
      $dia = $sep[1];
      $mes = $sep[2];
      $ano = $sep[3];
      
    } else {
      
      echo "Formato Inválido de Data ". $data;
      
    }
    
    $nova_data = mktime(0, 0, 0, $mes, $dia, $ano) + (86400 * $dias);
    
    return date("d/m/Y", $nova_data);
    
  }
  
}