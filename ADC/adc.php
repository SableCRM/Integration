<?php

class ADC
{
	private $username;
	private $password;

	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	public function Create($deal)
	{
		return $this->CreateCustomer($deal);
	}

	public function Terminate($deal)
	{
		return $this->TerminateCustomer($deal);
	}

	public function GetZones($deal)
	{
		return $this->GetDeviceList($deal);
	}

	private function GetDeviceList($deal)
	{
		$User = $this->username;

		$Password = $this->password;

		$xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
		<soap:Header>
		<Authentication xmlns="http://www.alarm.com/WebServices">
		<User>'.$User.'</User>
		<Password>'.$Password.'</Password>
		<TwoFactorDeviceId></TwoFactorDeviceId>
		</Authentication>
		</soap:Header>
		<soap:Body>
		<GetDeviceList xmlns="http://www.alarm.com/WebServices">
		<customerId>'.$deal['ADC Customer Id'].'</customerId>
		</GetDeviceList>
		</soap:Body>
		</soap:Envelope>';

		return $xml;
	}

	private function TerminateCustomer($deal)
	{
	    $User = $this->username;

	    $Password = $this->password;

	    $xml = '<?xml version="1.0" encoding="utf-8"?>
	    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	    <soap:Header>
	    <Authentication xmlns="http://www.alarm.com/WebServices">
	    <User>'.$User.'</User>
	    <Password>'.$Password.'</Password>
	    <TwoFactorDeviceId></TwoFactorDeviceId>
	    </Authentication>
	    </soap:Header>
	    <soap:Body>
	    <TerminateCustomer xmlns="http://www.alarm.com/WebServices">
	    <customerId>'.$deal['ADC Customer Id'].'</customerId>
	    </TerminateCustomer>
	    </soap:Body>
	    </soap:Envelope>';

	    return $xml;
	}

