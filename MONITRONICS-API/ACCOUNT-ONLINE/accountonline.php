<?php

class AccountOnline
{
    private $appID = 'WSI';
    private $username;
    private $password;
    private $deal;
    private $contact;
    public $postVariables = array();

    public function __construct($username, $password, $deal, $contact)
    {
        $this->username = $username;
        $this->password = $password;
        $this->deal = $deal;
        $this->contact = $contact;
    }

    public function AccountOnline()
    {
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"     xmlns:midi="https://mimasweb.monitronics.net/MIDI/">
					<soapenv:Header>
					<midi:ApplicationIDHeader>
					<midi:appID>' . $this->appID . '</midi:appID>
					</midi:ApplicationIDHeader>
					</soapenv:Header>
					<soapenv:Body>
					<midi:AccountOnline>
					<midi:userName>' . $this->username . '</midi:userName>
					<midi:password>' . $this->password . '</midi:password>
					<midi:csNo>' . $this->deal['CS Number'] . '</midi:csNo>
					<midi:xml>' . htmlentities($this->AccountOnlineXml()) . '</midi:xml>
					<midi:creditRequestXml>' . htmlentities($this->CreditRequestXml()) . '</midi:creditRequestXml>
					<midi:purchaseInfoXml>' . htmlentities($this->PurchaseInfoXml()) . '</midi:purchaseInfoXml>
					</midi:AccountOnline>
					</soapenv:Body>
					</soapenv:Envelope>';

        return $xml;
    }

