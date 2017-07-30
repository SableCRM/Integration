<?php

	namespace Wsi\DoorbellCamera;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetDoorbellCamera extends SystemOptions
	{
		protected $systemOption = "ALMNETDOORBELLCAMERA";

		protected $validValues = [
			"true"  => "",
			"false" => "",
		];
	}