<?php 	

class Immediate
{
	public $panel;
	public $testState;
	public $testCat;
	public $hour;
	public $minute;

	private $username;
	private $password;

	public function __construct($username, $password)
	{
	    $this->username = $username;
	    $this->password = $password;
	}

	public function Set($entity, $customerNumber)
	{
		switch(strtolower($entity))
		{
		    case 'ontest':
				if($this->testState == 'On')
				{
		        	$xmldata = htmlentities($this->OnTestXml($this->testState, $this->testCat, $this->hour, $this->minute));
				}
				elseif($this->testState == 'Off')
				{
					$xmldata = htmlentities($this->OffTestXml($this->testState));
				}
				break;
				
		    case 'twoway':
		        $xmldata = htmlentities($this->AddTwowayXml($this->panel));
		        break;
		}

		$xml = '<?xml version="1.0" encoding="utf-8"?>
	    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	    <soap:Header>
	    <ApplicationIDHeader xmlns="https://mimasweb.monitronics.net/MIDI/">
	    <appID>WSI</appID>
	    </ApplicationIDHeader>
	    </soap:Header>
	    <soap:Body>
	    <Immediate xmlns="https://mimasweb.monitronics.net/MIDI/">
	    <Entity>'.$entity.'</Entity>
	    <UserID>'.$this->username.'</UserID>
	    <Password>'.$this->password.'</Password>
	    <CustomerNumber>'.$customerNumber.'</CustomerNumber>
	    <XMLData>'.$xmldata.'</XMLData>
	    </Immediate>
	    </soap:Body>
	    </soap:Envelope>';
		
		return $xml;
	}

	private function OnTestXml($state, $testCat, $hr, $min)
	{
		return '<?xml version="1.0"?>
		<OnTests xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	  	<OnTest onoff_flag="'.$state.'" testcat_id="'.$testCat.'" test_hours="'.$hr.'" test_minutes="'.$min.'" />
		</OnTests>';
	}
	
	private function OffTestXml($state)
	{
		return '<?xml version="1.0"?>
		<OnTests xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  		<OnTest onoff_flag="'.$state.'" />
		</OnTests>';
	}

	private function AddTwowayXml($panel)
	{
		$twoWayDevice = $this->TwowayDevice($panel);
		
		return '<?xml version="1.0"?>
		<Twoways xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
		<Twoway twoway_device_id="'.$twoWayDevice.'" />
		</Twoways>';
	}
	
	private function TwowayDevice($panel)
	{
		if($panel == 'Go Control')
		{
			$device = '20S002';
		}
		elseif($panel == 'Go Control 3')
		{
			$device = '20S001';
		}
		elseif($panel == 'GE Simon XT')
		{
		}
		elseif($panel == 'GE Simon XTi')
		{
			$device = 'G2S014';
		}
		elseif($panel == 'GE Simon XTi-5')
		{
			$device = 'G2S014';
		}
		elseif($panel == 'GE Concord 4')
		{
			$device = 'G2S005';
		}
		elseif($panel == 'DSC NEO')
		{
		}
		elseif($panel == 'Qolsys IQ 1')
		{
		}
		
		return $device;
	}
}