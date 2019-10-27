<?php
namespace App\Model;
use App\Entity\Carro;
use App\Util\Serialize;

class CarroModel{
  private $pathFile;
  private $carros = [];

  public function __construct(){
    $this->pathFile = "../database/carro.txt";

    $this->createArray();
  }

  public function create(Carro $carro){
    $carro->setId(count($this->carros) + 1);
    $this->carros[] = $carro;
    $this->save();

    return true;
  }

  public function update(Carro $carro){
    for($i = 0; $i < count($this->carros); $i++){
      if($this->carros[$i]->getId() == $carro->getId()){
        $this->carros[$i] = $carro;
      }
    }

    $this->save();
    return true;
  }

  public function delete(int $carroId){
    $total = count($this->carros);

    if($total > 0){
      for($i = 0; $i < $total; $i++){
        if($this->carros[$i]->getId() == $carroId){
          unset($this->carros[$i]);
        }
      }

      $this->carros = array_filter(array_values($this->carros));
      $this->save();
      return true;
    }else{
      return false;
    }
  }

  public function readAll(){
    return (new Serialize())->serialize($this->carros);
  }

  public function readById(int $carroId){
    foreach($this->carros as $car){
      if($car->getId() == $carroId){
        return (new Serialize())->serialize($car);
      }
    }

    return null;
  }

  //Internal methods;
  /*
  Read txt file and convert content to array
  */
  private function createArray(){
    if(!file_exists($this->pathFile) || filesize($this->pathFile) <= 0)
    return [];

    $fp = fopen($this->pathFile, "r");
    $line = fread($fp, filesize($this->pathFile));

    $array = json_decode($line);

    for($i = 0; $i < count($array); $i++){
      $this->carros[] = new Carro(
        $array[$i]->id,
        $array[$i]->marca,
        $array[$i]->modelo,
        $array[$i]->ano
      );
    }

    fclose($fp);
  }

  /*
  Convert array to json and write in txt file
  */
  private function save(){
    $fp = fopen($this->pathFile, "w");

    $data = [];

    foreach($this->carros as $car){
      $data[] = array(
        "id" => $car->getId(),
        "marca" => $car->getMarca(),
        "modelo" => $car->getModelo(),
        "ano" => $car->getAno(),
      );
    }

    fwrite($fp, json_encode($data));

    fclose($fp);
  }
}
