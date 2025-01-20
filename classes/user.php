<?php

session_start();

class User{
    function __construct($data){
        $this->conn = $data['conn'];
        $this->fullname = $data['fullname'];
        $this->sex = $data['sex'];
        $this->dob = $data['dob'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->id_no = $data['id_no'];
        $this->line_id = $data['line_id'];
        $this->email = $data['email'];
        $this->id_customer = $data['id_customer'];
        $this->id_file = $data['id_file'];
        $this->bookbank = $data['bookbank'];
        $this->id = $data['id'];
    }

    public function add($line_user,$type_regis){
      if($this->check_insert_user()){
        // คำนวนค่ารหัสสมาชิกใหม่จากรหัสที่มีล่าสุด
        $id_cus = $this->get_id_customer();
        $id_cus_pre = intval($id_cus['id_customer']);
        $id_cus_int = $id_cus_pre+1;
        $id_cus_num = "000000".$id_cus_int;
        $id_customer = substr($id_cus_num,-6);

        $file_id = $this->id_file;
        $file_bookbank = $this->bookbank;

        $now = date('Y-m-d H:i:s');

        try{
          if($line_user != ""){
            $sql = $this->conn->prepare("INSERT INTO user(fullname, sex, DOB, phone, address, id_no, line_id, line_user, email, id_customer, location_regis,create_date, update_date)
            VALUES (:fullname,:sex,:DOB,:phone,:address,:id_no,:line_id,:line_user,:email,:id_customer,:location_regis,:create_date,:update_date)");
            $sql->bindParam(':fullname',$this->fullname);
            $sql->bindParam(':sex',$this->sex);
            $sql->bindParam(':DOB',$this->dob);
            $sql->bindParam(':phone',$this->phone);
            $sql->bindParam(':address',$this->address);
            $sql->bindParam(':id_no',$this->id_no);
            $sql->bindParam(':line_id',$this->line_id);
            $sql->bindParam(':line_user',$line_user);
            $sql->bindParam(':email',$this->email);
            $sql->bindParam(':id_customer',$id_customer);
            $sql->bindParam(':location_regis',$type_regis);
            $sql->bindParam(':create_date',$now);
            $sql->bindParam(':update_date',$now);
          }
          else{
            $sql = $this->conn->prepare("INSERT INTO user(fullname, sex, DOB, phone, address, id_no, line_id, email, id_customer, create_date, update_date)
            VALUES (:fullname,:sex,:DOB,:phone,:address,:id_no,:line_id,:email,:id_customer,:create_date,:update_date)");
            $sql->bindParam(':fullname',$this->fullname);
            $sql->bindParam(':sex',$this->sex);
            $sql->bindParam(':DOB',$this->dob);
            $sql->bindParam(':phone',$this->phone);
            $sql->bindParam(':address',$this->address);
            $sql->bindParam(':id_no',$this->id_no);
            $sql->bindParam(':line_id',$this->line_id);
            $sql->bindParam(':email',$this->email);
            $sql->bindParam(':id_customer',$id_customer);
            $sql->bindParam(':create_date',$now);
            $sql->bindParam(':update_date',$now);
          }

          if($sql->execute()){
            $id_user = $this->conn->lastInsertId();
            $id_file = "";
            $bookbank = "";
            $status_upload = true;

            $add_point = $this->add_point_start($id_user);
            if(!$add_point){
              $status_upload = false;
            }

            // upload file id
            if($file_id['name']){

              $target_dir1     =   "../../../uploads/id_file";
              $avatar_name1    =   md5('YmdHis').'-'.$id_user.'-'.date("Ymd-His").'-'.basename($file_id["name"]);
              $target_file1    =   $target_dir1 .'/'.$avatar_name1;
              $uploadOk1       =   1;
              $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

              $check1 = getimagesize($file_id["tmp_name"]);

              if($check1 !== false) {
                $uploadOk1 = 1;
              } else {
                $uploadOk1 = 0;
              }

              if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
                $uploadOk1 = 0;
              }

              if ($uploadOk1 == 1) {
                if (move_uploaded_file($file_id["tmp_name"], $target_file1)) {
                    $id_file = $avatar_name1;
                }
              }
            }
            else{
              $status_upload = false;
            }

            // upload file bookbank
            if($file_bookbank['name']){

              $target_dir1     =   "../../../uploads/bookbank";
              $avatar_name1    =   md5('YmdHis').'-'.$id_user.'-'.date("Ymd-His").'-'.basename($file_bookbank["name"]);
              $target_file1    =   $target_dir1 .'/'.$avatar_name1;
              $uploadOk1       =   1;
              $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

              $check1 = getimagesize($file_bookbank["tmp_name"]);

              if($check1 !== false) {
                $uploadOk1 = 1;
              } else {
                $uploadOk1 = 0;
              }

              if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
                $uploadOk1 = 0;
              }

              if ($uploadOk1 == 1) {
                if (move_uploaded_file($file_bookbank["tmp_name"], $target_file1)) {
                    $bookbank = $avatar_name1;
                }
              }
            }
            else{
              $status_upload = false;
            }

            // insert path id_no , bookbank
            if($status_upload == true){
              $sql2 = $this->conn->prepare("INSERT INTO user_file (user_id, id_path, bookbank_path, create_date)
              VALUES (:user_id,:id_path,:bookbank_path,:create_date)");
              $sql2->bindParam(':user_id',$id_user);
              $sql2->bindParam(':id_path',$id_file);
              $sql2->bindParam(':bookbank_path',$bookbank);
              $sql2->bindParam(':create_date',$now);

              if($sql2->execute()){
                return true;
              }
              else{
                return false;
              }
            }
            else{
              return true;
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
        return false;
      } 
    }

    public function get(){
        try{
            $sql = $this->conn->prepare("SELECT * FROM user WHERE status = 1");
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
        SELECT user.id,user.fullname,user.sex,user.DOB,user.phone,user.address,user.id_no,user.line_id,user.line_user,user.id_customer,user.email,user.location_regis,user.point
        FROM user
        WHERE user.id = :id AND user.status = 1
        ");
        $sql->bindParam(':id',$this->id);
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          if(count($arr) > 0){
            $sql2 = $this->conn->prepare("SELECT id_path,bookbank_path FROM user_file WHERE user_id = :id ");
            $sql2->bindParam(':id',$this->id);
            $sql2->execute();
            while($result2 = $sql2->fetch(PDO::FETCH_NAMED)){
              $arr[0]["file"] = $result2;
            }

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

    public function update($point){
      try{
        $now = date("Y-m-d H:i:s");

        $file_id = $this->id_file;
        $file_bookbank = $this->bookbank;

        $sql = $this->conn->prepare("UPDATE user SET
          fullname = :fullname,
          sex = :sex,
          DOB = :DOB,
          phone = :phone,
          address = :address,
          id_no = :id_no,
          line_id = :line_id,
          email = :email,
          point = :point,
          update_date = :update_date
        WHERE id = :id");
        $sql->bindParam(':fullname',$this->fullname);
        $sql->bindParam(':sex',$this->sex);
        $sql->bindParam(':DOB',$this->dob);
        $sql->bindParam(':phone',$this->phone);
        $sql->bindParam(':address',$this->address);
        $sql->bindParam(':id_no',$this->id_no);
        $sql->bindParam(':line_id',$this->line_id);
        $sql->bindParam(':email',$this->email);
        $sql->bindParam(':point',$point);
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

    public function upload_file(){
      $file_id = $this->id_file;
      $file_bookbank = $this->bookbank;
      $id_file = "";
      $bookbank = "";
      $status_upload = true;
      $now = date("Y-m-d H:i:s");
      $id = $this->id;

      // upload file id
      if($file_id['name']){
        $target_dir1     =   "../../../uploads/id_file";
        $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($file_id["name"]);
        $target_file1    =   $target_dir1 .'/'.$avatar_name1;
        $uploadOk1       =   1;
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

        $check1 = getimagesize($file_id["tmp_name"]);

        if($check1 !== false) {
          $uploadOk1 = 1;
        } else {
          $uploadOk1 = 0;
        }

        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
          $uploadOk1 = 0;
        }

        if ($uploadOk1 == 1) {
          if (move_uploaded_file($file_id["tmp_name"], $target_file1)) {
              $id_file = $avatar_name1;
          }
        }
      }

      // upload file bookbank
      if($file_bookbank['name']){
        $target_dir1     =   "../../../uploads/bookbank";
        $avatar_name1    =   md5('YmdHis').'-'.$this->id.'-'.date("Ymd-His").'-'.basename($file_bookbank["name"]);
        $target_file1    =   $target_dir1 .'/'.$avatar_name1;
        $uploadOk1       =   1;
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

        $check1 = getimagesize($file_bookbank["tmp_name"]);

        if($check1 !== false) {
          $uploadOk1 = 1;
        } else {
          $uploadOk1 = 0;
        }

        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
          $uploadOk1 = 0;
        }

        if ($uploadOk1 == 1) {
          if (move_uploaded_file($file_bookbank["tmp_name"], $target_file1)) {
              $bookbank = $avatar_name1;
          }
        }
      }

      // insert path id_no , bookbank
      if($status_upload){
        if($id_file != "" && $bookbank == ""){
          if($this->check_has_file()){
            $query = "UPDATE user_file SET
              id_path = :id_path,
              create_date = :create_date
            WHERE user_id = :user_id";

            $sql2 = $this->conn->prepare($query);
            $sql2->bindParam(':create_date',$now);
            $sql2->bindParam(':user_id',$id);
            $sql2->bindParam(':id_path',$id_file);
          }
          else{
            $sql2 = $this->conn->prepare("INSERT INTO user_file(user_id, id_path, create_date)
            VALUES (:user_id,:id_path,:create_date)");
            $sql2->bindParam(':user_id',$id);
            $sql2->bindParam(':id_path',$id_file);
            $sql2->bindParam(':create_date',$now);
          }
        }
        elseif($id_file == "" && $bookbank != ""){
          if($this->check_has_file()){
            $query = "UPDATE user_file SET
              bookbank_path = :bookbank_path,
              create_date = :create_date
            WHERE user_id = :user_id";
  
            $sql2 = $this->conn->prepare($query);
            $sql2->bindParam(':create_date',$now);
            $sql2->bindParam(':user_id',$this->id);
            $sql2->bindParam(':bookbank_path',$bookbank);
          }
          else{
            $sql2 = $this->conn->prepare("INSERT INTO user_file(user_id, bookbank_path, create_date)
            VALUES (:user_id,:bookbank_path,:create_date)");
            $sql2->bindParam(':user_id',$id);
            $sql2->bindParam(':bookbank_path',$bookbank);
            $sql2->bindParam(':create_date',$now);
          }
        }

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

    public function upload_file_profile(){
      $file_id = $this->id_file;
      $file_bookbank = $this->bookbank;
      $id_file = "";
      $bookbank = "";
      $status_upload = true;
      $now = date("Y-m-d H:i:s");
      $id = $this->id;

      // upload file id
      if($file_id['name']){
        $target_dir1     =   "../../uploads/id_file";
        $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($file_id["name"]);
        $target_file1    =   $target_dir1 .'/'.$avatar_name1;
        $uploadOk1       =   1;
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

        $check1 = getimagesize($file_id["tmp_name"]);

        if($check1 !== false) {
          $uploadOk1 = 1;
        } else {
          $uploadOk1 = 0;
        }

        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
          $uploadOk1 = 0;
        }

        if ($uploadOk1 == 1) {
          if (move_uploaded_file($file_id["tmp_name"], $target_file1)) {
              $id_file = $avatar_name1;
          }
        }
      }

      // upload file bookbank
      if($file_bookbank['name']){
        $target_dir1     =   "../../uploads/bookbank";
        $avatar_name1    =   md5('YmdHis').'-'.$this->id.'-'.date("Ymd-His").'-'.basename($file_bookbank["name"]);
        $target_file1    =   $target_dir1 .'/'.$avatar_name1;
        $uploadOk1       =   1;
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

        $check1 = getimagesize($file_bookbank["tmp_name"]);

        if($check1 !== false) {
          $uploadOk1 = 1;
        } else {
          $uploadOk1 = 0;
        }

        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
          $uploadOk1 = 0;
        }

        if ($uploadOk1 == 1) {
          if (move_uploaded_file($file_bookbank["tmp_name"], $target_file1)) {
              $bookbank = $avatar_name1;
          }
        }
      }

      // insert path id_no , bookbank
      if($status_upload){
        if($id_file != "" && $bookbank == ""){
          if($this->check_has_file()){
            $query = "UPDATE user_file SET
              id_path = :id_path,
              create_date = :create_date
            WHERE user_id = :user_id";

            $sql2 = $this->conn->prepare($query);
            $sql2->bindParam(':create_date',$now);
            $sql2->bindParam(':user_id',$id);
            $sql2->bindParam(':id_path',$id_file);
          }
          else{
            $sql2 = $this->conn->prepare("INSERT INTO user_file(user_id, id_path, create_date)
            VALUES (:user_id,:id_path,:create_date)");
            $sql2->bindParam(':user_id',$id);
            $sql2->bindParam(':id_path',$id_file);
            $sql2->bindParam(':create_date',$now);
          }
        }
        elseif($id_file == "" && $bookbank != ""){
          if($this->check_has_file()){
            $query = "UPDATE user_file SET
              bookbank_path = :bookbank_path,
              create_date = :create_date
            WHERE user_id = :user_id";
  
            $sql2 = $this->conn->prepare($query);
            $sql2->bindParam(':create_date',$now);
            $sql2->bindParam(':user_id',$this->id);
            $sql2->bindParam(':bookbank_path',$bookbank);
          }
          else{
            $sql2 = $this->conn->prepare("INSERT INTO user_file(user_id, bookbank_path, create_date)
            VALUES (:user_id,:bookbank_path,:create_date)");
            $sql2->bindParam(':user_id',$id);
            $sql2->bindParam(':bookbank_path',$bookbank);
            $sql2->bindParam(':create_date',$now);
          }
        }

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

    public function delete(){
      try{
        $now = date("Y-m-d H:i:s");

        $sql = $this->conn->prepare("UPDATE user SET
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

    private function get_id_customer(){
      $sql = $this->conn->prepare("SELECT id_customer FROM user WHERE status = 1 ORDER BY id_customer DESC LIMIT 1");
      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        return $result;
      }
      else{
        return false;
      }
    }

    private function check_insert_user(){
      $sql = $this->conn->prepare("SELECT * FROM user WHERE id_no = ? AND status = 1 ");
      if($sql->execute([$this->id_no])){
        // $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sql->fetchAll();

        if(count($result) > 0){
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

    public function get_data_sale(){
      try{
        $sql = $this->conn->prepare("SELECT * FROM user WHERE :id IN (fullname,phone,id_no,id_customer) AND status = 1 ");
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

    public function user_login(){
      try{
        $sql = $this->conn->prepare("SELECT id_no,id FROM user WHERE phone = :phone AND status = 1");
        $sql->bindParam(':phone',$this->phone);
        if($sql->execute()){
          $result = $sql->fetch(PDO::FETCH_NAMED);

          // check id_no compare
          $pass = false;
          if($result['id_no'] === $this->id_no){
            $pass = true;
          }

          if($pass){
            $_SESSION['log_login']= "Y";
            $_SESSION['login_start']= time();
            $_SESSION['login_exp']= $_SESSION['login_start'] + (7 * 24 * 60 * 60 );
            $_SESSION['user_id']= $result['id'];
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

    public function user_logout(){
      unset($_SESSION["log_login"]);
      unset($_SESSION['user_id']);
      return true;
    }

    public function get_data_profile(){
      try{
        $sql = $this->conn->prepare("
        SELECT user.id,user.fullname,user.sex,user.DOB,user.phone,user.address,user.id_no,user.line_id,user.line_user,user.id_customer,user.point
        FROM user
        WHERE user.id = :id AND user.status = 1
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

    public function profile_update(){
      try{
        $now = date("Y-m-d H:i:s");

        $sql = $this->conn->prepare("UPDATE user SET
          fullname = :fullname,
          sex = :sex,
          DOB = :DOB,
          address = :address,
          line_id = :line_id,
          email = :email,
          update_date = :update_date
        WHERE id = :id");
        $sql->bindParam(':fullname',$this->fullname);
        $sql->bindParam(':sex',$this->sex);
        $sql->bindParam(':DOB',$this->dob);
        $sql->bindParam(':address',$this->address);
        $sql->bindParam(':line_id',$this->line_id);
        $sql->bindParam(':email',$this->email);
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

    private function check_has_file(){
      $sql = $this->conn->prepare("SELECT id FROM user_file WHERE user_id = :user_id");
      $sql->bindParam(':user_id',$this->id);
      $sql->execute();
      $result = $sql->fetch(PDO::FETCH_NAMED);

      if($result){
        return true;
      }
      else{
        return false;
      }
    }

    private function add_point_start($user_id){
      $point = 10;
      $sql = $this->conn->prepare("UPDATE user SET
        point = :point
      WHERE id = :id");
      $sql->bindParam(':point',$point);
      $sql->bindParam(':id',$user_id);

      if($sql->execute()){
        return true; 
      }
      else{
        return false;
      }
    }

    public function get_item_rental(){
      try{
        $sql = $this->conn->prepare("
        SELECT * FROM gold_rental WHERE user_id = :id AND status = 1 
        ");
        $sql->bindParam(':id',$this->id);
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          if($arr){
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

    public function upload_slip($data){
      $suc = false;
      $id = "0101";
      $now = date('Y-m-d H:i:s');
     
      $txt_path = "";

      $target_dir1     =   "../../uploads/slip";
      $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($data['img']['name']);
      $target_file1    =   $target_dir1 .'/'.$avatar_name1;
      $uploadOk1       =   1;
      $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

      $check1 = getimagesize($data['img']["tmp_name"]);

      if($check1 !== false) {
        $uploadOk1 = 1;
      } else {
        $uploadOk1 = 0;
      }

      if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
        $uploadOk1 = 0;
      }

      if ($uploadOk1 == 1) {
        if (move_uploaded_file($data['img']["tmp_name"], $target_file1)) {
            $txt_path = $avatar_name1;
        }
      }

      // insert path
      $sql2 = $this->conn->prepare("INSERT INTO transection_rental(user_id,item_id,interest,pic_path,create_date) 
                                    VALUES(:user_id,:item_id,:interest,:pic_path,:create_date)");
      $sql2->bindParam(':create_date',$now);
      $sql2->bindParam(':user_id',$data['user_id']);
      $sql2->bindParam(':item_id',$data['item_id']);
      $sql2->bindParam(':interest',$data['interest']);
      $sql2->bindParam(':pic_path',$txt_path);
      if($sql2->execute()){
        $suc = true;
      }

      if($suc){
        // pre data send notify
        $sql_pre = $this->conn->prepare("SELECT fullname FROM user WHERE id = :user_id");
        $sql_pre->bindParam(':user_id',$data['user_id']);
        $sql_pre->execute();
        $pre_result = $sql_pre->fetch(PDO::FETCH_NAMED);
        

        // send notify
        $url        = 'https://notify-api.line.me/api/notify';
        $token      = 'kNM8HYaR7i3gRb7EB25ixkLB6Z0e69SD7p0ENJaTsIz';
        $headers    =  array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$token.'', );
        $fields     = 'คุณ'.$pre_result['fullname'].' ได้ทำการส่งสลิปต่อดอกเข้ามาเป็นจำนวนเงิน '.$data['interest'].' บาท กรุณาทำการเช็คความถูกต้องและทำการยืนยันในระบบแอดมิน';

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=".$fields);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec( $ch );
        curl_close( $ch );

        return true;
      }
      else{
        return false;
      }
    }

    public function export_user(){
      try{
        $sql = $this->conn->prepare("
        SELECT user.id_customer,user.fullname,user.sex,user.DOB,user.phone,user.address,user.id_no,user.line_id,user.email,user.point
        FROM user
        WHERE user.status =  1
        ");
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          return $arr;
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