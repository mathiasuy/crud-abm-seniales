<?php
  abstract class DBAbstractModel {

     private static $db_host = 'localhost';


     private static $db_user = 'root';
     private static $db_pass = '';
     protected $db_name = 'LATELE';
     protected $query;
     private $rows = array();
     protected $conn;
     private $result;
     public $mensaje = 'Hecho';
     public $affRows;

     # Conectar a la base de datos
    protected function open_connection() {
       $this->conn = new mysqli(self::$db_host, self::$db_user,
       self::$db_pass, $this->db_name);
       $this->conn->set_charset("utf8");
       //$this->conn->beginTransaction();
    }

    # Desconectar la base de datos
    protected function close_connection() {
/*
      if ($ok){
        $this->conn->commit();
      }else{
        $this->conn->rollback();
      }
      */
      $this->conn->close();
    }

    # Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
    protected function execute_single_query() {
       if($_POST) {
         $this->open_connection();
         $this->result = $this->conn->query($this->query);
         $this->affRows = $this->conn->affected_rows;
         $this->close_connection();
       } else {
         $this->mensaje = 'Metodo no permitido';
       }
       return $this->result;
    }

    # Traer resultados de una consulta en un Array
    protected function get_results_from_query() {
       $this->open_connection();
       //var_dump($this->query."</br>");
       $result = $this->conn->query($this->query)  or die($this->conn->error);
       while ($this->rows[] = $result->fetch_assoc());
       $result->close();
       $this->close_connection();
       return $this->rows;
       array_pop($this->rows);
    }
  }
?>
