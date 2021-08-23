<?php
	if(isset($_POST["nCodeOperation"]) && ($_POST["nCodeOperation"]==1 || $_POST["nCodeOperation"]==2 || $_POST["nCodeOperation"]==3) ) 
	{
		include("Class/SmIntegrationClass.php");
		$StockMount = new SmIntegration();
		$StockMount->SmServiceLink = "https://out.stockmount.com";
		$StockMount->ApiKey = "Set Api Key";
		$StockMount->ApiPassword ="Set Api Password";
		$StockMount->Culture ="en-US"; // en-US,tr-TR
		$StockMount->Cookies ="";
		$SampleDate = $StockMount->GetSmDateTimeFormat("20-05-2015 14:08");
		switch($_POST["nCodeOperation"])
		{
			case 1:
				$OrderId="";
				$CargoLabelCode="";
			break;
			case 2:
				$OrderId="116327";
				$CargoLabelCode="CBL088";
			break;
			case 3:
				$OrderId="116327";
				$CargoLabelCode="CBL088";
			break;
		}
		$OrderDetails[]=array("IntegrationProductCode"=>"PC001",
							"IntegrationProductName"=>"Product name 01",
							"Quantity"=>5,
							"Address"=>"",
							"Price"=>10.55,
							"Telephone"=>"",
							"District"=>"",
							"City"=>"",
							"ZipCode"=>"",
							"IntegrationOrderDetailId"=>"",
							"CargoDate"=>"",
							"CargoCompany"=>"",
							"CargoLabelCode"=>$CargoLabelCode,
							"DeliveryTitle"=>"",
							"TaxRate"=>"",
							"Invoiced"=>"",
							"InvoiceDate"=>"",
							"IntegrationProductImage"=>"",
							"CostPrice"=>0,
							"CargoPayment"=>"Seller");//CargoPayment: (Buyer,Seller,Unknown)
		$OrderDetails[]=array("IntegrationProductCode"=>"PC002",
							"IntegrationProductName"=>"Product name 02",
							"Quantity"=>8,
							"Address"=>"",
							"Price"=>8,
							"Telephone"=>"",
							"District"=>"",
							"City"=>"",
							"ZipCode"=>"",
							"IntegrationOrderDetailId"=>"",
							"CargoDate"=>"",
							"CargoCompany"=>"",
							"CargoLabelCode"=>$CargoLabelCode,
							"DeliveryTitle"=>"",
							"TaxRate"=>"",
							"Invoiced"=>"",
							"InvoiceDate"=>"",
							"IntegrationProductImage"=>"",
							"CostPrice"=>0,
							"CargoPayment"=>"Seller");//CargoPayment: (Buyer,Seller,Unknown)
		$Order = array(
					"OrderId"=>$OrderId,
					"Nickname"=>"Nickname PHP",
					"OrderDate"=>$SampleDate,
					"IntegrationOrderCode"=>"OC_PHP_0011",
					"ListingStatus"=>"New", //ListingStatus: (New,Approved,Shipped,Rejected,Delivered,Completed)
					"Fullname"=>"",
					"Address"=>"Invoice Address",
					"District"=>"",
					"City"=>"",
					"ZipCode"=>"",
					"Name"=>"",
					"Surname"=>"",
					"PersonalIdentification"=>"",
					"TaxNumber"=>"",
					"TaxAuthority"=>"",
					"Telephone"=>"",
					"Note"=>"",
					"CompanyTitle"=>"CompanyTitle PHP",
					"OrderDetails"=>$OrderDetails);
		switch($_POST["nCodeOperation"])
		{
			case 1:
				$Query=$StockMount->SetOrder($Order);
			break;
			case 2:
				$Query=$StockMount->SetOrder($Order);
			break;
			case 3:
				$OrderListing= array("OrderId"=>"116327","ListingStatus"=>"Shipped");
				$Query=$StockMount->SetOrderListingStatus($OrderListing);
			break;
		}
		
		//print_r($Query);
		if(isset($Query["Result"]) && $Query["Result"]==true)
		{
			echo json_encode(array("status"=>true,"message"=>"Transaction is successful. OrderId: ". $Query["Response"]));
		}elseif(isset($Query["Result"]) && $Query["Result"]==false)
		{
			echo json_encode(array("status"=>false,"message"=>"Error: ".$Query["ErrorMessage"]." (".$Query["ErrorCode"].")"));
		}else 
		{
			echo json_encode(array("status"=>false,"message"=>"Error: Connection Problem. Please check api information."));
		}
	}
?>