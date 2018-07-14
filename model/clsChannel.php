<?php
include_once("DB/DbAbstractModel_MYSQL.php");
class clsChannel extends DBAbstractModel
{
  ############################### CONSTRUCTOR ################################


  public function Eliminar($id)
  {
    $this->open_connection();
    $query = "call BajaCanal(?,@msg)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $afRows =  $stmt->affected_rows;
    $stmt->close();
    $this->close_connection();
    return $afRows;
  }

}

?>
