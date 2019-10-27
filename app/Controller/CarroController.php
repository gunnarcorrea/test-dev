<?php
namespace App\Controller;
use App\Entity\Carro;
use App\Model\CarroModel;

class CarroController{

  private $carroModel;

  public function __construct(){
    $this->carroModel = new CarroModel();
  }

  public function create($data){
    $carro  = $this->validateFields($data);

    if(strlen($carro->getMarca()) <= 2 || strlen($carro->getMarca()) > 100)
    return json_encode(["error" => "Invalid marca"]);

    if(strlen($carro->getModelo()) <= 2 || strlen($carro->getModelo()) > 100)
    return json_encode(["error" => "Invalid modelo"]);

    if($carro->getAno() <= 1980 || $carro->getAno() > (date("Y") + 1))
    return json_encode(["error" => "Invalid ano"]);

    if($this->carroModel->create($carro))
    echo json_encode(["result" => "ok"]);
    else
    echo json_encode(["result" => "error"]);
  }

  public function update($id, $data){
    $carro  = $this->validateFields($data);

    $carro->setId($id);

    if(strlen($carro->getMarca()) <= 2 || strlen($carro->getMarca()) > 100)
      return json_encode(["error" => "Invalid marca"]);

    if(strlen($carro->getModelo()) <= 2 || strlen($carro->getModelo()) > 100)
    return json_encode(["error" => "Invalid modelo"]);

    if($carro->getAno() <= 1980 || $carro->getAno() > (date("Y") + 1))
    return json_encode(["error" => "Invalid ano"]);

    if($carro->getId() <= 0)
    return json_encode(["error" => "Invalid ID"]);

    if($this->carroModel->update($carro))
      echo json_encode(["result" => "ok"]);
    else
      echo json_encode(["result" => "error"]);
  }

  public function delete(int $carroId){
    if($this->carroModel->delete($carroId)){
      echo json_encode(["result" => "ok"]);
    }else{
      echo json_encode(["result" => "error"]);
    }
  }

  public function readAll(){
    echo $this->carroModel->readAll();
  }

  public function readById(int $carroId){
    if($carroId > 0)
    echo $this->carroModel->readById($carroId);
    else
    echo null;
  }

  private function validateFields($data){
    return new Carro(
      null,//isset($data["id"])     ? filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT) : null,
      isset($data["marca"])  ? filter_var($data["marca"], FILTER_SANITIZE_STRING)  : null,
      isset($data["modelo"]) ? filter_var($data["modelo"], FILTER_SANITIZE_STRING) : null,
      isset($data["ano"])     ? filter_var($data["ano"], FILTER_SANITIZE_NUMBER_INT) : null
    );
  }
}
?>
