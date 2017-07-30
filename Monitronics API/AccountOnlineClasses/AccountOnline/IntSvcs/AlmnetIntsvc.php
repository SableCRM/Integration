<?php

	namespace Wsi\IntSvcs;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetIntsvc extends SystemOptions
	{
		protected $systemOption = "ALMNETINTSVC";

		protected $validValues = [
			"gsm enhanced"               => "T1G",
			"inetbasic"                  => "T1I",
			"igsm enhanced"              => "T1IG",
			"tc1 standalone video"       => "T1SV",
			"total connect basic/gsm"    => "T2BG",
			"total connect basic/inet"   => "T2BI",
			"total connect basic/igsm"   => "T2BIG",
			"total connect plus/gsm"     => "T2PG",
			"total connect plus/inet"    => "T2PI",
			"total connect plus/igsm"    => "T2PIG",
			"total connect premium/gsm"  => "T2RG",
			"total connect premium/inet" => "T2RI",
			"total connect premium/igsm" => "T2RIG",
			"tc2 standalone video"       => "T2SV",
		];
	}