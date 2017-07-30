function url_split(url){
	let firstSplit = url.replace(/%20/g, ' ');
	firstSplit = firstSplit.match(/\w+=[a-zA-z\s]+|\w+=\w+|\w+=|\w+/g);

	let obj = {};
	let secondSplit = '';
	firstSplit.forEach(function(item){
		secondSplit = item.match(/[a-zA-z0-9\s]+/g);
    if(!secondSplit[1]){
    	secondSplit[1] = '';
    }
  	obj[secondSplit[0]] = secondSplit[1];
	});
  
  return obj;
}