    private function AccountOnlineXml()
    {
        $name = explode(' ', $this->deal['Contact Name']);

        if (sizeof($name) > 2)
        {
            $first_name = trim($name[1]);
            $last_name = trim($name[2]);
        }
        else
        {
            $first_name = trim($name[0]);
            $last_name = trim($name[1]);
        }

        $install_date = explode(' ', $this->deal['Install Date and Time']);

        $install_date = trim($install_date[0]);

        $site_state = 'P';

        $site_type = $this->deal['Residential/Commercial'];

	    $site_name = "";
        if ($site_type == 'Residential')
        {
            $site_type = 'RBFM';
            $site_name = ucfirst($first_name) . ' ' . ucfirst($last_name);
        }
        elseif ($site_type == 'Commercial')
        {
            $site_type = 'CBFM';
            $site_name = $this->deal['Account Name'];
        }

        $system_type = $this->deal['Panel Type'];

        $account_type = $this->deal['Account Type'];

        //Go Control 2 Panel
        if ($system_type == 'Go Control')
        {
            if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
            {
                $system_type = '20S001';

                $secondary_system_type = '';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                if ($account_type == 'Digital w/2Way')
                {
                    $twoway_device = ' twoway_device_id="20S001"';
                }
            }
            elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
            {
                $system_type = 'A2C007';

                $secondary_system_type = ' sec_systype_id="20S001"';

                $panel_phone = ' ';

                if ($account_type == 'Cell w/2Way')
                {
                    $twoway_device = ' twoway_device_id="20S001"';
                }
            }
            elseif ($account_type == 'Digital w/Cell')
            {
                $system_type = '20S001';

                $secondary_system_type = ' sec_systype_id="A2C007"';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                $twoway_device = ' ';
            }
        }

        //Go Control 3 Panel
        elseif ($system_type == 'Go Control 3')
        {
            if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
            {
                $system_type = '20S002';

                $secondary_system_type = '';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                if ($account_type == 'Digital w/2Way')
                {
                    $twoway_device = ' twoway_device_id="20S002"';
                }
            }
            elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
            {
                $system_type = 'A2C020';

                $secondary_system_type = ' sec_systype_id="20S002"';

                $panel_phone = ' ';

                if ($account_type == 'Cell w/2Way')
                {
                    $twoway_device = ' twoway_device_id="20S002"';
                }
            }
            elseif ($account_type == 'Digital w/Cell')
            {
                $system_type = '20S002';

                $secondary_system_type = ' sec_systype_id="A2C020"';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                $twoway_device = ' ';
            }
        }

        //GE Simon
        elseif ($system_type == 'GE Simon XTi' || $system_type == 'GE Simon XTi-5')
        {
            if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
            {
                $system_type = 'G2S014';

                $secondary_system_type = '';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                if ($account_type == 'Digital w/2Way')
                {
                    $twoway_device = ' twoway_device_id="G2S014"';
                }
            }
            elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
            {
                $system_type = 'A2C019';

                $secondary_system_type = ' sec_systype_id="G2S014"';

                $panel_phone = ' ';

                if ($account_type == 'Cell w/2Way')
                {
                    $twoway_device = ' twoway_device_id="G2S014"';
                }
            }
            elseif ($account_type == 'Digital w/Cell')
            {
                $system_type = 'G2S014';

                $secondary_system_type = ' sec_systype_id="A2C019"';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                $twoway_device = ' ';
            }
        }

        //GE Concord 4
        elseif ($system_type == 'GE Concord 4')
        {
            if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
            {
                $system_type = 'G2S005';

                $secondary_system_type = '';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                if ($account_type == 'Digital w/2Way')
                {
                    $twoway_device = ' twoway_device_id=""';
                }
            }
            elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
            {
                $system_type = 'A2C003';

                $secondary_system_type = ' sec_systype_id="G2S005"';

                $panel_phone = ' ';

                if ($account_type == 'Cell w/2Way')
                {
                    $twoway_device = ' twoway_device_id=""';
                }
            }
            elseif ($account_type == 'Digital w/Cell')
            {
                $system_type = 'G2S005';

                $secondary_system_type = ' sec_systype_id="A2C003"';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                $twoway_device = ' ';
            }
        }

        //Qolsys IQ 1
        elseif ($system_type == 'Qolsys IQ 1')
        {
            if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
            {
                $system_type = 'I2S001';

                $secondary_system_type = '';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                if ($account_type == 'Digital w/2Way')
                {
                    $twoway_device = ' twoway_device_id=""';
                }
            }
            elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
            {
                $system_type = 'A2C013';

                $secondary_system_type = ' sec_systype_id="I2S001"';

                $panel_phone = ' ';

                if ($account_type == 'Cell w/2Way')
                {
                    $twoway_device = ' twoway_device_id=""';
                }
            }
            elseif ($account_type == 'Digital w/Cell')
            {
                $system_type = 'I2S001';

                $secondary_system_type = ' sec_systype_id="A2C013"';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                $twoway_device = ' ';
            }
        }

        //DSC NEO
        elseif ($system_type == 'DSC NEO')
        {
            if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
            {
                $system_type = 'D2S044';

                $secondary_system_type = '';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                if ($account_type == 'Digital w/2Way')
                {
                    $twoway_device = ' twoway_device_id=""';
                }
            }
            elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
            {
                $system_type = 'A2C017';

                $secondary_system_type = ' sec_systype_id="D2S044"';

                $panel_phone = ' ';

                if ($account_type == 'Cell w/2Way')
                {
                    $twoway_device = ' twoway_device_id=""';
                }
            }
            elseif ($account_type == 'Digital w/Cell')
            {
                $system_type = 'D2S044';

                $secondary_system_type = ' sec_systype_id="A2C017"';

                $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

                $twoway_device = ' ';
            }
        }

        //HONEYWELL LYNX 7000
        elseif ($system_type == 'Honeywell L7000')
        {
        	$cellType = ["ILP5 Internet" => "H2C020", "L5100-WIFI Module" => "H2C024", "3GL/4GL" => "H2C028", "3G/4G & L5100 WiFi" => "H2C033", "4GLT/ILP5 Inet" => "H2C035", "L57 CDMA" => "H2C037"];

	        if ($account_type == 'Digital' || $account_type == 'Digital w/2Way')
	        {
		        $system_type = 'H2S060';

		        $secondary_system_type = '';

		        $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

		        if ($account_type == 'Digital w/2Way')
		        {
			        $twoway_device = ' twoway_device_id="H2S060"';
		        }
	        }
	        elseif ($account_type == 'Cell Primary' || $account_type == 'Cell w/2Way')
	        {
		        $system_type = $cellType[$this->deal["Cell Type"]];

		        $secondary_system_type = ' sec_systype_id="H2S060"';

		        $panel_phone = ' ';

		        if ($account_type == 'Cell w/2Way')
		        {
			        $twoway_device = ' twoway_device_id="H2S060"';
		        }
	        }
	        elseif ($account_type == 'Digital w/Cell')
	        {
		        $system_type = $cellType[$this->deal["Cell Type"]];

		        $secondary_system_type = ' sec_systype_id="H2S060"';

		        $panel_phone = ' panel_phone="' . $this->postVariables['panelPhone'] . '"';

		        $twoway_device = ' ';
	        }
        }

        /**
         * if state is null or empty, use province
         */
        $state = ($this->deal['State']) ? $this->deal['State'] : $this->deal['Province'];

        /**
         * if zip is null or empty, use postal code
         */
        $zip = ($this->deal['Zip']) ? $this->deal['Zip'] : $this->deal['Postal Code'];

        $xml = '<Account xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
		
				<SiteSystems>
		
				<SiteSystem
		
				city_name="' . $this->deal["City"] . '"
		
				codeword1="' . $this->postVariables["codeword"] . '"
		
				county_name="' . $this->deal["County"] . '"
		
				cross_street="' . $this->postVariables["crossStreet"] . '"
		
				cspart_no="350"
		
				ext1=""
		
				ext2=""
		
				install_servco_no="' . $this->postVariables["dealerId"] . '"
		
				lang_id="ENG"
		
				map_coord="' . $this->postVariables["map_coord"] . '"
		
				map_page="' . $this->postVariables["map_page"] . '"
		
				phone1="' . $this->postVariables["homePhone"] . '"
		
				servco_no="' . $this->postVariables["dealerId"] . '"
		
				site_addr1="' . $this->deal["Address.inc"] . '"
		
				site_name="' . $site_name . '"
		
				sitestat_id="' . $site_state . '"
		
				sitetype_id="' . $site_type . '"
		
				state_id="' . $state . '"
		
				subdivision="' . $this->deal["Subdivision"] . '"
		
				systype_id="' . $system_type . '"' .

            $secondary_system_type .

            $twoway_device .

            ' receiver_phone="' . $this->deal["Receiver Phone"] . '"' .

            $panel_phone .

            ' panel_location="' . $this->postVariables["panelLocation"] . '"
		
				install_date="' . $install_date . '"
		
				panel_code="ffffff"
		
				zip_code="' . $zip . '"
		
				/>
		
				</SiteSystems>
		
				<Zones>' . $this->postVariables["zones"] . '</Zones>
		
				<SiteAgencyPermits>' . $this->postVariables["agencies"] . '</SiteAgencyPermits>
		
				<Contacts>' . $this->postVariables["contacts"] . '</Contacts>
		
				<SiteOptions>' . $this->SiteOptionsXml() . '</SiteOptions>
		
				<SiteSystemOptions>' . $this->SiteSystemOptionsXml() . '</SiteSystemOptions>
		
				</Account>';

        return $xml;
    }