	private function CreateCustomer($deal)
	{
		$User = $this->username;

		$Password = $this->password;
		
		$Address2 = $deal['Address'];

		$City2 = $deal['City'];

		$State2 = $deal['State'] ? $deal['State'] : $deal['Province'];
		
		$Zip2 = $deal['Zip'] ? $deal['Zip'] : $deal['Postal Code'];

		$CountryId2 = $deal['Country'];

		$name = explode( ' ', $deal['Contact Name']);

		if(sizeof($name) > 2)
		{
			$first_name = $name[1];
			$last_name = $name[2];
		}

		else
		{
			$first_name = $name[0];
			$last_name = $name[1];
		}

		$Phone = $deal['Contact Phone'];

		$CustomerAccountEmail = $deal['Email'];

		$CustomerAccountPhone = $deal['Contact Phone'];

		$Address1 = $deal['Address'];

		$City1 = $deal['City'];

		$State1 = $deal['State'] ? $deal['State'] : $deal['Province'];

		$Zip1 = $deal['Zip'] ? $deal['Zip'] : $deal['Postal Code'];

		$CountryId1 = $deal['Country'];

		if($deal['Panel Type'] == 'Go Control')
		{
			$PanelType = 'TwoG';
		}

		elseif($deal['Panel Type'] == 'Go Control 3')
		{
			$PanelType = 'GoControl3';
		}

		elseif($deal['Panel Type'] == 'GE Simon XTi' || $deal['Panel Type'] == 'GE Simon XT' || $deal['Panel Type'] == 'GE Simon XTi-5')
		{
			$PanelType = 'Greybox';
		}

		elseif($deal['Panel Type'] == 'GE Concord 4')
		{
			$PanelType = 'Concord';
		}

		elseif($deal['Panel Type'] == 'DSC NEO')
		{
			$PanelType = 'Neo';
		}

		elseif($deal['Panel Type'] == 'Qolsys IQ 1')
		{
			$PanelType = 'IQPanel';
		}

		$ModemSerialNumber = $deal['ADC Serial Number'];
		
		$PhoneLinePresent = $deal['Panel Phone'] ? 'true' : 'false';

		$CentralStationAccountNumber = $deal['CS Number'];

		$DealerCustomerId = $deal['CS Number'];

		$CentralStationReceiverNumber = $deal['Receiver Phone'];
		
		$addon_feature = '';
		
		if($deal['Two Way Voice'] == 'true')
		{
			$addon_feature .= '<web:AddOnFeatureEnum>TwoWayVoice</web:AddOnFeatureEnum>';
		}
		
		if($deal['ADC Video'] == 'true')
		{
			$addon_feature .= '<web:AddOnFeatureEnum>ProVideo</web:AddOnFeatureEnum>';

			$addon_feature .= '<web:AddOnFeatureEnum>DoorbellCameras</web:AddOnFeatureEnum>'; 
		}
		elseif($deal["Skybell Only"] == "true")
		{
			$addon_feature .= '<web:AddOnFeatureEnum>BasicDoorbell</web:AddOnFeatureEnum>';
		}

		if($PanelType != 'Concord')
		{
			$addon_feature .= '<web:AddOnFeatureEnum>WeatherToPanel</web:AddOnFeatureEnum>';
		}

		if($deal['Monitoring Level'] == 'Wireless Signal Forwarding')
		{
			$PackageId = '1';
		}

		elseif($deal['Monitoring Level'] == 'Basic Interactive')
		{
			$PackageId = '2';
		}

		elseif($deal['Monitoring Level'] == 'Interactive Gold')
		{
			$PackageId = '193';

//			if($PanelType != 'Concord')
//			{
//				$addon_feature .= '<web:AddOnFeatureEnum>SevereWeatherAlerts</web:AddOnFeatureEnum>';
//			}

			$addon_feature .= '
			<web:AddOnFeatureEnum>ZWaveEnergy</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLocks</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>GarageDoors</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>LiftMasterIntegration</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ImageSensorPlus</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLights</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLocks</web:AddOnFeatureEnum>
		
			<web:AddOnFeatureEnum>ZWaveThermostats</web:AddOnFeatureEnum>';
		}

		elseif($deal['Monitoring Level'] == 'Interactive Security')
		{
			$PackageId = '208';
		}

		elseif($deal['Monitoring Level'] == 'Interactive Security and Automation')
		{
			$PackageId = '209';


//			if($PanelType != 'Concord')
//			{
//				$addon_feature .= '<web:AddOnFeatureEnum>SevereWeatherAlerts</web:AddOnFeatureEnum>';
//			}

			$addon_feature .= '
			<web:AddOnFeatureEnum>ZWaveThermostats</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLights</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLocks</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>GarageDoors</web:AddOnFeatureEnum>';
		}
		
		if($deal['Residential/Commercial'] == 'Residential')
		{
			$PropertyType = 'SingleFamilyHouse';
		}

		elseif($deal['Residential/Commercial'] == 'Commercial')
		{
			$PropertyType = 'Business';
		}
		
		$DesiredLoginName = substr($first_name,0,1).substr($last_name,0,1).$deal['Deal_ID'];
		
		$DesiredPassword = 'sablecrm1';

		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.alarm.com/WebServices"><soapenv:Header><web:Authentication><web:User>'.$User.'</web:User><web:Password>'.$Password.'</web:Password><web:TwoFactorDeviceId></web:TwoFactorDeviceId></web:Authentication></soapenv:Header><soapenv:Body><web:CreateCustomer><web:input><web:CustomerAccountAddress><web:Street1>'.$Address1.'</web:Street1><web:Street2></web:Street2><web:SubCity></web:SubCity><web:City>'.$City1.'</web:City><web:SubState></web:SubState><web:State>'.$State1.'</web:State><web:Zip>'.$Zip1.'</web:Zip><web:CountryId>'.$CountryId1.'</web:CountryId><web:FirstName>'.$first_name.'</web:FirstName><web:LastName>'.$last_name.'</web:LastName><web:CompanyName></web:CompanyName><web:Title></web:Title><web:Phone>'.$Phone.'</web:Phone></web:CustomerAccountAddress><web:CustomerAccountEmail>'.$CustomerAccountEmail.'</web:CustomerAccountEmail><web:CustomerAccountPhone>'.$CustomerAccountPhone.'</web:CustomerAccountPhone><web:DealerCustomerId>'.$DealerCustomerId.'</web:DealerCustomerId><web:DesiredLoginName>'.$DesiredLoginName.'</web:DesiredLoginName><web:DesiredPassword>'.$DesiredPassword.'</web:DesiredPassword><web:InstallationAddress><web:Street1>'.$Address2.'</web:Street1><web:Street2></web:Street2><web:SubCity></web:SubCity><web:City>'.$City2.'</web:City><web:SubState></web:SubState><web:State>'.$State2.'</web:State><web:Zip>'.$Zip2.'</web:Zip><web:CountryId>'.$CountryId2.'</web:CountryId></web:InstallationAddress><web:InstallationTimeZone>NotSet</web:InstallationTimeZone><web:Culture>Unknown</web:Culture><web:PanelType>'.$PanelType.'</web:PanelType><web:PanelVersion>Other</web:PanelVersion><web:ModemSerialNumber>'.$ModemSerialNumber.'</web:ModemSerialNumber><web:UnitDescription></web:UnitDescription><web:InstallerCode></web:InstallerCode>
		
		<web:CsEventGroupsToForward>
		
		<web:CentralStationEventGroupEnum>Alarms</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>Bypass</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>Cancels</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>CrashAndSmash</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>PanelNotResponding</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>Panics</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>PhoneCommFailure</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>PhoneTests</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>SensorTampers</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>TroubleRestorals</web:CentralStationEventGroupEnum>
		
		<web:CentralStationEventGroupEnum>Troubles</web:CentralStationEventGroupEnum>
		
		</web:CsEventGroupsToForward>
		
		<web:PhoneLinePresent>'.$PhoneLinePresent.'</web:PhoneLinePresent><web:CentralStationForwardingOption>Always</web:CentralStationForwardingOption><web:CentralStationAccountNumber>'.$CentralStationAccountNumber.'</web:CentralStationAccountNumber><web:CentralStationReceiverNumber>'.$CentralStationReceiverNumber.'</web:CentralStationReceiverNumber><web:PackageId>'.$PackageId.'</web:PackageId><web:AddOnFeatures>'.$addon_feature.'</web:AddOnFeatures><web:IgnoreLowCoverageErrors>true</web:IgnoreLowCoverageErrors><web:BranchId>0</web:BranchId><web:LeadId>0</web:LeadId><web:CustomerNotifications></web:CustomerNotifications><web:LoginNameAtAuthenticationProvider></web:LoginNameAtAuthenticationProvider><web:PropertyType>'.$PropertyType.'</web:PropertyType><web:SalesRepLoginName></web:SalesRepLoginName><web:InstallerLoginName></web:InstallerLoginName><web:ContractLengthInMonths>0</web:ContractLengthInMonths></web:input></web:CreateCustomer></soapenv:Body></soapenv:Envelope>';

		return $xml;
	}

