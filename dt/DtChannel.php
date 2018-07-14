<?php
class DtChannel
{
  ############################### PROPIEDADES ################################
  protected $id;
  protected $number;
  protected $name;
  protected $coment;
  protected $views;
  protected $logo;
  protected $country;
  protected $category;
  protected $user;
  protected $active;
  protected $check;

  ############################### CONSTRUCTOR ################################
	public function __construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active, $check){
     $this->id = $id;
     $this->number = $number;
     $this->name = $name;
     $this->coment = $coment;
     $this->views = $views;
     $this->logo = $logo;
     $this->country = $country;
     $this->category = $category;
     $this->user = $user;
     $this->active = $active;
     $this->check = $check;
  }
	public function __destruct(){}

	public function get($atributo)
	{
		return $this->$atributo;
	}

  public function toString(){
    return "No implementado";
  }

  public function getData(){
    return "No implementado";
  }

}

?>