    private function SiteSystemOptionsXml()
    {
        /**
         * @todo need to pull need to pull from database on a company level.
         * @var $installer_code
         */
        $installer_code = "3519";

        $site_type = $this->deal["Residential/Commercial"];

        $monitoring_level = $this->deal["Monitoring Level"];

        /**
         * @todo need to make this dynamic once we start using other cell providers
         * @var $cell_provider
         */
        $cell_provider = "ALMCOM";

        $cell_service = "";
        if ($site_type == "Commercial")
        {
            $cell_service = "CBI";
        }
        elseif ($site_type == "Residential")
        {
            $cell_service = "RBI";
        }

        $xml = '<SiteSystemOption option_id="DSL-VOIP" option_value="NONE" />
		
				<SiteSystemOption option_id="INST CODE" option_value="' . $installer_code . '" />
		
				<SiteSystemOption option_id="PRIVACY" option_value="N" />
		
				<SiteSystemOption option_id="SIGFMT" option_value="CID" />
		
				<SiteSystemOption option_id="TRANSFORMER" option_value="' . $this->postVariables["transformerLocation"] . '" />
		
				<SiteSystemOption option_id="CELLMAC" option_value="' . $this->postVariables["adcSerial"] . '" />
		
				<SiteSystemOption option_id="CELLPROV" option_value="' . $cell_provider . '" />
		
				<SiteSystemOption option_id="ALMCOMINTSVC" option_value="' . $cell_service . '" />';


        if ($this->deal["Panel Type"] != "GE Concord 4")
        {
            $xml .= '<SiteSystemOption option_id="ALMCOMWEATHER" option_value="" />
		
					<SiteSystemOption option_id="ALMCOMSEVEREWEATHER" option_value="" />';
        }

        if ($monitoring_level == "Interactive Gold")
        {
            $xml .= '<SiteSystemOption option_id="ALMCOMIMGSNSRALRMS" option_value="" />
		
					<SiteSystemOption option_id="ALMCOMGARAGEDOOR" option_value="" />
		
					<SiteSystemOption option_id="ALMCOMEMPWRENERGY" option_value="" />
		
					<SiteSystemOption option_id="ALMCOMEMPWRLOCKS" option_value="" />
		
					<SiteSystemOption option_id="ALMCOMLIFTMASTER" option_value="" />';
        }

        return $xml;
    }