	public function ZoneParser($_zones, $format)
	{
		xml_parse_into_struct(xml_parser_create(), $_zones, $vals, $index);

		foreach($vals as $x)
		{
			switch($x['tag'])
			{
				case 'DEVICEID':
				$zone['id'] = $x['value'];
				break;
				
				case 'WEBSITEDEVICENAME':
				$zone['name'] = $x['value'];
				break;
				
				case 'GROUP':
				$zone['group'] = $x['value'];
				break;
				
				case 'DEVICETYPE':
				$zone['type'] = $x['value'];
				$zones[] = $zone;
				break;
			}
		}
		
		if($format == 'array')
		{
			return $zones;
		}
		elseif($format == 'json')
		{
			return json_encode($zones);
		}
	}

	public function Result($result, $json = false)
	{
		xml_parse_into_struct(xml_parser_create(), $result, $vals, $index);
		foreach ($vals as $value)
		{
			if ($value['tag'] == 'SUCCESS')
			{
				$adc_result['Success'] = $value['value'];
			}
			elseif ($value['tag'] == 'ERRORMESSAGE')
			{
				$adc_result['errorMessage'] = $value['value'];
			}
			elseif($value['tag'] == 'TERMINATECUSTOMERRESULT')
			{
				$adc_result['terminateStatus'] = $value['value'];
			}
			elseif($value['tag'] == 'LOGINNAME')
			{
				$adc_result['LoginName'] = $value['value'];
			}
			elseif($value['tag'] == 'PASSWORD')
			{
				$adc_result['Password'] = $value['value'];
			}
			elseif($value['tag'] == 'CUSTOMERID')
			{
				$adc_result['CustomerId'] = $value['value'];
			}
			elseif($value['tag'] == 'FAULTSTRING')
			{
				$adc_result['terminateError'] = $value['value'];
			}
		}

		if($json)
		{
			return json_encode($adc_result);
		}

		else
		{
			return $adc_result;
		}
	}
}