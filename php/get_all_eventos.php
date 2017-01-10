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
if($url_pieces[1] == 'eventos'){
    switch($verb) {
        case 'GET':
                if(isset($url_pieces[2])) {
                    throw new Exception('To many parameters', 404);
                }
                else{
                     $query = "SELECT * FROM eventos" or die("Error query has failed:".mysqli_error($con));
                        $res = $con->query($query); 
                        if (mysqli_num_rows($res)>0){
                            while($row = $res->fetch_assoc()) {    
                                $response[$i++] = $row;
                            }
                            mysqli_close($con);
                            mysqli_free_result($res); 
                        }
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
    $response['error'] = 'Error: Not found';
    echo json_encode($response);
}
else{
    echo json_encode($response);
}
header("Content-Type: application/json");

?>