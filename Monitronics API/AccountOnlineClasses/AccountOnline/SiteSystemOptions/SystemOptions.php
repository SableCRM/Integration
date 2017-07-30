<?php

	namespace Wsi\SiteSystemOptions;

	use Wsi\interfaces\ISetSystemOption;

	class SystemOptions implements ISetSystemOption
	{
		protected $systemOption;

		protected $option;

		public function __construct($value)
		{
			$this->option = $value;
		}

		protected $validValues = [
			"1 device"    => "1",
			"2 devices"   => "2",
		];

		public function setSystemOption()
		{
			$option = strtolower(trim($this->option));

			if(array_key_exists($option, $this->validValues))
			{
				return $this->validValues[$option];
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value ".$option.", for \"".$this->systemOption."\". Must be ".implode(", ", $this->validValues));
			}
		}

		function getService()
		{
			return $this->systemOption;
		}
	}