<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../vendor/autoload.php");
use App\Controller\CarroController;

//######### EDIT LINE BELLOW #########
//######### EDIT LINE BELLOW #########
//######### EDIT LINE BELLOW #########
//######### EDIT LINE BELLOW #########

$unsetCount = 3; //Remove /test-dev/, /public/ and /api/;
define("BASE", "/test-dev/");

//######### NOT EDIT THE CODE BELLOW #########

$method = $_SERVER['REQUEST_METHOD']; //POST, PUT, GET or DELETE
$data = null; //Default is null
parse_str(file_get_contents('php://input'), $data);//Get all send data

$uri = $_SERVER["REQUEST_URI"]; //URI from application: /test-dev/public/api/
$controller = null;//Controller action
$param = null;//Parameter received

//NORMALIZE URI AND PARAMS
$ex = explode("/", $uri);
for($i = 0; $i < $unsetCount; $i++){
  unset($ex[$i]);
}

$ex = array_filter(array_values($ex));

if(isset($ex[0]))
$controller = $ex[0];

if(isset($ex[1]))
$param = $ex[1];

switch ($method) {
  case 'GET':
  if($controller == "carros" && $param == null){
    echo (new CarroController())->readAll();
  }elseif($controller == "carros" && $param > 0){
    echo (new CarroController())->readById($param);
  }else{
    echo json_encode(["result" => "invalid"]);
  }
  break;

  case 'POST':
  if($controller == "carros" && $param == null){
    echo (new CarroController())->create($data);
  }
  break;

  case 'DELETE':
  if($controller == "carros" && $param > 0){
    echo (new CarroController())->delete($param);
  }else{
    echo json_encode(["result" => "invalid"]);
  }
  break;

  case 'PUT':
  if($controller == "carros" && $param > 0){
    echo (new CarroController())->update($param, $data);
  }else{
    echo json_encode(["result" => "invalid"]);
  }
  break;

  default:
  echo json_encode(['result' => 'invalid method type']);
  break;
}
?>
