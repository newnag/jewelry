<?php
/* 
## table : member_reward
## develop by nexadon
*/

class Member_reward{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->name = $data['name'];
    $this->use_point = $data['point'];
    $this->amount = $data['amount'];
    $this->desc_item = $data['detail'];
    $this->id = $data['id'];
  }

  public function add(){
    $now = date('Y-m-d H:i:s');

    try{
      $sql = $this->conn->prepare("INSERT INTO member_reward (name, use_point, amount, desc_item, create_date)
      VALUES (:name,:use_point,:amount,:desc_item,:create_date)");
      $sql->bindParam(':name',$this->name);
      $sql->bindParam(':use_point',$this->use_point);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':desc_item',$this->desc_item);
      $sql->bindParam(':create_date',$now);

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
          $sql = $this->conn->prepare("SELECT * FROM member_reward WHERE status = 1");
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
      $sql = $this->conn->prepare("
        SELECT *
        FROM member_reward
        WHERE id = :id
      ");
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
      $sql = $this->conn->prepare("UPDATE member_reward SET
        name = :name,
        use_point = :use_point,
        amount = :amount,
        desc_item = :desc_item,
        create_date = :create_date
      WHERE id = :id");
      $sql->bindParam(':name',$this->name);
      $sql->bindParam(':use_point',$this->use_point);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':desc_item',$this->desc_item);
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
      $sql = $this->conn->prepare("DELETE FROM member_reward WHERE id = :id ");
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

  public function get_history($user_id){
    try{
      $sql = $this->conn->prepare("
      SELECT history.*,reward.name as reward_name,reward.use_point as point
      FROM reward_history as history
      JOIN member_reward as reward ON reward.id = history.reward_id
      WHERE history.user_id = :user_id AND history.status = 1
      ");
      $sql->bindParam(':user_id',$user_id);
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