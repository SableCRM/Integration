/**
 * Created by razam on 3/14/2017.
 */
function ParseJson(string, debug){
    let jsonString = '';
    if(string.match(/"\[\\"{.+}\\"]"/)){
        jsonString = JSON.parse(string);
        if(debug){
            console.log('first stage: ' + jsonString);
        }
    }else{
        jsonString = string;
    }
    try{
        jsonString = JSON.parse(jsonString);
        if(debug){
            console.log('second stage: ' + jsonString);
            console.log('second stage: ' + jsonString.length);
        }
        if(jsonString.length > 1){
            let strings = [];
            for(let i = 0; i < jsonString.length; i++){
                strings.push(JSON.parse(jsonString[i]));
                if(debug){
                    console.log('third stage: ' + jsonString[i]);
                }
            }
            return strings;
        }else{
            return jsonString;
        }
    }catch(ex){
        return{
            error : true,
            message : ex,
            input : string
        }
    }
}
