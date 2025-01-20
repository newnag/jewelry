<?php
session_start();

class Auth{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->username = $data['username'];
    $this->password = $data['password'];
    $this->email = $data['email'];
    $this->date = $data['date'];
    $this->remember = $data['remember'];
  }

  private function check_user(){
    try{
      $sql = $this->conn->prepare("SELECT username FROM staff WHERE username = ? ");
      if($sql->execute([$this->username])){
        $result = $sql->fetchAll();

        if(count($result) > 0){
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

  public function check_login(){
    try{
      if(!empty($_SESSION["log_login"])){
        $timeNow = time();
        if($timeNow > $_SESSION["login_exp"]){
          session_destroy();
          return false;
        }
        else{
          return true;
        }
      }
      else{
        return false;
      }
    }
    catch(Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  }

  public function register(){
    if(!$this->check_user()){
      try{
        $hashed_password = $this->Hash_pass();

        $sql = $this->conn->prepare("INSERT INTO staff (username, password, email , create_date , update_date)
        VALUES (:username,:password,:email,:create_date,:update_date)");
        $sql->bindParam(':username',$this->username);
        $sql->bindParam(':password',$hashed_password);
        $sql->bindParam(':email',$this->email);
        $sql->bindParam(':create_date',$this->date);
        $sql->bindParam(':update_date',$this->date);
  
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
    else{
      return false;
    }
  }

  public function login(){
    if($this->check_user()){
      try{
        $sql = $this->conn->prepare("SELECT id,password,role FROM staff WHERE username = ? AND status = 1");
        if($sql->execute([$this->username])){
          $result = $sql->fetchAll();
  
          if(count($result) > 0){
            if(password_verify($this->password,$result[0]['password'])){
              $_SESSION['log_login']= "Y";
              $_SESSION['admin_id']= $result[0]['id'];
              $_SESSION['role']= $result[0]['role']; //1=admin,2=manager,3=employee
              $_SESSION['login_start']= time();
              $_SESSION['login_exp']= $_SESSION['login_start'] + (7 * 24 * 60 * 60 );
              return json_encode(array( "status"=>200,
                                        "msg"   =>"login success"));
            }
            else{
              return json_encode(array( "status"=>404,
                                        "msg"   =>"username or password incorrect"));
            }
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
    else{
      return json_encode(array( "status"=>404,
                                "msg"   =>"username not found"));
    }
  }

  public function add_staff($role){
    try{
      
      $hashed_password = $this->Hash_pass();

      $sql = $this->conn->prepare("INSERT INTO staff (username, password, email , role, create_date , update_date)
      VALUES (:username,:password,:email,:role,:create_date,:update_date)");
      $sql->bindParam(':username',$this->username);
      $sql->bindParam(':password',$hashed_password);
      $sql->bindParam(':email',$this->email);
      $sql->bindParam(':role',$role);
      $sql->bindParam(':create_date',$this->date);
      $sql->bindParam(':update_date',$this->date);

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

  public function get_staff(){
    try{
      $sql = $this->conn->prepare("SELECT id,username,email,role,create_date FROM staff WHERE status = 1");
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

  public function delete($id){
    try{
      $sql = $this->conn->prepare("UPDATE staff SET
        status = 0
      WHERE id = :id");
      $sql->bindParam(':id',$id);

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

  public function change_pass($id){
    $password = $this->Hash_pass();

    try{
      $sql = $this->conn->prepare("UPDATE staff SET
        password = :password
      WHERE id = :id");
      $sql->bindParam(':password',$password);
      $sql->bindParam(':id',$id);

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

  public function change_role($id,$role){
    try{
      $sql = $this->conn->prepare("UPDATE staff SET
        role = :role
      WHERE id = :id");
      $sql->bindParam(':role',$role);
      $sql->bindParam(':id',$id);

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

  public function logout(){
    session_destroy();
    // unset($_SESSION["log_login"]);
    // unset($_SESSION["role"]);
    // unset($_SESSION["login_start"]);
    // unset($_SESSION["login_exp"]);
    return true;
  }

  private function Hash_pass(){
    // password hash + salt
    return password_hash($this->password, PASSWORD_DEFAULT,['cost'=>12]);
  }
}