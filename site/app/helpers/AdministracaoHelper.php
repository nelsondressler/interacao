<?php

class AdministracaoHelper {
  
  
  public static function listaMenu() {
    
    return array(
      
      array('menu'=>'0','nome'=>'Geral'),
      array('menu'=>'1','nome'=>'Sistema'),
      array('menu'=>'2','nome'=>'Relatórios'),
      array('menu'=>'3','nome'=>'Conteúdo'),
      array('menu'=>'4','nome'=>'Formulários')

    );
    
  }
  
  
  public static function listaPermissoes() {
    
    return array(
      
      array('menu'=>'0', 'nome'=>'Configurações Adm', 'modulo'=>'adm_configuracao'),
      array('menu'=>'0', 'nome'=>'Usuário Adm',       'modulo'=>'adm_usuarios'),
      
      array('menu'=>'1', 'nome'=>'Planos e Períodos',       'modulo'=>'sys_planos'),
      array('menu'=>'1', 'nome'=>'Clientes',                'modulo'=>'sys_clientes'),
      array('menu'=>'1', 'nome'=>'Administrar parcelas',    'modulo'=>'sys_parcelas'),
      array('menu'=>'1', 'nome'=>'Enviar e-mail cobrança',  'modulo'=>'sys_enviar_cobranca'),
      
      //array('menu'=>'2', 'nome'=>'Parcelas a pagar',      'modulo'=>'sys_rel_apagar'),
      //array('menu'=>'2', 'nome'=>'Parcelas atrasadas',    'modulo'=>'sys_rel_atrasados'),
      //array('menu'=>'2', 'nome'=>'Números para o sorteio',  'modulo'=>'sys_rel_atrasados'),
      
      array('menu'=>'3', 'nome'=>'Quem Somos',     'modulo'=>'pag_quemsomos'),
      array('menu'=>'3', 'nome'=>'Dúvidas',        'modulo'=>'pag_duvidas'),
      array('menu'=>'3', 'nome'=>'Banner Home',    'modulo'=>'pag_banner_home'),
      array('menu'=>'3', 'nome'=>'Banner Rodapé',  'modulo'=>'pag_banner_rodape'),
      array('menu'=>'4', 'nome'=>'Contatos enviados',  'modulo'=>'frm_contato')
      
    );
    
  }
  
}
