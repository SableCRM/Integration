<?php

	namespace Integration;

	class Post
	{
		private $url;
		private $soapAction;

		public function __construct($url, $soapAction)
		{
			$this->url = $url;
			$this->soapAction = $soapAction;
		}

		public function __set($var, $val)
		{
			$this->$var = $val;
		}

		public function Post($action, $xml, $format=false)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$headers = array();

			array_push($headers, "Content-Type: text/xml");

			array_push($headers, "SOAPAction: ".$this->SoapAction($action));

			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$response = curl_exec($ch);
			curl_close($ch);

			if($format)
			{
				return $this->ParseXml($response, $format);
			}
			else
			{
				return $response;
			}
		}

		private function SoapAction($action)
		{
			return $this->soapAction.$action;
		}

		private function ParseXml($result, $format)
		{
			$data = '';

			$result = new \SimpleXMLElement($result);

			foreach ( $result->xpath('//Table') as $key => $value)
			{
				$data[$key] = $value;
			}

			switch(strtolower($format))
			{
				case 'array':
					return $data;
					break;
				case 'json':
					return json_encode($data);
					break;
				default:
					return '{"error":"invalid return format selected"}';
			}
		}
	}