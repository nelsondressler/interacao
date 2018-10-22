<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
require_once 'bootstrap.php';
require_once 'assets/includes/login.php';
/*
echo "<pre>"; 
$plano = new SitePlanosAction2();
$plano->criaAssinatura($_POST); 
echo "</pre>";
die();
 */
if ($_POST['acao'] == 'inserir') {
  
  if ($_SESSION['insere_planos']) {
    $_POST['usuario']=$_SESSION["site_cod_cliente"];
    $plano = new SitePlanosAction();
    //$codificado=$plano->codificaPostInserir($_POST);
    //echo $codificado.'<br>';
    //$POST=$plano->decodificaPostInserir($codificado);
    //print_r($POST); die();
    $plano->criaAssinatura($_POST);
    //$plano->incluirPlano($_POST);
    
    //header('location: planos-finaliza.php');
    
  }
  
}
?>