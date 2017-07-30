<?php

	namespace Wsi\CommTypes;

	use Wsi\SiteSystemOptions;

	class Almnet extends CommTypes
	{
		public function __construct(array $deal, SiteSystemOptions $options)
		{
			parent::__construct($deal, $options);

			$this->options
				->setCellProv("ALMNET")
				->addOption("CELLMAC", $this->deal["TC Mac ID"])
				->addOption("CELLCRC", $this->deal["TC CRC"]);
		}

		protected $classes = [
			"Service Plan"        => "Wsi\SvcPlans\AlmnetSvcplan",

			"Advertising Service" => "Wsi\AdvSvcs\AlmnetAdvSvc",

			"Information Service" => "Wsi\InfSvcs\AlmnetInfSvc",

			"Doorbell Camera"     => "Wsi\DoorbellCamera\AlmnetDoorbellCamera",

			"Interactive Service" => "Wsi\IntSvcs\AlmnetIntsvc",

			"Protection Logic"    => "Wsi\Apl\AlmnetApl",

			"Automation Service"  => "Wsi\AutSvcs\AlmnetAutSvc",

			"GPS Basic"           => "Wsi\GpsSvcs\GpsBas",

			"GPS Enhanced"        => "Wsi\GpsSvcs\GpsEnh",

			"Video Service"       => "Wsi\VidSvcs\AlmnetVidSvc",
		];
	}