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
if($url_pieces[1] == 'viagem'){
    switch($verb) {
        case 'GET':
                if(isset($url_pieces[2])) {
                    try {
                        $id_user = $url_pieces[2];
                        $query = "SELECT id_viagem, id_veiculo, data_inicio, rua_inicio, rua_fim FROM viagem WHERE id_user = '$id_user'" or die("Error query has failed:".mysqli_error($con));
                        $res = $con->query($query); 
                        if (mysqli_num_rows($res)>0){
                            while($row = $res->fetch_assoc()) {    
                                $response[$i++] = $row;
                            }
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
    echo json_encode($response);
}
header("Content-Type: application/json");

?>
