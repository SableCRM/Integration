function process(method, url, data, callback)
{
	let xmlHttp = createXmlHttpRequestObject();

	function createXmlHttpRequestObject() 
	{
		let xmlHttp;
		
		if (window.XMLHttpRequest) 
		{
			xmlHttp = new XMLHttpRequest();
		} 
		
		else 
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		return xmlHttp;
	}

	if (xmlHttp) 
	{
		try 
		{
			xmlHttp.open(method, url, true);
			
			xmlHttp.onload = callback;
			
			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			
			xmlHttp.send(data);	
		} 
		
		catch (ex) 
		{
			alert(ex.toString());
		}
	}
}