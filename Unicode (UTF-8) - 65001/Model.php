<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
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


require_once SYS_FRAMEWORK .'database/Transaction.php';

class Model
{

  /**
   * Nome da tabela
   * @var string
   */
  private $table;
  
  /**
   * Valor da última chave primaria inserida
   * @var integer
   */
  private $last_insert_key;
  
  /**
   * Resultados de uma consulta SQL
   * @var array
   */
  private $results = array();
  
  /**
   * Nome da chave primaria
   * @var integer
   */
  private $primary_key;
  
  /**
   * Nome da chave primaria
   * @var integer
   */
  private $foreign_key;
  
  /**
   * Ultimo SQL executado;
   * @var string
   */
  private $sql;
  
  
  /**
   * Contrutor da classe
   * @param string $table
   */
  public function __construct($table) {
    
    Transaction::Open();
    $this->table       = $table;
    $this->primary_key = Transaction::$db->primaryKeyName($this->table);
    
  }
  
  
  /**
   * Recupera último SQL executado
   */
  public function getSql () {
    return $this->sql;
  }
  
  
  /**
   * Recupera nome da chave primaria
   */
  public function getPrimaryKeyName() {
    
    return $this->primary_key;
    
  }
  
  
  /**
   * Recupera nome da chave estrangeira
   */
  /*
   public function getForeignKeyName() {
    
    return $this->foreign_key;
    
  }
  */
  
  
  /**
   * Resultado de uma pesquisa
   * @return array
   */
  public function getResults() {
    
    return $this->results;
    
  }
  
  
  /**
   * Recupera total de registros encontrados em um Select
   */
  public function getTotalRows() {
    
    return Transaction::$db->getTotalRows();
    
  }
  
  
  /**
   * Resultado de uma pesquisa
   * @return array
   */
  public function setResults($array) {
    
    return $this->results = $array;
    
  }
  
  
  /**
   * Resultado de uma pesquisa
   * @return array
   */
  public function getLastInsertKey() {
    
    return $this->last_insert_key;
    
  }
  
  
  /**
   * Executa qualquer instrução SQL
   * @param string $sql
   * @return getResults()
   */
  public function query($sql) {
    
    $this->sql = $sql;
    Transaction::$db->execute($sql);
    $this->results = Transaction::$db->getResults();
    
  }
  
  
  /**
   * Executa uma instrução SELECT, e retorna somente uma linha de resultado
   * @param string $colunas
   * @param array $filtro
   * @return getResults()
   */
  public function selectOne($fields = null, $where = null, $joins = null, $orderby = null) {
    
    if (!$fields) {
      
      return false;
      
    } else {
      
      $where   = ($where) ? ' WHERE '. $where : '';
      $orderby = ($orderby) ? ' ORDER BY '. $orderby : '';
      $sql   = 'SELECT '. $fields .' FROM '. $this->table .' '. $joins .' '. $where .' '. $orderby .' LIMIT 1';
      
      Transaction::$db->execute($sql);
      
      $this->sql = $sql;
      $this->results = Transaction::$db->getResults(0);
      
    }
    
  }
  
  
  /**
   * Executa uma instrução SELECT e retorna todas as linhas
   * @return getResults()
   * @param string $fields
   * @param string $where
   * @param string $orderby
   * @param string $limit
   * @param string $joins
   */
  public function selectAll($fields = null, $where = null, $orderby = null, $limit = null, $joins = null) {
    
    if (!$fields) {
      
      return false;
      
    } else {
    
      $where   = ($where)   ? ' WHERE '. $where : '';
      $orderby = ($orderby) ? ' ORDER BY '. $orderby : '';
      $limit   = ($limit)   ? ' LIMIT '. $limit : '';
      $sql     = 'SELECT '. $fields .' FROM '. $this->table .' '. $joins . $where . $orderby . $limit;
      
      Transaction::$db->execute($sql);
      
      $this->sql = $sql;
      $this->results = Transaction::$db->getResults();
      
    }
    
  }
  
  
  /**
   * Executa uma instrução INSERT
   * @param array $fields
   */
  public function insert($fields = null) {
    
    $sql_fields = '';
    $sql_values = '';
    
    if(!$fields) {
      
      return false;
      
    } else {
      
      foreach($fields as $key=>$value) {
        
        // Seta campos
        $sql_fields .= $key .',';
        
        // Seta valores
        //if ($value) {
          $valor = stripslashes($value);
          $valor = str_replace("'", '"', $valor);
          $valor = trim($valor);
        //}
        
        if (!is_null($valor)) {
          $sql_values .= "'". $valor ."', ";
        } else {
          $sql_values .= "NULL, ";
        }
        
      }
      
      $sql_fields = rtrim(trim($sql_fields), ', ');
      $sql_values = rtrim(trim($sql_values), ', ');
      
      Transaction::$db->execute(
        'INSERT INTO '. $this->table .' ('. $sql_fields .') VALUES ('. $sql_values .')'
      );
      
      Transaction::$db->execute('SELECT LAST_INSERT_ID() AS ultimo');
      $return = Transaction::$db->getResults(0);
      $this->last_insert_key = $return['ultimo'];
      
    }

  }
  
  
  /**
   * Executa uma instrução UPDATE
   * @param array $fields
   * @param string $where
   */
  public function update($fields = null, $where = null) {
    
    $sql_values = '';
    
    if(!$fields) {
      
      return false;
      
    } else {
      
      foreach($fields as $key=>$value) {
        
        // Seta campos e valores
        //if ($value) {
          $valor = stripslashes($value);
          $valor = str_replace("'", '"', $valor);
          $valor = trim($valor);
        //}
        
        if (!is_null($valor)) {
          $sql_values .= $key ."='". $valor ."', ";
        } else {
          $sql_values .= $key. "=NULL, ";
        }
        
      }
      
      $sql_values = rtrim(trim($sql_values), ', ');
      $where = ($where) ? ' WHERE '. $where : '';
      $sql   = 'UPDATE '. $this->table .' SET '. $sql_values .' '. $where;
      
      $this->sql = $sql;
      Transaction::$db->execute($sql);
      
    }

  }
  
  
  /**
   * Executa uma instrução DELETE
   * @param string $where
   */
  public function delete($where = null) {
    
    if(!$where) {
      
      return false;
      
    } else {
      
      Transaction::$db->execute(
        'DELETE FROM '. $this->table .' WHERE '. $where
      );
      
    }

  }
  
  
  /**
   * Troca ordem de um campo numerico.
   * Exemplo: Se temos os registros 1, 2, 3, 4 e é inserido mais um 2, o 2 atual vira 3 e o 3 vira 4
   * e assim por diante, ordenando os registros na ordem correta empurando os outros para cima ou
   * para baixo dependendo de seu valor.
   * @param string $field nome do campo foco
   * @param integer $id valor da chave primaria
   * @param string $filter filtro extra para o where
   * @return integer o valor correto para ser inserido
   */
  public function reorganize($field, $id = null, $filter = null) {
    
    $where      = '';
    $primarykey = $this->getPrimaryKeyName();
    
    if ($id) {
      $where = 'NOT '. $primarykey .'='. $id;
      
      // Recupera ordem atual antes do update
      $this->selectOne($field, $primarykey .'='. $id);
      $row      = $this->getResults();
      $anterior = $row[$field];
    }
    
    // Filtro para where
    if ($filter) {
      $filter = ' AND '. $filter;
    }
    
    // Seleciona todo a tabela ordenando pelo campo ordem
    $this->selectAll('*', $where . $filter, $field .' ASC');
    $row = $this->getResults();
    
    $ordenar = array();
    $i       = 0;
    
    // Nova ordem, incluindo o novo registro
    foreach($row as $list ) {
      
      if ($_POST[$field] < $anterior ) {
        $ordenar[$i][$field] = $list[$field]+1;
      } else {
        $ordenar[$i][$field] = $list[$field];
      }
      $ordenar[$i][$primarykey] = $list[$primarykey];
      $i++;
      
    }
    
    $ordenar[$i][$field]      = $_POST[$field];
    $ordenar[$i][$primarykey] = $id;
    
    // Ordena todos os registros (record sort)
    $hash = array();
    foreach($ordenar as $key => $record) {
      $hash[$record[$field].$key] = $record;
    }
    ksort($hash);
    $ordenar = array();
    foreach($hash as $record) {
      $ordenar[]= $record;
    }
    // fim
    
    //print_r($ordenar);
    
    for($i=0; $i< count($ordenar); $i++) {
      $ordenar[$i][$field] = $i+1;
    }
    
    //print_r($ordenar);
    
    // Update da ordem nova
    for($i=0; $i < count($ordenar); $i++) {
      
      if ($ordenar[$i][$primarykey]) {
        $this->update(
          array($field=>$ordenar[$i][$field]),
          $primarykey .'='. $ordenar[$i][$primarykey]
        );
      } else {
        $ordem = $ordenar[$i][$field];
      }
      
    }
    
    return $ordem;
    
  }

  
  public function getNameUrlRewrite($texto, $cod = null) {
    
    $texto = strip_tags(trim($texto));
    $texto = str_replace(array('á', 'à', 'â', 'ã', 'Á', 'À', 'Â', 'Ã'), 'a', $texto);
    $texto = str_replace(array('ó', 'ò', 'ô', 'õ', 'Ó', 'Ò', 'Ô', 'Õ'), 'o', $texto);
    $texto = str_replace(array('é', 'è', 'ê', 'É', 'È', 'Ê'), 'e', $texto);
    $texto = str_replace(array('í', 'ì', 'î', 'Í', 'Ì', 'Î'), 'i', $texto);
    $texto = str_replace(array('ú', 'ù', 'û', 'Ú', 'Ú', 'Û'), 'u', $texto);
    $texto = str_replace(array('ç', 'Ç'), 'c', $texto);
    $texto = str_replace('pagina', '', strtolower($texto));
    
    $saida = '';
    for ($i=0; $i < strlen($texto); $i++) {
      
      $letra = substr($texto, $i, 1);
      if ($letra == ' ' || $letra == '-') {
        $saida .= '-';
      } else {
        $letra  = eregi_replace("([^a-z0-9])","", $letra);
        $letra  = strtolower($letra);
        $saida .= $letra;
      }
      
    }
    $texto = str_replace('--', '', $saida);
    
    if ($texto) {
      
      $finished = true;
      $contador = $texto;
      $id       = $texto;
      $i        = 0;
      
      while( $finished ) {
        
        if ($cod) {
          $this->selectOne('COUNT(*) as total', "urlrewrite='". $contador ."' AND NOT ". $this->getPrimaryKeyName() .'='. $cod);
        } else {
          $this->selectOne('COUNT(*) as total', "urlrewrite='". $contador ."'");
        }
        
        $row = $this->getResults();
        
        if( $row['total'] == 0) {
          $texto  = $contador;
          $finished = false;
        }
        
        if ($i==0) {
          $contador = $id;
        } else {
          $contador = $id . $i;
        }
        $i++;
        
      }
      
      return $texto;
      
    }
    
  }

}
?>