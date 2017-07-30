<?php
	namespace Wsi\SvcPlans;

	use Wsi\SiteSystemOptions\SystemOptions;

	class AlmnetSvcplan extends SystemOptions
	{
		protected $systemOption = "ALMNETSVCPLAN";

		protected $validValues = [
			"ipgsm daily (gsm fire) suprvsn" => "S1DFG",
			"gsm daily supervision"          => "S1DG",
			"gsm daily supervision hi-usage" => "S1DHG",
			"inet daily supervision"         => "S1DI",
			"igsm daily supervision"         => "S1DIG",
			"inet hourly supervision"        => "S1HI",
			"inet 90-sec supervision"        => "S1MI",
			"gsm monthly supervision"        => "S30DG",
			"inet monthly supervision"       => "S30DI",
			"igsm monthly supervision"       => "S30DIG",
			"inet 3-min supervision"         => "S3MI",
			"ipgsm 5m (gsm fire) suprvsn"    => "S5MFG",
			"ipgsm 5m (inet fire) suprvsn"   => "S5MFI",
			"gsm 5m supervision"             => "S5MG",
			"inet 5-min supervision"         => "S5MI",
			"igsm 5m supervision"            => "S5MIG",
			"gsm unsupervised"               => "SUG",
			"gsm unsupervised hi-usage"      => "SUHG",
			"inet unsupervised"              => "SUI",
			"igsm unsupervised"              => "SUIG",
			"gsm 200-second supervision"     => "SUL2G",
			"igsm ul 200-second supervision" => "SUL2IG",
		];
	}