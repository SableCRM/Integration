<?php

	namespace Wsi\CommTypes;

	use Wsi\SiteSystemOptions;

	class Almcom extends CommTypes
	{
		public function __construct(array $deal, SiteSystemOptions $options)
		{
			parent::__construct($deal, $options);

			$this->options
				->setCellProv("ALMCOM")
				->addOption("ALMCOMINTSVC", $this->getSiteType())
				->addOption("CELLMAC", $this->deal["ADC Serial Number"]);

			$this->addAdcAddons();

			if(sizeof($this->classes) > 0)
			{
				foreach($this->classes as $adcOptionKey => $adcOptionValue)
				{
					$this->options->addOption($adcOptionValue, " ");
				}
			}
		}

		private function getSiteType()
		{
			return (strtolower($this->deal["Residential/Commercial"]) == "commercial" ? "CBI" : "RBI");
		}

		private function addAdcAddons()
		{
			if ($this->deal["Panel Type"] != "GE Concord 4")
			{
				$this->classes = ["ALMCOMWEATHER", "ALMCOMSEVEREWEATHER"];
			}

			if ($this->deal["Monitoring Level"] == "Interactive Gold")
			{
				$this->classes = ["ALMCOMIMGSNSRALRMS", "ALMCOMGARAGEDOOR", "ALMCOMEMPWRENERGY", "ALMCOMEMPWRLOCKS", "ALMCOMLIFTMASTER"];
			}
		}

		private $addons = [
			"Alarm.com Video SVR (1)"         => ["ALMCOMVIDEOSVR"       => "1"],
			"Alarm.com Video SVR (2)"         => ["ALMCOMVIDEOSVR"       => "2"],
			"Alarm.com Video SVR (3)"         => ["ALMCOMVIDEOSVR"       => "3"],
			"ALMCOM Arming Schedules"         => ["ALMCOMARMSCHED"       => ""],
			"ALMCOM Doorbell Camera"          => ["ALMCOMDOORBELLCAMERA" => ""],
			"ALMCOM emPower Energy Package"   => ["ALMCOMEMPWRENERGY"    => ""],
			"ALMCOM emPower Lights"           => ["ALMCOMEMPWRLIGHTS"    => ""],
			"ALMCOM emPower Locks"            => ["ALMCOMEMPWRLOCKS"     => ""],
			"ALMCOM emPower Thermostats"      => ["ALMCOMEMPWRTHERM"     => ""],
			"ALMCOM Enterprise Notices"       => ["ALMCOMENTRPRSNTCS"    => ""],
			"ALMCOM Garage Door"              => ["ALMCOMGARAGEDOOR"     => ""],
			"ALMCOM Image Sensor Alarms"      => ["ALMCOMIMGSNSRALRMS"   => ""],
			"ALMCOM Image Sensor Extra (20)"  => ["ALMCOMIMGSNSREXTRA"   => "20"],
			"ALMCOM Image Sensor Extra (40)"  => ["ALMCOMIMGSNSREXTRA"   => "40"],
			"ALMCOM Image Sensor Extra (60)"  => ["ALMCOMIMGSNSREXTRA"   => "60"],
			"ALMCOM Image Sensor Extra (80)"  => ["ALMCOMIMGSNSREXTRA"   => "80"],
			"ALMCOM Image Sensor Extra (100)" => ["ALMCOMIMGSNSREXTRA"   => "100"],
			"ALMCOM Image Sensor Plus"        => ["ALMCOMIMGSNSRPLUS"    => ""],
			"ALMCOM LiftMaster"               => ["ALMCOMLIFTMASTER"     => ""],
			"ALMCOM Light Automation"         => ["ALMCOMLIGHTAUTOMTN"   => ""],
			"ALMCOM Lutron Integration"       => ["ALMCOMLUTRONINT"      => ""],
			"ALMCOM Nest Integration"         => ["ALMCOMNESTINT"        => ""],
			"ALMCOM Normal Activity Mon (5)"  => ["ALMCOMNORMLACTVTY"    => "5"],
			"ALMCOM Normal Activity Mon (10)" => ["ALMCOMNORMLACTVTY"    => "10"],
			"ALMCOM ProVideo (<= 4 cams)"     => ["ALMCOMPROVIDEO"       => ""],
			"ALMCOM ProVideo+ (> 4 cams)"     => ["ALMCOMPROVIDEOPLUS"   => ""],
			"ALMCOM Severe Weather"           => ["ALMCOMSEVEREWEATHER"  => ""],
			"ALMCOM Thermostat Control"       => ["ALMCOMTHERMCONTROL"   => ""],
			"ALMCOM Triggered Videos"         => ["ALMCOMDIGTRIGVIDEO"   => ""],
			"ALMCOM Up & About"               => ["ALMCOMUPABOUT"        => ""],
			"ALMCOM Video Storage (250)"      => ["ALMCOMVIDEOSTORAGE"   => "250"],
			"ALMCOM Video Storage (500)"      => ["ALMCOMVIDEOSTORAGE"   => "500"],
			"ALMCOM Video Storage (750)"      => ["ALMCOMVIDEOSTORAGE"   => "750"],
			"ALMCOM Voice Notify/Alarm"       => ["ALMCOMVOICEALARM"     => ""],
			"ALMCOM Voice Notify/NonAlarm"    => ["ALMCOMVOICENONALARM"  => ""],
			"ALMCOM Water Mgt"                => ["ALMCOMWATERMGT"       => ""],
			"ALMCOM Weather"                  => ["ALMCOMWEATHER"        => ""],
			"ALMCOM Wellness"                 => ["ALMCOMWELLNESS"       => ""],
		];

		private $packages = [
			"Comm Advanced Interactive"   => "CAI",//ALMCOMINTSVC
			"Comm Basic Interactive"      => "CBI",
			"Home Center (Basic/Weather)" => "HMCTR",
			"Interactive"                 => "INT",
			"Interactive+Automation"      => "INTAUT",
			"Interactive Gold"            => "INTGLD",
			"Res Advanced Interactive"    => "RAI",
			"Res Basic Interactive"       => "RBI",
			"Wireless Signal Forwarding"  => "WSF",//ALMCOMSVCPLAN
		];

		public function setOptions()
		{
			return $this->options->getOptions();
		}
	}