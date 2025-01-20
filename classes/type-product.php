<?php

class Type_product{
    function __construct($data){
        $this->conn = $data['conn'];
        $this->type_name = $data['type_name'];
        $this->cate_name = $data['cate_name'];
        $this->type_id = $data['type_id'];
        $this->id = $data['id'];
    }

    public function add_type($type){
        $now = date('Y-m-d H:i:s');

        try{
            $sql = $this->conn->prepare("INSERT INTO product_type (type_name, product_type, create_date, update_date)
            VALUES (:type_name,:product_type,:create_date,:update_date)");
            $sql->bindParam(':type_name',$this->type_name);
            $sql->bindParam(':product_type',$type);
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

    public function add_cate(){
        $now = date('Y-m-d H:i:s');

        try{
            $sql = $this->conn->prepare("INSERT INTO product_cate (type_id, cate_name, create_date, update_date)
            VALUES (:type_id,:cate_name,:create_date,:update_date)");
            $sql->bindParam(':type_id',$this->type_id);
            $sql->bindParam(':cate_name',$this->cate_name);
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

    public function get_type($type_product){
        try{
            $sql = $this->conn->prepare("SELECT * FROM product_type WHERE product_type = ".$type_product." AND status = 1");
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

    public function get_type_id(){
      try{
          $sql = $this->conn->prepare("SELECT * FROM product_type WHERE id = :id AND status = 1");
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

    public function get_cate($type_product){
        try{
            $sql = $this->conn->prepare("
            SELECT cate.*,type.type_name FROM product_cate as cate
            JOIN product_type as type ON type.id = cate.type_id
            WHERE cate.status = 1 AND type.product_type = ".$type_product." ");
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

    public function get_cate_id(){
      try{
        $sql = $this->conn->prepare("
        SELECT cate.*,type.type_name FROM product_cate as cate
        JOIN product_type as type ON type.id = cate.type_id
        WHERE cate.id = :id AND cate.status = 1");
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

    public function get_data(){
      try{
        $sql = $this->conn->prepare("
        SELECT user.id,user.fullname,user.sex,user.DOB,user.phone,user.address,user.id_no,user.line_id,user.id_customer,user_file.id_path,user_file.bookbank_path
        FROM user
        JOIN user_file on user_file.user_id = user.id
        WHERE user.id = :id AND user.status = 1
        ");
        $sql->bindParam(':id',$this->id);
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

    public function get_type_stock($type_product){
      try{
        $sql = $this->conn->prepare("SELECT * FROM product_type WHERE product_type = ".$type_product." AND status = 1");
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

    public function get_cate_stock(){
      try{
        $sql = $this->conn->prepare("SELECT * FROM product_cate WHERE type_id = :type_id AND status = 1");
        $sql->bindParam(':type_id',$this->type_id);
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

    public function update_type(){
      try{
        $now = date("Y-m-d H:i:s");

        $sql = $this->conn->prepare("UPDATE product_type SET
          type_name = :type_name,
          update_date = :update_date
        WHERE id = :id");
        $sql->bindParam(':type_name',$this->type_name);
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

    public function update_cate(){
      try{
        $now = date("Y-m-d H:i:s");

        $sql = $this->conn->prepare("UPDATE product_cate SET
          cate_name = :cate_name,
          type_id = :type_id,
          update_date = :update_date
        WHERE id = :id");
        $sql->bindParam(':cate_name',$this->cate_name);
        $sql->bindParam(':type_id',$this->type_id);
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

    public function delete_cate(){
      try{
        $now = date("Y-m-d H:i:s");

        $sql = $this->conn->prepare("UPDATE product_cate SET
          status = 0,
          update_date = :update_date
        WHERE id = :id");
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

    public function delete_type(){
      try{
        $now = date("Y-m-d H:i:s");

        $sql = $this->conn->prepare("UPDATE product_type SET
          status = 0,
          update_date = :update_date
        WHERE id = :id");
        $sql->bindParam(':update_date',$now);
        $sql->bindParam(':id',$this->id);
  
        if($sql->execute()){
          $sql2 = $this->conn->prepare("UPDATE product_cate SET
          status = 0,
          update_date = :update_date
          WHERE type_id = :type_id");
          $sql2->bindParam(':update_date',$now);
          $sql2->bindParam(':type_id',$this->id);
          if($sql2->execute()){
            return true;
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

    public function get_menu_type($type_id){
      try{
        $sql = $this->conn->prepare("SELECT * FROM product_type WHERE product_type = :type_id AND status = 1");
        $sql->bindParam(':type_id',$type_id);
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