    private function SiteOptionsXml()
    {
        $purchase_status = $this->postVariables["centralStation"];

        if ($purchase_status == "Moni PUR")
        {
            $purchase_status = "PUR";
        }
        elseif ($purchase_status == "Moni CM")
        {
            $purchase_status = "CM";
        }

        $contract_length = $this->deal["Contract Term"];

        $contract_length = explode(' ', $contract_length);

        $contract_length = trim($contract_length[0]);

        $xml = '<SiteOption option_id="CONTRLEN" option_value="' . $contract_length . '" />
		
				<SiteOption option_id="CMPUR" option_value="' . $purchase_status . '" />';

        return $xml;
    }

    private function PurchaseInfoXml()
    {
        $xml = '<PurchaseInfo xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		
				<CS>' . $this->deal["CS Number"] . '</CS>
		
				<RMR>' . $this->deal["RMR"] . '</RMR>
		
				<DealerId>' . $this->postVariables["dealerId"] . '</DealerId>
		
				<UserId>' . $this->username . '</UserId>
		
				<LastUpdated>' . $this->deal["LastUpdated"] . '</LastUpdated>
		
				<Source>' . $this->deal["Source"] . '</Source>
		
				</PurchaseInfo>';

        return $xml;
    }

    private function CreditRequestXml()
    {
        $bureau_id = $this->deal["BureauID"];

        if ($bureau_id == "Trans Union")
        {
            $bureau_id = "1";
        }
        elseif ($bureau_id == "Equifax")
        {
            $bureau_id = "5";
        }
        elseif ($bureau_id == "Experian")
        {
            $bureau_id = "7";
        }

        $street_address = $this->contact["Mailing Street"];

        $street_address = explode(" ", $street_address);

        $StreetNumber = $street_address[0];

        $StreetName = "";
        for ($i = 1; $i < sizeof($street_address); $i++)
        {
            $StreetName .= $street_address[$i] . " ";
        }

        $xml = '<CreditRequest xmlns:i="http://www.w3.org/2001/XMLSchema-instance"  xmlns="http://schemas.datacontract.org/2004/07/CreditReporting.DataController">
		
				<CS>' . $this->deal["CS Number"] . '</CS>
		
				<SSN>' . $this->contact["Social Security Number"] . '</SSN>
		
				<FirstName>' . $this->contact["First Name"] . '</FirstName>
		
				<LastName>' . $this->contact["Last Name"] . '</LastName>
		
				<StreetNumber>' . trim($StreetNumber) . '</StreetNumber>
		
				<StreetName>' . trim($StreetName) . '</StreetName>
		
				<City>' . $this->contact["Mailing City"] . '</City>
		
				<State>' . $this->contact["Mailing State"] . '</State>
		
				<Zip>' . $this->contact["Mailing Zip"] . '</Zip>
		
				<DealerId>' . $this->postVariables["dealerId"] . '</DealerId>
		
				<UserId>' . $this->username . '</UserId>
		
				<FICO>' . $this->contact["Credit Score"] . '</FICO>
		
				<RequestDate>' . $this->deal["Request Date"] . '</RequestDate>
		
				<TransactionID>' . $this->contact["Transaction Number"] . '</TransactionID>
		
				<Token>' . $this->contact["Credit Token"] . '</Token>
		
				<BureauID>' . $bureau_id . '</BureauID>
		
				</CreditRequest>';

        return $xml;
    }
}