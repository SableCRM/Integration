<?php

	namespace Wsi\AutSvcs;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetAutSvc extends SystemOptions
	{
		protected $systemOption = "ALMNETAUTSVCS";

		protected $validValues = [
			"basic/gsm"     => "BG",
			"basic/inet"    => "BI",
			"basic/igsm"    => "BIG",
			"enhanced/gsm"  => "EG",
			"enhanced/inet" => "EI",
			"enhanced/igsm" => "EIG",
		];
	}