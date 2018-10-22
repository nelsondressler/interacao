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


class Transaction
{

  /**
   * Objeto da conex�o
   * @var object
   */
  public static $db = NULL;
  
  
  /**
   * Inicia as transa��o com o banco de dados
   * @return object $db
   */
  public static function Open() {
    
    if (self::$db === NULL) {
      
      try {
        //echo 'conectado<br>';
        require_once SYS_FRAMEWORK .'database/MysqlDriver.php';
        self::$db = new MysqlDriver();
        self::$db->connect();
        
      } catch (Exception $e) {
        echo $e->getMessage();
        exit;
      }

    }
    
    return self::$db;
    
  }
  
  
  /**
   * Confirma transa��o no banco de dados
   */
  public static function commitTrans() {
    self::$db->commit();
  }
  
  
  /**
   * Inicia transa��o no banco de dados
   */
  public static function beginTrans() {
    self::Open();
  }
  
  
  /**
   * Desfaz transa��o no banco de dados
   */
  public static function rollbackTrans() {
    self::$db->rollback();
  }
  
}
?>