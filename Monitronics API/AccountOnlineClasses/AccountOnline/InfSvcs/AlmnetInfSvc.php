<?php

	namespace Wsi\InfSvcs;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetInfSvc extends SystemOptions
	{
		protected $systemOption = "ALMNETINFSVCS";

		protected $validValues = [
			"basic/gsm"     => "BG",
			"basic/inet"    => "BI",
			"basic/igsm"    => "BIG",
			"enhanced/gsm"  => "EG",
			"enhanced/inet" => "EI",
			"enhanced/igsm" => "EIG",
		];
	}