<?php

	namespace Wsi\Apl;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetApl extends SystemOptions
	{
		protected $systemOption = "ALMNETAPL";

		protected $validValues = [
			"gsm"  => "G",
			"inet" => "I",
			"igsm" => "IG",
		];
	}