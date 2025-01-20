<?php

class Supplier{
  function __construct($data){
    $this->conn = $data['conn'];
    if(isset($data['supplier_name']) == 1){
      $this->supplier_name = $data['supplier_name'];
    }
    else {
      $this->supplier_name = isset($data['supplier_name']);
    }
    if(isset($data['id']) == 1){
      $this->id = $data['id'];
    }
    else {

      $this->id = isset($data['id']);
    }
    // $this->tax_id = $data['tax_id'];
  }
  // function __construct($data){
  //   $this->conn = $data['conn'];
  //   $this->supplier_name = $data['supplier_name'];
  //   $this->id = $data['id'];
  // }

  // type 1 = gold , 2 = border , 3 = jewelry
  public function add_supplier($type,$tax_id){
    $now = date('Y-m-d H:i:s');

    try{
      $sql = $this->conn->prepare("INSERT INTO supplier (name, create_date, type_supplier, tax_id)
      VALUES (:supplier_name,:create_date,:type_supplier,:tax_id)");
      $sql->bindParam(':supplier_name',$this->supplier_name);
      $sql->bindParam(':create_date',$now);
      $sql->bindParam(':type_supplier',$type);
      $sql->bindParam(':tax_id',$tax_id);

      if($sql->execute()){
          return true;
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }

  public function get(){
    try{
      $sql = $this->conn->prepare("SELECT * FROM supplier WHERE status = 1");
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        if(count($arr) > 0){
          return $arr;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }

  public function get_id(){
    try{
      $sql = $this->conn->prepare("SELECT * FROM supplier WHERE status = 1 AND id = :id ");
      $sql->bindParam(':id',$this->id);
      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_NAMED);
          
        if($result != ""){
          return $result;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }

  public function update($type,$tax_id){
    try{
      $now = date("Y-m-d H:i:s");

      $sql = $this->conn->prepare("UPDATE supplier SET
        name = :name,
        type_supplier = :type_supplier,
        tax_id = :tax_id,
        create_date = :create_date
      WHERE id = :id");
      $sql->bindParam(':name',$this->supplier_name);
      $sql->bindParam(':type_supplier',$type);
      $sql->bindParam(':tax_id',$tax_id);
      $sql->bindParam(':create_date',$now);
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        return true; 
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function delete(){
    try{
      $sql = $this->conn->prepare("UPDATE supplier SET
        status = 0
      WHERE id = :id");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        return true; 
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function get_by_type($type){
    try{
      $sql = $this->conn->prepare("SELECT * FROM supplier WHERE type_supplier = :type AND status = 1");
      $sql->bindParam(':type',$type);
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        if(count($arr) > 0){
          return $arr;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }
}