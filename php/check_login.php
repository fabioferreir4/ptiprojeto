<?php

set_exception_handler(function ($e) {
    $code = $e->getCode() ?: 400;
    header("Content-Type: application/json", NULL, $code);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
});

$response = array();
$i = 0;
$con = mysqli_connect("localhost", "root", "68466", "dbpti") or die("Error " . mysqli_error($con));
$con->set_charset("utf8");

if (!$con){
    throw new Exception('Not found', 404);;
  }

$verb = $_SERVER['REQUEST_METHOD'];
$url_pieces = explode('/', $_SERVER['PATH_INFO']);

if($url_pieces[1]!= 'utilizador' && $url_pieces[1]!= 'veiculo' && $url_pieces[1]!= 'viagem' && $url_pieces[1]!= 'coordenadas' && $url_pieces[1]!= 'eventos') {
    throw new Exception('Unknown endpoint', 404);
}
if($url_pieces[1] == 'utilizador'){
    switch($verb) {
        case 'GET':
                if(isset($url_pieces[2])&&isset($url_pieces[3])) {
                    try {
                        $email = $url_pieces[2];
                        $password = $url_pieces[3];
                        $query = "SELECT * FROM utilizador WHERE email = '$email' and password = '$password'" or die("Error query has failed:".mysqli_error($con));
                        $res = $con->query($query); 
                        if (mysqli_num_rows($res)>0){
                            $response = $res->fetch_assoc();
                            mysqli_close($con);
                            mysqli_free_result($res); 
                        }
                        
                    }catch (Exception $e) {
                        throw new Exception("Resource does not exist", 404);
                    }
                }
                else{
                    throw new Exception('Missing something', 404);
                }
                break;
                
        default: 
                throw new Exception('Method Not Supported', 405);
    }
}
else{
     throw new Exception('Not found', 404);
}

if(empty($response)){
    $response['error'] = 'Error';
    echo json_encode($response);
}
else{
    $response['success'] = 'Success';
    echo json_encode($response);
}
header("Content-Type: application/json");

?>
