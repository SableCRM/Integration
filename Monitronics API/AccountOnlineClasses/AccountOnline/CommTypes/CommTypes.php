<?php

	namespace Wsi\CommTypes;

	use Wsi\interfaces\ICommType;
	use Wsi\SiteSystemOptions;

	class CommTypes implements ICommType
	{
		protected $options;

		protected $classes;

		protected $deal;

		public function __construct(array $deal, SiteSystemOptions $options)
		{
			$this->options = $options;

			$this->deal    = $deal;

			$this->options
				->setDslVoip("None")
				->setPrivacy("N")
				->setSigFmt("CID")
				->setInstCode(($this->deal["Installer Code"]) ? $this->deal["Installer Code"] : "3519")
				->addOption("TRANSFORMER", $this->deal["Transformer Location"]);
		}

		public function setOptions()
		{
			foreach($this->classes as $optionKey => $optionValue)
			{
				if(!in_array(strtolower($this->deal[$optionKey]), ["-none-", "null", "false"]))
				{
					$this->options->setSystemOption(new $optionValue($this->deal[$optionKey]));
				}
			}

			return $this->options->getOptions();
		}
	}