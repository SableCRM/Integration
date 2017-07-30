<?php

function AdcTerminateCustomerValidation($deal, &$errors)
{
	$error['error'] = array();

	if(!$deal['ADC Customer Id'])
	{
		array_push($error['error'], 'please enter adc customer id in deal.');
	}
	if(!$deal['Monitoring Center'] || $deal['Monitoring Center'] == '-None-')
	{
		array_push($error['error'], 'please choose a monitoring center in deal.');
	}
	
	if($error['error'])
	{
		$errors = json_encode($error);
	}
	else
	{
		return true;
	}
}


function AdcCreateCustomerValidation($deal, &$errors)
{	
	$error['error'] = array();

    if(!$deal['Monitoring Center'] || $deal['Monitoring Center'] == '-None-')
    {
    	array_push($error['error'], 'please choose a monitoring center in deal.');
    }
	if(!$deal['Country'] || $deal['Country'] == '-Nome-')
	{
		array_push($error['error'], 'please select a country in deal.');
	}
	if(!$deal['Contact Name'])
	{
		array_push($error['error'], 'please enter a contact name in deal.');
	}
	if(!$deal['Contact Phone'])
	{
		array_push($error['error'], 'please enter a contact phone in deal.');
	}
	if(!$deal['Email'])
	{
		array_push($error['error'], 'please enter an email in deal.');
	}
	if(!$deal['Address.inc'])
	{
		array_push($error['error'], 'please enter an address in deal.');
	}
	if(!$deal['City'])
	{
		array_push($error['error'], 'please enter a city in deal.');
	}
	if(!$deal['State'] && !$deal['Province'])
	{
		array_push($error['error'], 'please enter a state or province in deal.');
	}
	if(!$deal['Zip'] && !$deal['Postal Code'])
	{
		array_push($error['error'], 'please enter a zip or postal code in deal.');
	}
	if(!$deal['Panel Type'] || $deal['Panel Type'] == '-None-')
	{
		array_push($error['error'], 'please choose a panel type in deal.');
	}
	if(!$deal['ADC Serial Number'])
	{
		array_push($error['error'], 'please enter an adc serial number in deal.');
	}
	if(!$deal['CS Number'])
	{
		array_push($error['error'], 'please enter a cs number in deal.');
	}
	if(!$deal['Receiver Phone'] || $deal['Receiver Phone'] == '-None-')
	{
		array_push($error['error'], 'please enter a receiver phone in deal.');
	}
	if(!$deal['Monitoring Level'] || $deal['Monitoring Level'] == '-None-')
	{
		array_push($error['error'], 'please choose a monitoring level in deal.');
	}
	if(!$deal['Residential/Commercial'] || $deal['Residential/Commercial'] == '_None-')
	{
		array_push($error['error'], 'please choose residential or commercial in deal.');
	}
	if(!$deal['Deal_ID'])
	{
		array_push($error['error'], 'please enter a deal id in deal.');
	}

	if($error['error'])
	{
		$errors = json_encode($error);
	}
	else
	{
		return true;
	}
}