<?php

	namespace Wsi\IntSvcs;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmcomIntsvc extends SystemOptions
	{
		protected $systemOption = "ALMCOMINTSVC";

		protected $validValues = [
			"1" => "CAI",
			"2" => "CBI",
			"3" => "HMCTR",
			"4" => "INT",
			"5" => "INTAUT",
			"6" => "INTGLD",
			"7" => "RAI",
			"8" => "RBI",
		];
	}