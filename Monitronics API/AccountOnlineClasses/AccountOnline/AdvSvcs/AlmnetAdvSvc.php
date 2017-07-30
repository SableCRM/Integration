<?php

	namespace Wsi\AdvSvcs;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetAdvSvc extends SystemOptions
	{
		protected $systemOption = "ALMNETADVSVCS";

		protected $validValues = [
			"gsm"  => "G",
			"inet" => "I",
			"igsm" => "IG",
		];
	}