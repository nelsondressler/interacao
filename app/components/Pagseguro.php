<?php

Class Pagseguro
{

	private $email;
	private $token;
	private $redirectURL;
	private $reviewURL;
	private $notificationURL;
	private $reference;
	
	private $charset = 'ISO-8859-1';
	
	private $environment;
	
	private $url = '/v2/pre-approvals/';
	private $sandboxUrl = 'sandbox.pagseguro.uol.com.br';
	private $productionUrl = 'pagseguro.uol.com.br';
	
	private $requestXML;
	private $senderXML;
	private $preApprovalXML;
	
	private $error;
	
	function setRedirectUrl($url){
		$this->redirectURL = $url;
	}
	
	function setReviewUrl($url){
		$this->reviewURL = $url;
	}
	
	function setNotificationUrl($url){
		$this->notificationURL = $url;
	}
	
	function setEnviroment($environment){
		$this->environment = $environment;
	}
	
	function setCharset($charset){
		$this->charset = $charset;
	}
	
	function setReference($reference){
		$this->reference = $reference;
	}
	
	function setAuth($email, $token){
		$this->email = $email;
		$this->token = $token;
	}
	
	function error(){
		return $this->error;
	}
	
	function setSender($name=null, $email=null, $phone=array(), $address=array()){
		$return='<sender>';
		$return.='<name>' . $name . '</name>';
		$return.='<email>' . $email . '</email>';
		if(!empty($phone)){
			$return.='<phone>';
			if(isset($phone['areaCode'])){
				$return.='<areaCode>' . $phone['areaCode'] . '</areaCode>';
			}
			if(isset($phone['number'])){
				$return.='<number>' . $phone['number'] . '</number>';
			}
			$return.='</phone>';
		}
		if(!empty($address)){
			$return.='<address>';
			foreach(array('street','number','complement', 'district','postalCode','city','state','country') as $field){
				if(isset($address[$field])){
					$return.='<'.$field.'>' . $address[$field] . '</'.$field.'>';
				}
			}
			$return.='</address>';
		}
		$return.='</sender>';
		$this->senderXML = $return;
	}
	
	function setPreApproval($preApproval = array()){
		if(!empty($preApproval)){
			$return='<preApproval>';
			foreach(array('charge','name','details','amountPerPayment','period','finalDate','maxTotalAmount','maxAmountPerPayment') as $field){
				if(isset($preApproval[$field])){
					$return.='<'.$field.'>' . $preApproval[$field] . '</'.$field.'>';
				}
			}
			$return.='</preApproval>';
			$this->preApprovalXML = $return;
		}
	}

	function sendRequest($environment='production' ){
                $url='https://ws.';
		if($this->environment=='sandbox'){
			$url.=$this->sandboxUrl . $this->url;
		} else {
			$url.=$this->productionUrl . $this->url;
		}
		$url.='request?email='.$this->email.'&token='.$this->token;

		//echo '<pre>'.$this->_setXML(); die();
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset='.$this->charset));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->_setXML());
		$retorno= curl_exec($curl);

		$xml=simplexml_load_string($retorno);

		if(count($xml -> error) > 0 || count($xml -> code) == 0){
			$this->error=$retorno;
			return false;
		}
		return (string)$xml->code;
	}
	
	function redirect($code) {
		$url='https://';
		if($this->environment=='sandbox'){
			$url.=$this->sandboxUrl . $this->url;
		} else {
			$url.=$this->productionUrl . $this->url;
		}
		$url.='request.html?code='.$code;
		if (!headers_sent())
			header('Location: '.$url);
		else {
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$url.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
			echo '</noscript>';
		}
	}
	
	function getDataByCode($post)
	{
		if(isset($post['notificationType'])){
                        $url='https://ws.';
			if($this->environment=='sandbox'){
				$url.=$this->sandboxUrl;
			} else {
				$url.=$this->productionUrl;
			}
                        
			$tipo=$post['notificationType'];
			if($tipo=='preApproval'){
				$url.='/v2/pre-approvals/notifications/'.$post['notificationCode'].'?email='.$this->email.'&token='.$this->token;
			}
			if($tipo=='transaction'){
				$url.='/v2/transactions/notifications/'.$post['notificationCode'].'?email='.$this->email.'&token='.$this->token;
			}
                        
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$retorno= curl_exec($curl);
			$xml=simplexml_load_string($retorno);
			return $xml;
		}
	}
	

	private function _setXML(){
		$return='<preApprovalRequest>';
		$return.='<redirectURL>'.$this->redirectURL.'</redirectURL>';
		if(!is_null($this->reviewURL)){
			$return.='<reviewURL>'.$this->reviewURL.'</reviewURL>';
		}
		if(!is_null($this->notificationURL)){
			$return.='<notificationURL>'.$this->notificationURL.'</notificationURL>';
		}
		if(!is_null($this->reference)){
			$return.='<reference>'.$this->reference.'</reference>';
		}
		$return.=$this->senderXML;
		$return.=$this->preApprovalXML;
		$return.='</preApprovalRequest>';
		return $return;
	}
	
}

