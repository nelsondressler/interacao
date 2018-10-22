<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?
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


class MysqlDriver
{
  
  /**
   * Link da conexão (resource)
   * @var resource
   */
  public $connection;
  
  
  /**
   * Resultado de uma pesquisa SELECT
   * @var array
   */
  private $results;
  
  
  /**
   * Resultado de uma pesquisa SELECT
   * @var array
   */
  private $total_rows;
  
  
  /**
   * Conecta ao banco de dados
   * @return database resource id $connection
   */
  public function connect() {
    
    $this->connection = mysql_connect(DB_HOST .':'. DB_PORT, DB_USERNAME, DB_PASSWORD);
    
    if (is_resource($this->connection) && mysql_select_db(DB_DATABASE, $this->connection)) {
       return true;
    } else {
      $this->error();
    }
    
  }
  
  
  /**
   * Desconecta o banco de dados
   */
  public function disconnect() {
    
    mysql_close($this->connection);
    $this->connection = false;
    
  }
  
  
  /**
   * Exibe erros da conexão
   * @return string
   */
  public function error($code=null) {
    
    $erro = new Exception();
    echo '<pre>
          <br><font color="#cc0000"><b>ERRO:</b></font> '. mysql_error( $this->connection ) .
          '<br><font color="#9370d8"><b>CODE:</b></font> '. $code .
          '<br><br>'. $erro->getTraceAsString() .
          '</pre>';
  }
  
  
  /**
   * Executa uma instrução SQL
   * @param string $sql
   * @return array $result
   */
  public function execute($sql) {
    
    $this->results = null;
    
    if ($results = mysql_query($sql, $this->connection)) {
      
      if (is_resource($results)) {
        
        $this->total_rows = mysql_num_rows($results);
        $array = array();
        
        while ($row = mysql_fetch_assoc($results)) {
          $array[] = $row;
        }
        
        $this->results = $array;
        mysql_free_result($results);
        
      }
      
    } else {
      $this->error($sql);
    }
    
  }
  
  
  /**
   * Exibe erros da conexão
   * @return array
   */
  public function getResults($rows = -1) {
    
    if ($rows > -1) {
      return $this->results[$rows];
    } else {
      return $this->results;
    }
    
  }
  
  
  /**
   * Recupera nome da chave primaria de uma tabela
   * @param string $table
   * @return array $results
   */
  public function primaryKeyName($table) {
    
    $this->execute('SHOW COLUMNS FROM '. $table);
    
    for($i=0; $i < count($this->results); $i++) {
      if ($this->results[$i]['Key'] == 'PRI') {
        return $this->results[$i]['Field'];
      }
    }
    
  }
  
  
  public function getTotalRows() {
    return $this->total_rows;
  }
  
  
  /**
   * Executa instrução Commit da transação
   */
  public function commit() {
    
    $this->execute("COMMIT;");
    
  }
  
  
  /**
   * Executa instrução Begin da transação
   */
  public function begin() {
    
    $this->execute("BEGIN;");
    
  }
  
  
  /**
   * Executa instrução Rollback da transação
   */
  public function rollback() {
    
    $this->execute("ROLLBACK;");
    
  }
  
}
?>