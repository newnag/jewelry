<?php
/* 
## table : stock_equipment
## develop by nexadon
*/

class Stock_equipment{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->name = $data['name'];
    $this->supplier = $data['supplier'];
    $this->price = $data['price'];
    $this->amount = $data['amount'];
    $this->id = $data['id'];
  }

  public function add(){
    $now = date('Y-m-d H:i:s');

    try{
      $sql = $this->conn->prepare("INSERT INTO equipment (name, supplier, price, amount, create_date, update_date)
      VALUES (:name,:supplier,:price,:amount,:create_date,:update_date)");
      $sql->bindParam(':name',$this->name);
      $sql->bindParam(':supplier',$this->supplier);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':create_date',$now);
      $sql->bindParam(':update_date',$now);

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
          $sql = $this->conn->prepare("SELECT * FROM equipment WHERE status = 1");
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

  public function get_data(){
    try{
      $sql = $this->conn->prepare("SELECT * FROM equipment WHERE id = :id ");
      $sql->bindParam(':id',$this->id);
      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_NAMED);

        if($result){
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

  public function update(){
    $now = date('Y-m-d H:i:s');

    try{
      $sql = $this->conn->prepare("UPDATE equipment SET
        name = :name,
        supplier = :supplier,
        price = :price,
        amount = :amount,
        update_date = :update_date
      WHERE id = :id");
      $sql->bindParam(':name',$this->name);
      $sql->bindParam(':supplier',$this->supplier);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':update_date',$now);
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
      $sql = $this->conn->prepare("DELETE FROM equipment WHERE id = :id ");
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
}