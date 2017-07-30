<?php

class GetData
{
    public $zip;
    public $end_date;
    public $start_date;

    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function Get($entity, $customerNumber = false)
    {

        switch(strtolower($entity))
        {
            case 'agencies':
                $xmldata = htmlentities($this->AgencyZipXml($this->zip));
                break;
            case 'eventhistories':
                if($this->start_date != null && $this->end_date != null)
                {
                    $xmldata = htmlentities($this->EventHistoryXml($this->start_date, $this->end_date));
                }
                break;
        }

        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
        <GetData xmlns="https://mimasweb.monitronics.net/MIDI/">
        <Entity>'.$entity.'</Entity>
        <UserID>'.$this->username.'</UserID>
        <Password>'.$this->password.'</Password>
        <CustomerNumber>'.$customerNumber.'</CustomerNumber>
        <XMLData>'.$xmldata.'</XMLData>
        </GetData>
        </soap:Body>
        </soap:Envelope>';

        return $xml;
    }

    private function AgencyZipXml($zip)
    {
	    return '<GetAgencies xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	    <GetAgency zip_code="'.$zip.'" />
	    </GetAgencies>';
    }

    private function EventHistoryXml($start_date, $end_date)
    {
	    return '<?xml version="1.0"?>
        <GetEventHistories xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
        <GetEventHistory start_date="'.$start_date.'" end_date="'.$end_date.'" />
        </GetEventHistories>';
    }
}