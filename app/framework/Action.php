<?php

class Action
{
  
  protected $mensage;
  
  protected $return;
  
  protected $code;
  
  
  public function setReturnMensage($msg = null) {
    $this->mensage = $msg;
  }
  
  public function getReturnMensage() {
    return $this->mensage;
  }
  
  
  public function setReturnCode($code) {
    $this->code = $code;
  }
  
  public function getReturnCode() {
    return $this->code;
  }
  
  
  public function setReturn($return) {
    $this->return = $return;
  }
  
  public function getReturn() {
    return $this->return;
  }
  
}
?>