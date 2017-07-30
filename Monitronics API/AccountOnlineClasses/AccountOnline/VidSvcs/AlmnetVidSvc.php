<?php

	namespace Wsi\VidSvcs;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetVidSvc extends SystemOptions
	{
		protected $systemOption = "ALMNETVIDSVCS";

		protected $validValues = [
			"tc1 gsm"           => "T1G",
			"tc1 inet"          => "T1I",
			"tc1 igsm"          => "T1IG",
			"tc1 optiflex gsm"  => "T10G",
			"tc1 optiflex inet" => "T10I",
			"tc1 optiflex igsm" => "T10IG",
			"tc2 gsm"           => "T2G",
			"tc2 inet"          => "T2I",
			"tc2 igsm"          => "T2IG",
		];
	}