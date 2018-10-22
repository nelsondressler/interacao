<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php

class AdministracaoUsuariosAction extends Action
{
  
  public function lembraSenha($login) {
    
    $sis_user = new AdministracaoUsuariosModel();
    $sis_user->selectOne('*', "login='". $login ."'");
    
    $row = $sis_user->getResults();
    
    if ($row) {
      
      $email_sistem = new EmailSystem();
      $email_sistem->lembraSenha($row['nome'], Security::decripty($row['email']), $row['senha']);
      $this->setReturnMensage('Um lembrete de senha foi enviado para o email '. $row['email'] );
      
    } else {
      
      $this->setReturnMensage('O login '. $login .' não foi encontrado');
      
    }
    
  }
  
  
  public function login($login, $senha = null, $idioma = null) {
    
    $sis_user = new AdministracaoUsuariosModel();
    $sis_user->selectOne('*', "login='". $login ."'");
    
    $row = $sis_user->getResults();
    
    if ($row) {
      if ($row['senha'] == Security::encripty($senha)) {
        
        $_SESSION["login_cod"]        = $row["cod_usuario"];
        $_SESSION["login_nome"]       = $row["nome"];
        $_SESSION["login_idioma"]     = $idioma;
        $_SESSION["login_permissoes"] = null;
        
        $sis_perm = new AdministracaoUsuariosPermissoesModel();
        $sis_perm->selectAll('DISTINCT permissoes_module', "cod_usuario=". $row["cod_usuario"]);
        $row_mod = $sis_perm->getResults();
        
        foreach ($row_mod as $list) {
          
          $sis_perm->selectAll('permissoes_acao', "cod_usuario=". $_SESSION["login_cod"] ." AND permissoes_module='". $list['permissoes_module'] ."'");
          $row_perm = $sis_perm->getResults();
          
          foreach ($row_perm as $list2) {
            $_SESSION["login_permissoes"][$list['permissoes_module']][] = $list2['permissoes_acao'];
          }
          
        }
        
        if ($lembrar) {
          System::setCookie('index_login[nome]', Security::encripty($login) );
          System::setCookie('index_login[senha]', Security::encripty($row['senha']) );
        } else {
          System::setCookie('index_login[nome]', '');
          System::setCookie('index_login[senha]', '');
        }
       
        $this->setReturn(true);
      } else {
        $this->setReturnMensage('Senha incorreta');
      }
      
    } else {
      $this->setReturnMensage('O login '. $login .' não foi encontrado');
    }
    
  }
  
  
  public function lista() {
    
    $sis_user = new AdministracaoUsuariosModel();
    $sis_user->selectAll('*', null, 'cod_usuario');
    return $sis_user->getResults();
    
  }
  
  
  public function excluirLista($cod) {
    
    $sis_user = new AdministracaoUsuariosModel();
    $sis_perm = new AdministracaoUsuariosPermissoesModel();
    
    for($i=0; $i < count($cod); $i++) {
      $sis_perm->delete($sis_user->getPrimaryKeyName() .'='. $cod[$i]);
      $sis_user->delete($sis_user->getPrimaryKeyName() .'='. $cod[$i]);
    }
    
  }
  
  
  public function exibe($cod) {
    
    $sis_user = new AdministracaoUsuariosModel();
    $sis_user->selectOne('*', $sis_user->getPrimaryKeyName() .'='. $cod);
    return $sis_user->getResults();
    
  }
  
  
  public function grava($incluir, $FORM) {
    
    $sis_user = new AdministracaoUsuariosModel();
    $sis_perm = new AdministracaoUsuariosPermissoesModel();
    
    $where = '';
    
    if ($FORM['login']) {
      $where = "login='". $FORM['login'] ."'";
      if ($FORM['cod']) {
        $where .= ' AND NOT cod_usuario ='. $FORM['cod'];
      }
    }
    $sis_user->selectOne('*', $where);
    
    if ($sis_user->getTotalRows() > 0) {
      
      $this->setReturnMensage('
        Já existe um usuários com este login!
        <p><a href="javascript:history.go(-1)">Voltar ao registro</a>
      ');
      
    } else {
      
      $field['nome']    = $FORM['nome'];
      $field['email']   = $FORM['email'];
      $field['login']   = $FORM['login'];
      $field['senha']   = Security::encripty($FORM['senha']);
      
      // Inclui
      if ($incluir) {
        
        $sis_user->insert($field);
        $msg  = 'inserido';
        $cod_usuario = $sis_user->getLastInsertKey();
        $link = System::thisFile() .'?cod='. $cod_usuario;
        
      // Alterar
      } else {
        
        $cod_usuario = $FORM['cod'];
        $sis_user->update($field, 'cod_usuario='. $cod_usuario);
        $msg  = 'alterado';
        $link = System::thisFile() .'?cod='. $cod_usuario;
        
      }
      
      // Insere permissões
      $sis_perm->delete('cod_usuario='. $cod_usuario);
      
      foreach (AdministracaoHelper::listaPermissoes() as $list) {
        
        for ($i=0; $i < count($FORM[$list['modulo']]); $i++) {
          $sis_perm->insert(array(
            'cod_usuario'=>$cod_usuario,
            'permissoes_module'=>$list['modulo'],
            'permissoes_acao'=>$FORM[$list['modulo']][$i]
          ));
        }
        
      }
      
      $this->setReturnMensage('
        <b>Registro '. $msg .' com sucesso!</b>
        <p><a href="'. $link .'">Voltar ao registro</a> |
        <a href="'. SystemLayout::getModule() .'.php">Voltar a lista</a></p>
      ');
      
    }
    
  }
  
  
  public function getPermissao($modulo, $permissao, $cod_usuario) {
    
    /*
     * Codido de permissões
     * 1 - Visualizar
     * 2 - Inserir
     * 3 - Alterar
     * 4 - Excluir
     */
    
    if ($modulo && $permissao && $cod_usuario) {
      
      $sis_perm = new AdministracaoUsuariosPermissoesModel();
      $sis_perm->selectOne('*', "cod_usuario=". $cod_usuario ." AND permissoes_module='". $modulo ."' AND permissoes_acao=". $permissao);
      
      if ($sis_perm->getTotalRows() > 0) {
        return true;
      } else {
        return false;
      }
      
    }
    
  }
  
}
?>