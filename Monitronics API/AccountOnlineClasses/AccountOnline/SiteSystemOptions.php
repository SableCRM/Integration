<?php

	namespace Wsi;

	use Wsi\interfaces\IOptions;
	use Wsi\interfaces\ISetSystemOption;

	class SiteSystemOptions implements IOptions
	{
		protected $siteSystemOptions = [];

		public function __construct(array $options = [])
		{
			$this->setOptions($options);
		}

		public function setDslVoip($value)
		{
			$validValues = [1 => "DSL", "VOIP", "NONE", "BOTH"];

			if($key = array_search(strtoupper($value), $validValues))
			{
				$this->setOptions(["DSL-VOIP" => $validValues[$key]]);
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value for \"DSL-Voip\". Must be ".implode(", ", $validValues));
			}

			return $this;
		}

		public function setInstCode($value)
		{
			if(preg_match("/^(\d{4}$)||()/", $value))
			{
				$this->setOptions(["INST CODE" => $value]);
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value for \"INST CODE\". Must be numeric and 4 digits ins length");
			}

			return $this;
		}

		public function setPrivacy($value)
		{
			$validValues = [1 => "Y", "N"];

			if($key = array_search(strtoupper($value), $validValues))
			{
				$this->setOptions(["PRIVACY" => $validValues[$key]]);
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value for \"PRIVACY\". Must be ".implode(", ", $validValues));
			}

			return $this;
		}

		public function setSigFmt($value)
		{
			$validValues = [1 => "CID", "SIA"];

			if($key = array_search(strtoupper($value), $validValues))
			{
				$this->setOptions(["SIGFMT" => $validValues[$key]]);
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value for \"SIGFMT\". Must be ".implode(", ", $validValues));
			}

			return $this;
		}

		public function setCellProv($value)
		{
			$validValues = [1 => "ALMCOM", "ALMNET", "TELULR", "UPLINK"];

			if($key = array_search(strtoupper($value), $validValues))
			{
				$this->setOptions(["CELLPROV" => $validValues[$key]]);
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value for \"CELLPROV\". Must be ".implode(", ", $validValues));
			}

			return $this;
		}

		public function addOption($service, $value = "")
		{
			if(!is_null($value) && !empty($value))
			{
				$this->setOptions([strtoupper($service) => $value]);
			}

			return $this;
		}

		public function setSystemOption(ISetSystemOption $systemOption)
		{
			$this->setOptions([$systemOption->getService() => $systemOption->setSystemOption()]);

			return $this;
		}

		public function setSiteType($service, $value)
		{
			$validValues = [1 => "CBUR", "CBFM", "CBF", "CFIR", "ULF", "RBUR", "RBFM", "RBF", "RFIR", "RMED"];

			if($key = array_search(strtoupper($value), $validValues))
			{
				$this->setOptions([$service => $validValues[$key]]);
			}
			else
			{
				throw new \InvalidArgumentException("Invalid value for \"$service\". Must be ".implode(", ", $validValues));
			}

			return $this;
		}

		public function setOptions(array $options)
		{
			$siteSystemOptions = $options;

			if(count($siteSystemOptions) > 0)
			{
				foreach($siteSystemOptions as $key => $val)
				{
					$this->siteSystemOptions[$key] = $val;
				}
			}

			return $this;
		}

		public function getOptions()
		{
			$siteSystemOptionXml = "";

			foreach($this->siteSystemOptions as $key => $val)
			{
				$siteSystemOptionXml .= "<SiteSystemOption option_id=\"$key\" option_value=\"$val\" />";
			}

			return $siteSystemOptionXml;
		}
	}