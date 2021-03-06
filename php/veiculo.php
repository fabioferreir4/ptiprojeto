<?php

include("OBJ_mysql.php");
$config = array(
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '68466',
        'database' => 'dbpti',
);


set_exception_handler(function ($e) {
    $code = $e->getCode() ?: 400;
    header("Content-Type: application/json", NULL, $code);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
});

$verb = $_SERVER['REQUEST_METHOD'];
$url_pieces = explode('/', $_SERVER['PATH_INFO']);

if($url_pieces[1]!= 'utilizador' && $url_pieces[1]!= 'veiculo' && $url_pieces[1]!= 'viagem' && $url_pieces[1]!= 'coordenadas' && $url_pieces[1]!= 'evento') {
    throw new Exception('Unknown endpoint', 404);
}
if($url_pieces[1]== 'veiculo'){
    switch($verb) {
        case 'GET':
           $db = new OBJ_mysql($config);
           if(isset($url_pieces[2])) {
               try {
                   $res = $db->query("SELECT * FROM veiculo WHERE id_veiculo = ?",array($url_pieces[2]));
                   $response = $res->fetchArray();
               } catch (Exception $e) {
                   throw new Exception("Resource does not exist", 404);
               }
            }
            else{
                throw new Exception('Missing something', 404);
            }
           break;
        case 'POST':
            $db = new OBJ_mysql($config);
            $params = json_decode(file_get_contents("php://input"), true);
            if(!$params) {
                throw new Exception("Data missing or invalid");
            }
            $db->insert('veiculo', $params);
            header("Location: " . $item['url'], null, 201);
            exit;
            break;
        case 'PUT':
            $params = json_decode(file_get_contents("php://input"), true);
            if(!$params) {
                throw new Exception("Data missing or invalid");
            }
            $id = $url_pieces[2];
            $db->update('veiculo', $params);
            header("Location: " . $item['url'], null, 204);
            exit;
            break;
        case 'DELETE':
            $id = $url_pieces[2];
            $ok = $db->delete('veiculo', array( 'id_user' => $id ) );
            if ($ok) {
                header("Location: /veiculo", null, 204);
                exit;
            } else {
                throw new Exception("Veiculo does not exist!", 404);
            };
            break;
        default: 
                throw new Exception('Method Not Supported', 405);
    }
}
else{
     throw new Exception('Not found', 404);
}

echo json_encode($response);
header("Content-Type: application/json");
?>
