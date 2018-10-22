<?php

class ItauShopline {

  
  public $email_loja  = '';
  
  public $url = 'https://shopline.itau.com.br/shopline/emissao_teste.aspx';
  //public $url = 'https://shopline.itau.com.br/shopline/shopline.aspx';
  
  
  public function checkout($row) {
    
    $dataVencimento = Date::add(5, Date::timestampToBr($row['data_vencimento']));
    $dataVencimento = str_replace('/', '', $dataVencimento);
    
    $cripto = new Itaucripto();

    $codEmp = "J1234567890123456789012345";
    $chave  = "ABCD123456ABCD12";
  
    $pedido          = $row['num_pedido'];
    $valor           = number_format($row['valor'], 2, ',', '');
    $observacao      = "Essa é uma observação";
    $nomeSacado      =  $row['nome'];
    $codigoInscricao = "01";
    $numeroInscricao = "82938674341";
    $enderecoSacado  = $row['endereco'];
    $bairroSacado    = $row['bairro'];
    $cepSacado       = str_replace('-', '', $row['cep']);
    $cidadeSacado    = $row['cidade'];
    $estadoSacado    = $row['estado'];
    $urlRetorna      = "http://interacao.gani.org.br/site/itau-retorno.php";
    $obsAd1          = "Aqui vai a observação 1";
    $obsAd2          = "Aqui vai a observação 2";
    $obsAd3          = "Aqui vai a observação 3";
    
    $dados = $cripto->geraDados($codEmp, $pedido, $valor, $observacao, $chave, $nomeSacado, $codigoInscricao, $numeroInscricao,
                                $enderecoSacado, $bairroSacado, $cepSacado, $cidadeSacado, $estadoSacado, $dataVencimento,
                                $urlRetorna, $obsAd1, $obsAd2, $obsAd3);
  
    $n = "\n";
    
    $html  = '<form name="frm_pagamento" id="frm_pagamento" method="post" action="'. $this->url .'">'.$n;
    $html .= '<input name="DC" type="hidden" value="'. $dados .'">'.$n;
    $html .= '<input type="submit" name="Shopline" value="Itaú Shopline">'.$n;
    $html .= '</form>';
    
    return $html;
    
  }
  
  
  public function saveRequest($tipo) {
    
    $id_pedido = $_REQUEST['id_pedido'];
    
    ob_start();
    print_r($_REQUEST);
    $conteudo = ob_get_contents();
    ob_end_clean();
    
    $filesys= new FileSystem();
    $filesys->cria(SYS_CONTEUDO .'temp/itau_'. $tipo .'_'. $id_pedido .'_'. date('Y-m-d H-i-s') .'.txt', $conteudo);
    
  }

}

?>
