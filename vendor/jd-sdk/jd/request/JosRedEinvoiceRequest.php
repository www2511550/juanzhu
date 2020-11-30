<?php
class JosRedEinvoiceRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.josRedEinvoice";
	}
	
	public function getApiParas(){
		return json_encode($this->apiParas);
	}
	
	public function check(){
		
	}
	
	public function putOtherTextParam($key, $value){
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
                                    	                   			private $redData;
    	                        
	public function setRedData($redData){
		$this->redData = $redData;
         $this->apiParas["redData"] = $redData;
	}

	public function getRedData(){
	  return $this->redData;
	}

}





        
 

