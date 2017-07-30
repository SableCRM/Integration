<?php

	namespace Wsi\SiteSystemOptions;

	use Wsi\SiteSystemOptions;

	class AlmnetClassMapper
	{
		protected $deal;

		protected $siteSystemOptions;

		public function __construct(array $deal, SiteSystemOptions $siteSystemOptions)
		{
			$this->deal = $deal;

			$this->siteSystemOptions = $siteSystemOptions;

			$this->siteSystemOptions
				->setDslVoip("None")
				->setPrivacy("N")
				->setSigFmt("CID")
				->setCellProv("ALMNET")
				->setInstCode($this->deal["Installer Code"])
				->addOption("TRANSFORMER", $this->deal["Transformer Location"])
				->addOption("CELLMAC", $this->deal["TC Mac ID"])
				->addOption("CELLCRC", $this->deal["TC CRC"]);
		}

		public function setOptions()
		{
			$options = $this->mapClasses();

			foreach($options as $optionKey => $optionValue){
				if($this->deal[$optionKey] != "-None-" && $this->deal[$optionKey] != "false"){
					$this->siteSystemOptions->setSystemOption(new $optionValue($this->deal[$optionKey]));
				}
			}

			return $this->siteSystemOptions->getOptions();
		}

		protected function mapClasses()
		{
			return $systemOptions = [
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
	}