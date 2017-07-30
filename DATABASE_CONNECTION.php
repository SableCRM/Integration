<?php

//function Connect($query, $bindParameters, $format){
//
//    $result = new stdClass();
//    $formats = array('array', 'json');
//
//    if(in_array(strtolower($format), $formats)){
//        try{
//            $handler = new PDO('mysql:dbname=sablrcrm_test; host=50.87.144.13', 'sablrcrm_287f_cg', 'W#(!8l=&%@Na');
//            $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//            $query = $handler->prepare($query);
//
//            $query->execute($bindParameters);
//
//            if($query->rowCount() > 0){
//                $row = $query->fetchAll(PDO::FETCH_OBJ);
//
//                switch($format){
//                    case 'array':
//                        $result = $row;
//                        break;
//
//                    case 'json':
//                        $result = json_encode($row);
//                        break;
//                }
//            }else{
//                $result->status = false;
//                $result->message = 'THERE ARE NO RESULTS FOR THIS QUERY';
////                $result->output = $query->fetchAll(PDO::FETCH_OBJ);
//
//                switch($format){
//                    case 'array':
//                        break;
//
//                    case 'json':
//                        $result = json_encode($result);
//                        break;
//                }
//            }
//        }catch(PDOException $ex){
//            $result = $ex->getMessage();
//        }
//    }else{
//        $result->status = false;
//        $result->message = 'INVALID RETURN FORMAT SELECTED';
//    }
//    return $result;
//}

/**
 * @param $query, a string for the desired query or an array containing a string for the first parameter representing the query
 *and and an array as the second parameter representing the parameters to bind to the query;
 * @param $bindParameters, an array of parameters to bind to the query.
 * @param $format, specify the desired return format for the query, json or array.
 * @return array|stdClass|string
 */
function Connect($query, $bindParameters, $format){

    $result = new stdClass();
    $formats = array('array', 'json');

    if(in_array(strtolower($format), $formats)){
        try{
            $handler = new PDO('mysql:dbname=sablrcrm_test; host=50.87.144.13', 'sablrcrm_287f_cg', 'W#(!8l=&%@Na');
            $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (is_array($query)){
                foreach ($query as $sql){
                    $stmt = $handler->prepare($sql[0]);
                    $stmt->execute($sql[1]);
                }
            }else{
                $stmt = $handler->prepare($query);
                $stmt->execute($bindParameters);
            }

            if($stmt->rowCount() > 0){
                $row = $stmt->fetchAll(PDO::FETCH_OBJ);

                switch($format){
                    case 'array':
                        $result = $row;
                        break;

                    case 'json':
                        $result = json_encode($row);
                        break;
                }
            }else{
                $result->status = false;
                $result->message = 'THERE ARE NO RESULTS FOR THIS QUERY';

                switch($format){
                    case 'array':
                        break;

                    case 'json':
                        $result = json_encode($result);
                        break;
                }
            }
        }catch(PDOException $ex){
            $result = $ex->getMessage();
        }
    }else{
        $result->status = false;
        $result->message = 'INVALID RETURN FORMAT SELECTED';
    }
    return $result;
}