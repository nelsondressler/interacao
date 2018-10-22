<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
/**
 *
 *
 $template = new Template( SYS_PATH .'administracao/template_email/teste.php' );

$array['nome'] = 'fernando';
$array['produtos'] = array (
  array('nome'=>'fernando','valor'=>'200'),
  array('nome'=>'marcio','valor'=>'100')
);

$template->setDados('dados', $array);
echo $template->publicar();
 *
 */
class Template {
  
  
  private $dados = array();
  
  private $arquivo;
  
  
  public function __construct($arquivo = null) {
    
    if ($arquivo) {
      $this->arquivo = $arquivo;
    }
    
  }
  
  
  public function setDados($nome, $valor) {
    
    $this->dados[$nome] = $valor;
    
  }
  
  
  protected function carregaArquivo() {
    
    if (file_exists($this->arquivo)) {
      return $this->arquivo;
    }
    
  }
  
  
  public function getHtml() {
    
    $arquivo = $this->carregaArquivo();
    extract($this->dados);
    
    ob_start();
    include($arquivo);
    $conteudo = ob_get_contents();
    ob_end_clean();
    
    return $conteudo;
    
  }
  
}
?>