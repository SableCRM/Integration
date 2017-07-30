<?php

class Zoho
{
    private $authToken;
    private $returnFormats = array('json', 'array', 'xml');
    public $zoho_time_format = '%Y-%m-%d %H:%M:%S';

    public function __construct($authToken)
    {
        $this->authToken = $authToken;
    }
    
    
    private static function send($url, $data = false, $post = false){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }


    public static function GenerateToken($user, $password, $appName, $scope){
	    $result = self::send('https://accounts.zoho.com/apiauthtoken/nb/create', 'SCOPE=ZohoCRM/'.$scope.
            '&EMAIL_ID='.$user.'&PASSWORD='.$password.'&DISPLAY_NAME='.$appName, true);
	    if(preg_match('/=(.{32})/', $result, $authToken)){
            return $authToken[1];
	    } else{
            return false;
        }
    }
    
    
    public function Set($module, $id, $data)
    {
        $module = ucfirst($module);
        
        if($data)
        {
            return self::send('https://crm.zoho.com/crm/private/json/'.$module.'/updateRecords',
                'authtoken='.$this->authToken.'&scope=crmapi&wfTrigger=true&id='.$id.'&xmlData='.urlencode($this->ZohoData($module, $data)),
                true);
        }

        else
        {
            die('{"error":"please enter valid data, can\'t be empty!"}');
        }
    }


    public function Insert ($module, $data){
        $module = ucfirst($module);

        if($data){
            $zoho =  self::send('https://crm.zoho.com/crm/private/json/'.$module.'/insertRecords', 'newFormat=1&duplicateCheck=2&authtoken='.
                $this->authToken.'&scope=crmapi&wfTrigger=true&xmlData='.urlencode($this->ZohoData($module, $data)), true);
            return $zoho;
        }
        else
        {
            die('{"error":"please enter valid data, can\'t be empty!"}');
        }
    }

    public function getRelatedRecords($module, $parentModule, $id, $format){
        $module = ucfirst($module);
        $parentModule = ucfirst($parentModule);
        $zoho = self::send("https://crm.zoho.com/crm/private/json/".$module."/getRelatedRecords", "authtoken=".$this->authToken."&scope=crmapi&id=".$id.
            "&parentModule=".$parentModule, true);

        switch(strtolower($format))
        {
            case 'xml':
                return $zoho;
                break;
            case 'json':
                return json_encode($this->FormatZohoData($zoho, $module));
                break;
            case 'array':
                return $this->FormatZohoData($zoho, $module);
                break;
        }
    }
    
    
    public function Get($module, $id, $format)
    {
        $module = ucfirst($module);
        
        if(in_array($format, $this->returnFormats))
        {
            $zoho = self::send('https://crm.zoho.com/crm/private/json/'.$module.'/getRecordById',
                'authtoken='.$this->authToken.'&scope=crmapi&id='.$id, true);
    
            switch(strtolower($format))
            {
                case 'xml':
                    return $zoho;
                    break;
                case 'json':
                    return json_encode($this->FormatZohoData($zoho, $module));
                    break;
                case 'array':
                    return $this->FormatZohoData($zoho, $module);
                    break;
            }
        }
        else
        {
            die('{"error":"invalid return format selected"}');
        }
    }
    
    
    private function FormatZohoData($zohoresult, $module)
	{
        $zoho = null;

		$result = json_decode($zohoresult)->response->result->$module->row->FL;

		for($i = 0; $i < sizeof($result); $i ++)
		{
			$zoho[$result[$i]->val] = $result[$i]->content;
		}

		return $zoho;
	}
	
	
    private function ZohoData($module, $data)
    {
        $fields = '';

        $data = json_decode($data);

        foreach($data as $key => $value)
        {
            $fields .= '<FL val="'.$key.'">'.$value.'</FL>';
        }

        return '<'.$module.'><row no="1">'.$fields.'</row></'.$module.'>';
    }
}