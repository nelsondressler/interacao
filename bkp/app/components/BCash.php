<?php

class BCash {

  
  public $email_loja  = 'moti@lubavitch.org.br';
  //public $email_loja  = ' nandotecbr@gmail.com';
  
  public $url_retorno = 'http://interacao.gani.org.br/site/bcash-retorno.php';
  public $url_aviso   = 'http://interacao.gani.org.br/site/bcash-aviso.php';
  
  
  public function checkout($row) {
    
    $n = "\n";
    
    $html = '<form name="frm_pagamento" id="frm_pagamento" action="https://www.bcash.com.br/checkout/pay/" method="post">'.$n;
    
    $html .= '<input name="email_loja"      type="hidden" value="'. $this->email_loja .'">'.$n;
    $html .= '<input name="id_pedido"       type="hidden" value="'. $row['num_pedido'] .'">'.$n;
    $html .= '<input name="tipo_integracao" type="hidden" value="PAD">'.$n;
    $html .= '<input name="url_retorno"     type="hidden" value="'. $this->url_retorno .'">'.$n;
    $html .= '<input name="url_aviso"       type="hidden" value="'. $this->url_aviso .'">'.$n;
    
    $html .= '<input name="email"       type="hidden" value="'. $row['email'] .'">'.$n;
    $html .= '<input name="nome"        type="hidden" value="'. $row['nome'] .'">'.$n;
    $html .= '<input name="cpf"         type="hidden" value="'. $row['cpf'] .'">'.$n;
    $html .= '<input name="telefone"    type="hidden" value="'. $row['telefone'] .'">'.$n;
    $html .= '<input name="endereco"    type="hidden" value="'. $row['endereco'] .' '. $row['numero'] .'">'.$n;
    $html .= '<input name="complemento" type="hidden" value="'. $row['complemento'] .'">'.$n;
    $html .= '<input name="bairro"      type="hidden" value="'. $row['bairro'] .'">'.$n;
    $html .= '<input name="cidade"      type="hidden" value="'. $row['cidade'] .'">'.$n;
    $html .= '<input name="estado"      type="hidden" value="'. $row['estado'] .'">'.$n;
    $html .= '<input name="cep"         type="hidden" value="'. str_replace('-', '', $row['cep']) .'">'.$n;
    
    $html .= '<input name="tipo_frete" type="hidden" value="0">'.$n;
    $html .= '<input name="frete"      type="hidden" value="0">'.$n;
    
    $html .= '<input name="parcela_maxima" type="hidden" value="1">'.$n;
    $html .= '<input name="redirect"       type="hidden" value="true">'.$n.$n;
    
    for ($i = 0; $i < count($row['planos']); $i++) {
      
      $html .= '<input name="produto_codigo_'. ($i+1) .'"    type="hidden" value="'. $row['planos'][$i]['cod_plano'] .'">'.$n;
      $html .= '<input name="produto_descricao_'. ($i+1) .'" type="hidden" value="'. $row['planos'][$i]['plano'] .'">'.$n;
      $html .= '<input name="produto_qtde_'. ($i+1) .'"      type="hidden" value="1">'.$n;
      $html .= '<input name="produto_valor_'. ($i+1) .'"     type="hidden" value="'. $row['planos'][$i]['valor'] .'" >'.$n.$n;
    
    }
    
    $html .= '<input type="image" src="https://a248.e.akamai.net/f/248/96284/12h/www.bcash.com.br/webroot/img/bt_comprar.gif" value="Comprar" alt="Comprar" border="0" align="absbottom" >'.$n;
    $html .= '</form>';
    
    return $html;
    
  }
  
  
  public function saveRequest($tipo, $pedido) {
    
    ob_start();
    print_r($_REQUEST);
    $conteudo = ob_get_contents();
    ob_end_clean();
    
    $filesys= new FileSystem();
    $filesys->cria(SYS_CONTEUDO .'temp/'. $pedido .'_'. $tipo .'_'. date('Y-m-d H-i-s') .'.txt', $conteudo);
    
  }

  
  public function consultaTransacao() {
    
 
    
  }
  
}

?>
