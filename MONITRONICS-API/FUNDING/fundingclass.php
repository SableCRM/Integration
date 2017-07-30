<?php

class Funding
{
	private $wsiUsername;
	private $wsiPassword;
	private $fundUsername;
	private $fundPassword;

	public function __construct($username, $password, $fundUsername, $fundPassword)
	{
		$this->wsiUsername = $username;
		$this->wsiPassword = $password;
		$this->fundUsername = $fundUsername;
		$this->fundPassword = $fundPassword;
	}

	public function __set($property, $value)
	{
		if(property_exists('$property'))
		{
			$this->property = $value;
		}
	}

	public function UpdateFunding($csNumber, $contractId)
	{
		$UsernameToken = 'UsernameToken-1';

		$ApplicationID = '2';

		$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
				<soapenv:Header>
				<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" soapenv:mustUnderstand="1">
				<wsse:UsernameToken wsu:Id="'.$UsernameToken.'">
				<wsse:Username>'.$this->fundUsername.'</wsse:Username>
				<wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$this->fundPassword.'</wsse:Password>
				</wsse:UsernameToken>
				</wsse:Security>
				</soapenv:Header>
				<soapenv:Body>
				<tem:UpsertCommonFundingDataFromThirdPartyCRM>
				<tem:ApplicationID>'.$ApplicationID.'</tem:ApplicationID>
				<tem:Username>'.$this->wsiUsername.'</tem:Username>
				<tem:Password>'.$this->wsiPassword.'</tem:Password>
				<tem:CSNumber>'.$csNumber.'</tem:CSNumber>
				<tem:ContractID>'.$contractId.'</tem:ContractID>
				</tem:UpsertCommonFundingDataFromThirdPartyCRM>
				</soapenv:Body>
				</soapenv:Envelope>';

		return $xml;
	}

	public function FundingResult($result, $format)
	{
		xml_parse_into_struct(xml_parser_create(), $result, $vals, $index);

		foreach ($vals as $value)
		{
			if ($value['tag'] == 'A:SUCCESS')
			{
				$funding['success'] = $value['value'];
			}

			elseif ($value['tag'] == 'A:SUCCESSMESSAGE')
			{
				$funding['message'] = $value['value'];
			}
		}

		if($format == 'json')
		{
			return json_encode($funding);
		}

		elseif($format == 'array')
		{
			return $funding;
		}
	}
}