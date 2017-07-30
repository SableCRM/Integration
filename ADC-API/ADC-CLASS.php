<?php

/**
 * Created by PhpStorm.
 * User: razaman
 * Date: 2/23/2017
 * Time: 8:35 AM
 */
class ADC
{
	public $returnFormats = array('format' => ['json', 'array'], 'error' => ['INVALID RETURN FORMAT SELECTED']);
    private $username, $password;
    private $url, $soapAction;
    private $errors = array();
    
    public function __construct($username, $password, $url, $soapAction)
    {
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
        $this->soapAction = $soapAction;
    }
    
    public function Create($deal, $format)
    {
        $format = strtolower($format);

        if(in_array($format, $this->returnFormats['format']))
        {
            if($this->CreateCustomerValidation($deal))
            {
                $result = $this->send('CreateCustomer', $this->createCustomerXml($deal));
                return $this->result($result, $format);
            }
            else
            {
                if($format == 'json')
                {
                    return json_encode($this->errors);
                }
                elseif($format == 'array')
                {
                    return $this->errors;
                }
            }
        }
        else
        {
            return json_encode(array($this->returnFormats['error']));
        }
    }

	private function CreateCustomerValidation($deal)
    {
	    if(!$deal['Monitoring Center'] || $deal['Monitoring Center'] == '-None-'){
		    array_push($this->errors, 'please choose a monitoring center in deal.');
	    }
	    if(!$deal['Country'] || $deal['Country'] == '-Nome-'){
		    array_push($this->errors, 'please select a country in deal.');
	    }
	    if(!$deal['Contact Name']){
		    array_push($this->errors, 'please enter a contact name in deal.');
	    }
	    if(!$deal['Contact Phone']){
		    array_push($this->errors, 'please enter a contact phone in deal.');
	    }
	    if(!$deal['Email']){
		    array_push($this->errors, 'please enter an email in deal.');
        }
	    if(!$deal['Address']){
		    array_push($this->errors, 'please enter an address in deal.');
        }
	    if(!$deal['City']){
		    array_push($this->errors, 'please enter a city in deal.');
	    }
	    if(!$deal['State'] && !$deal['Province']){
		    array_push($this->errors, 'please enter a state or province in deal.');
	    }
	    if(!$deal['Zip'] && !$deal['Postal Code']){
		    array_push($this->errors, 'please enter a zip or postal code in deal.');
	    }
	    if(!$deal['Panel Type'] || $deal['Panel Type'] == '-None-'){
		    array_push($this->errors, 'please choose a panel type in deal.');
	    }
	    if(!$deal['ADC Serial Number']){
		    array_push($this->errors, 'please enter an adc serial number in deal.');
	    }
	    if(!$deal['CS Number']){
		    array_push($this->errors, 'please enter a cs number in deal.');
        }
	    if(!$deal['Receiver Phone'] || $deal['Receiver Phone'] == '-None-'){
		    array_push($this->errors, 'please enter a receiver phone in deal.');
        }
	    if(!$deal['Monitoring Level'] || $deal['Monitoring Level'] == '-None-'){
		    array_push($this->errors, 'please choose a monitoring level in deal.');
	    }
	    if(!$deal['Residential/Commercial'] || $deal['Residential/Commercial'] == '_None-'){
		    array_push($this->errors, 'please choose residential or commercial in deal.');
	    }
	    if(!$deal['Deal_ID']){
		    array_push($this->errors, 'please enter a deal id in deal.');
	    }

	    if(!$this->errors){
		    return true;
	    }
    }

