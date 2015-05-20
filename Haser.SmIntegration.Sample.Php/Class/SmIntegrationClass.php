<?php

class SmIntegration 
{
	public $SmServiceLink;
	public $ApiKey;
	public $ApiPassword;
	public $Culture; // en-US,tr-TR
	public $Cookies;
	
	private function CurlQuery($Data, $Services, $Options)
	{
		$Data = array("Configuration"=>array("ApiKey"=>$this->ApiKey, "ApiPassword"=>$this->ApiPassword, "Culture"=>$this->Culture), "Order"=>$Data);
		$DataStr = json_encode($Data);
		$ch = curl_init();
		$SendData=array();
		curl_setopt($ch, CURLOPT_URL, $this->SmServiceLink.$Services);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $Options);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $DataStr);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$SendData = curl_exec($ch);
		curl_close($ch);
		if($SendData === false) {
			throw new Exception("Connection error.");
		}else
		{
			$array = json_decode($SendData);
			return (array)$array;
		}
	}

	private function HttpBuild($Data, $Services, $Options)
	{ 
		throw new Exception("Connection error.");
		$Data = array("Configuration"=>array("ApiKey"=>$this->ApiKey, "ApiPassword"=>$this->ApiPassword, "Culture"=>$this->Culture), "Order"=>$Data);
		$SendData = array();
		$DataStr = json_encode($Data);
		$SendDataOptions = array (
				'http' => array (     
					'method' => $Options,
					'header'=> "Content-type: application/json\r\n",
						 "Cookie: " . $this->Cookies."\r\n",
					'content' => $DataStr
					)
				);
		
		$SendData = stream_context_create($SendDataOptions);
		
		$SendData = file_get_contents($this->SmServiceLink.$Services, false, $SendData);
		
		if($SendData === false) {
			throw new Exception("Connection error.");
		}else
		{
			$array = json_decode($SendData);
			return (array)$array;
			
		}
	}
	private function ReuiredCheck($Array, $Data)
	{
		if(count($Array)>0)
		{
			foreach($Array as $key=>$value)
			{
				if(!array_key_exists($value,$Data))
				{
					throw new Exception($value." field couldn't found in array.");
				}
			}
		}
	}
	public function GetSmDateTimeFormat($Date)
	{
		return date("Y-m-d H:i:s",strtotime($Date));
	}
	
	public function SetOrder($Data, $SendMethod = 3)
	{
		$Services="/api/Order/SetOrder";
		$Options="POST";
		try {
			$this->ReuiredCheck(array("Nickname", "ListingStatus", "CompanyTitle", "Address", "OrderDetails"), $Data);
			
			if(count($Data["OrderDetails"])>0)
			{
				foreach($Data["OrderDetails"] as $key=>$value)
				{
					$this->ReuiredCheck(array("IntegrationProductCode", "IntegrationProductName", "Quantity"), $Data["OrderDetails"][$key]);
				}
			}else
			{
				throw new Exception("OrderDetails field couldn't found in array.");
			}
			switch ($SendMethod)
			{
				case 1:
					$SetOrder=$this->HttpBuild($Data, $Services, $Options);
					break;
				case 2:
					$SetOrder=$this->CurlQuery($Data, $Services, $Options);			
					break;
				case 3:
				default:
					try
					{
						$SetOrder=$this->HttpBuild($Data, $Services, $Options);			
						break;
					}catch(Exception $ex){
						$SetOrder=$this->CurlQuery($Data, $Services, $Options);
						break;
					}
			}
			return $SetOrder;
			
		} catch (Exception $ex) {
			echo "Error: " , $ex->getMessage();
		}
	}
	public function SetOrderListingStatus($Data, $SendMethod = 3)
	{
		$Services="/api/Order/SetOrderListingStatus";
		$Options="POST";
		try {
			$this->ReuiredCheck(array("OrderId", "ListingStatus"), $Data);
			
			switch ($SendMethod)
			{
				case 1:
					$SetOrder=$this->HttpBuild($Data, $Services, $Options);
					break;
				case 2:
					$SetOrder=$this->CurlQuery($Data, $Services, $Options);			
					break;
				case 3:
				default:
					try
					{
						$SetOrder=$this->HttpBuild($Data, $Services, $Options);			
						break;
					}catch(Exception $ex){
						$SetOrder=$this->CurlQuery($Data, $Services, $Options);
						break;
					}
			}
			return $SetOrder;
			
		} catch (Exception $ex) {
			echo "Error: " , $ex->getMessage();
		}
	}
}

?>