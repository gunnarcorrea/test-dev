<?php
namespace App\Entity;

class Carro{

	private $id;
	private $marca;
	private $modelo;
	private $ano;

	public function __construct ($id = '', $marca = '', $modelo = '', $ano = ''){
		$this->id = $id;
		$this->marca = $marca;
		$this->modelo = $modelo;
		$this->ano = $ano;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function setMarca($marca){
		$this->marca = $marca;
	}

	public function setModelo($modelo){
		$this->modelo = $modelo;
	}

	public function setAno($ano){
		$this->ano = $ano;
	}

	public function getId(){
		return $this->id;
	}

	public function getMarca(){
		return $this->marca;
	}

	public function getModelo(){
		return $this->modelo;
	}

	public function getAno(){
		return $this->ano;
	}
}

?>