	public function send($action, $data)
    {
	    $ch = curl_init($this->url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $headers = array();

	    array_push($headers, "Content-Type: text/xml");

	    array_push($headers, "SOAPAction: ".$this->soapAction.$action);

	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    $response = curl_exec($ch);
	    curl_close($ch);

	    return $response;
    }
    
    private function createCustomerXml($deal)
    {
        $Address2 = $deal['Address'];

        $City2 = $deal['City'];

        $State2 = $deal['State'] ? $deal['State'] : $deal['Province'];

        $Zip2 = $deal['Zip'] ? $deal['Zip'] : $deal['Postal Code'];

        $CountryId2 = $deal['Country'];

        $name = explode(' ', $deal['Contact Name']);

        if(sizeof($name) > 2){
            $first_name = $name[1];
            $last_name = $name[2];
        }else{
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

        if($deal['Panel Type'] == 'Go Control'){
            $PanelType = 'TwoG';
        }elseif($deal['Panel Type'] == 'Go Control 3'){
            $PanelType = 'GoControl3';
        }elseif($deal['Panel Type'] == 'GE Simon XTi' || $deal['Panel Type'] == 'GE Simon XT' || $deal['Panel Type'] == 'GE Simon XTi-5'){
            $PanelType = 'Greybox';
        }elseif($deal['Panel Type'] == 'GE Concord 4'){
            $PanelType = 'Concord';
        }elseif($deal['Panel Type'] == 'DSC NEO'){
            $PanelType = 'Neo';
        }elseif($deal['Panel Type'] == 'Qolsys IQ 1'){
            $PanelType = 'IQPanel';
        }

        $ModemSerialNumber = $deal['ADC Serial Number'];

        $PhoneLinePresent = $deal['Panel Phone'] ? 'true' : 'false';

        $CentralStationAccountNumber = $deal['CS Number'];

        $DealerCustomerId = $deal['CS Number'];

        $CentralStationReceiverNumber = $deal['Receiver Phone'];

	    $addon_feature = '';

	    if($deal['Two Way Voice'] == 'true'){
            $addon_feature .= '<web:AddOnFeatureEnum>TwoWayVoice</web:AddOnFeatureEnum>';
        }

	    if($deal['ADC Video'] == 'true'){
            $addon_feature .= '<web:AddOnFeatureEnum>ProVideo</web:AddOnFeatureEnum>';

		    $addon_feature .= '<web:AddOnFeatureEnum>DoorbellCameras</web:AddOnFeatureEnum>';
        }
	    if($deal["Skybell Only"] == "true")
	    {
		    $addon_feature .= '<web:AddOnFeatureEnum>BasicDoorbell</web:AddOnFeatureEnum>';
	    }

	    if($PanelType != 'Concord'){
            $addon_feature .= '<web:AddOnFeatureEnum>WeatherToPanel</web:AddOnFeatureEnum>';
        }

	    if($deal['Monitoring Level'] == 'Wireless Signal Forwarding'){
            $PackageId = '1';
        }elseif($deal['Monitoring Level'] == 'Basic Interactive'){
            $PackageId = '2';
        }elseif($deal['Monitoring Level'] == 'Interactive Gold'){
            $PackageId = '193';

//            if($PanelType != 'Concord'){
//                $addon_feature .= '<web:AddOnFeatureEnum>SevereWeatherAlerts</web:AddOnFeatureEnum>';
//            }

            $addon_feature .= '
			<web:AddOnFeatureEnum>ZWaveEnergy</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLocks</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>GarageDoors</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>LiftMasterIntegration</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ImageSensorPlus</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLights</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLocks</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveThermostats</web:AddOnFeatureEnum>';

	    }elseif($deal['Monitoring Level'] == 'Interactive Security'){
            $PackageId = '208';
        }elseif($deal['Monitoring Level'] == 'Interactive Security and Automation'){
            $PackageId = '209';


//            if($PanelType != 'Concord'){
//                $addon_feature .= '<web:AddOnFeatureEnum>SevereWeatherAlerts</web:AddOnFeatureEnum>';
//            }

            $addon_feature .= '
			<web:AddOnFeatureEnum>ZWaveThermostats</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLights</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>ZWaveLocks</web:AddOnFeatureEnum>
			
			<web:AddOnFeatureEnum>GarageDoors</web:AddOnFeatureEnum>';
        }

	    if($deal['Residential/Commercial'] == 'Residential'){
            $PropertyType = 'SingleFamilyHouse';
        }elseif($deal['Residential/Commercial'] == 'Commercial'){
            $PropertyType = 'Business';
        }

	    $DesiredLoginName = substr($first_name, 0, 1).substr($last_name, 0, 1).$deal['Deal_ID'];

	    $DesiredPassword = 'sablecrm1';

	    $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://www.alarm.com/WebServices"><soapenv:Header><web:Authentication><web:User>'.$this->username.'</web:User><web:Password>'.$this->password.'</web:Password><web:TwoFactorDeviceId></web:TwoFactorDeviceId></web:Authentication></soapenv:Header><soapenv:Body><web:CreateCustomer><web:input><web:CustomerAccountAddress><web:Street1>'.$Address1.'</web:Street1><web:Street2></web:Street2><web:SubCity></web:SubCity><web:City>'.$City1.'</web:City><web:SubState></web:SubState><web:State>'.$State1.'</web:State><web:Zip>'.$Zip1.'</web:Zip><web:CountryId>'.$CountryId1.'</web:CountryId><web:FirstName>'.$first_name.'</web:FirstName><web:LastName>'.$last_name.'</web:LastName><web:CompanyName></web:CompanyName><web:Title></web:Title><web:Phone>'.$Phone.'</web:Phone></web:CustomerAccountAddress><web:CustomerAccountEmail>'.$CustomerAccountEmail.'</web:CustomerAccountEmail><web:CustomerAccountPhone>'.$CustomerAccountPhone.'</web:CustomerAccountPhone><web:DealerCustomerId>'.$DealerCustomerId.'</web:DealerCustomerId><web:DesiredLoginName>'.$DesiredLoginName.'</web:DesiredLoginName><web:DesiredPassword>'.$DesiredPassword.'</web:DesiredPassword><web:InstallationAddress><web:Street1>'.$Address2.'</web:Street1><web:Street2></web:Street2><web:SubCity></web:SubCity><web:City>'.$City2.'</web:City><web:SubState></web:SubState><web:State>'.$State2.'</web:State><web:Zip>'.$Zip2.'</web:Zip><web:CountryId>'.$CountryId2.'</web:CountryId></web:InstallationAddress><web:InstallationTimeZone>NotSet</web:InstallationTimeZone><web:Culture>Unknown</web:Culture><web:PanelType>'.$PanelType.'</web:PanelType><web:PanelVersion>Other</web:PanelVersion><web:ModemSerialNumber>'.$ModemSerialNumber.'</web:ModemSerialNumber><web:UnitDescription></web:UnitDescription><web:InstallerCode></web:InstallerCode>
	    
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
    
    private function result($result, $format)
    {
        xml_parse_into_struct(xml_parser_create(), $result, $vals, $index);
        foreach($vals as $value)
        {
            if($value['tag'] == 'SUCCESS')
            {
                $adc_result['Success'] = $value['value'];
            }
            elseif($value['tag'] == 'ERRORMESSAGE')
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

	    if($format == 'json')
        {
            return json_encode($adc_result);
        } elseif($format == 'array')
        {
            return $adc_result;
        }
    }

	public function Terminate($customerId, $format)
	{
		$format = strtolower($format);

		if(in_array($format, $this->returnFormats['format'])){
			if($this->TerminateCustomerValidation($customerId)){
				$customerId = (is_array($customerId)) ? $customerId['ADC Customer Id'] : $customerId;

				$result = $this->send('TerminateCustomer', $this->terminateCustomerXml($customerId));

				return $this->result($result, $format);
			} else{
				if($format == 'json'){
					return json_encode($this->errors);
				} else if($format == 'array'){
					return $this->errors;
				}
			}
		} else{
			return json_encode(array($this->returnFormats['error']));
		}
	}
    
    private function TerminateCustomerValidation($deal)
    {
        $is_array = is_array($deal);

	    if(!$deal['ADC Customer Id'] && $is_array){
            array_push($this->errors, 'please enter adc customer id in deal.');
        }

//        if(!$deal['Monitoring Center'] || $deal['Monitoring Center'] == '-None-'){
//            array_push($this->errors, 'please choose a monitoring center in deal.');
//        }

	    if(!$this->errors || is_string($deal) || is_int($deal)){
            return true;
        }
    }

	private function terminateCustomerXml($customerId)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>
	    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	    <soap:Header>
	    <Authentication xmlns="http://www.alarm.com/WebServices">
	    <User>'.$this->username.'</User>
	    <Password>'.$this->password.'</Password>
	    <TwoFactorDeviceId></TwoFactorDeviceId>
	    </Authentication>
	    </soap:Header>
	    <soap:Body>
	    <TerminateCustomer xmlns="http://www.alarm.com/WebServices">
	    <customerId>'.$customerId.'</customerId>
	    </TerminateCustomer>
	    </soap:Body>
	    </soap:Envelope>';

		return $xml;
	}

	public function GetZones($customerId, $format)
    {
	    $format = strtolower($format);

	    if(in_array($format, $this->returnFormats['format'])){
		    if($this->TerminateCustomerValidation($customerId)){
			    $customerId = (is_array($customerId)) ? $customerId['ADC Customer Id'] : $customerId;

			    $result = $this->send('GetDeviceList', $this->getDeviceListXml($customerId));

			    return $this->zoneParser($result, $format);
		    } else{
			    if($format == 'json'){
				    return json_encode($this->errors);
			    } else if($format == 'array'){
				    return $this->errors;
			    }
		    }
        } else{
		    return json_encode(array($this->returnFormats['error']));
        }
    }

	private function getDeviceListXml($customerId)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>
		<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
		<soap:Header>
		<Authentication xmlns="http://www.alarm.com/WebServices">
		<User>'.$this->username.'</User>
		<Password>'.$this->password.'</Password>
		<TwoFactorDeviceId></TwoFactorDeviceId>
		</Authentication>
		</soap:Header>
		<soap:Body>
		<GetDeviceList xmlns="http://www.alarm.com/WebServices">
		<customerId>'.$customerId.'</customerId>
		</GetDeviceList>
		</soap:Body>
		</soap:Envelope>';

		return $xml;
	}

	private function zoneParser($_zones, $format)
	{
		xml_parse_into_struct(xml_parser_create(), $_zones, $vals, $index);
		foreach($vals as $x){
			switch($x['tag']){
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

		if($format == 'array'){
			return $zones;
        } else if($format == 'json'){
			return json_encode($zones);
        }
//
//        if($zones == null)
//        {
//            array_push($this->errors, array('error' => 'NO ZONES WERE FOUND FOR ACCOUNT'));
//
//            if($format == 'array')
//            {
//                return $this->errors;
//            }
//
//            elseif($format == 'json')
//            {
//                return json_encode($this->errors);
//            }
//        }
    }
}