<?php
session_start();
class Stock_gold{
    function __construct($data){
        $this->conn = $data['conn'];
        $this->type_supplier = $data['supplier_type'];
        $this->product_no = $data['product_no'];
        $this->type_product = $data['product_cate'];
        $this->weight = $data['weight'];
        $this->detail = $data['detail'];
        $this->import_date = $data['import_date'];
        $this->size = $data['size'];
        $this->cost_id = $data['cost_id'];
        $this->cost = $data['cost'];
        $this->cost_price = $data['cost_price'];
        $this->wage = $data['wage'];
        $this->cost_wage_id = $data['cost_wage_id'];
        $this->cost_wage = $data['cost_wage'];
        $this->sale_date = $data['sale_date'];
        $this->price_id = $data['price_id'];
        $this->price = $data['price'];
        $this->status = $data['status'];
        $this->id = $data['id'];
    }

    public function add(){
      if($this->check_insert_item()){

        $now = date('Y-m-d H:i:s');
        $position = 1;

        try{
            $sql = $this->conn->prepare("INSERT INTO stock_gold (position, type_supplier, type_product, product_no, detail, import_date, size, weight, cost, cost_id, cost_price, wage, cost_wage_id, cost_wage, sale_date, price, price_id, status)
            VALUES (:position,:type_supplier,:type_product,:product_no,:detail,:import_date,:size,:weight,:cost,:cost_id,:cost_price,:wage,:cost_wage_id,:cost_wage,:sale_date,:price,:price_id,:status)");
            $sql->bindParam(':position',$position);
            $sql->bindParam(':type_supplier',$this->type_supplier);
            $sql->bindParam(':type_product',$this->type_product);
            $sql->bindParam(':product_no',$this->product_no);
            $sql->bindParam(':detail',$this->detail);
            $sql->bindParam(':import_date',$this->import_date);
            $sql->bindParam(':size',$this->size);
            $sql->bindParam(':weight',$this->weight);
            $sql->bindParam(':cost',$this->cost);
            $sql->bindParam(':cost_id',$this->cost_id);
            $sql->bindParam(':cost_price',$this->cost_price);
            $sql->bindParam(':wage',$this->wage);
            $sql->bindParam(':cost_wage_id',$this->cost_wage_id);
            $sql->bindParam(':cost_wage',$this->cost_wage);
            $sql->bindParam(':sale_date',$this->sale_date);
            $sql->bindParam(':price',$this->price);
            $sql->bindParam(':price_id',$this->price_id);
            $sql->bindParam(':status',$this->status);

            if($sql->execute()){
                return $this->conn->lastInsertId();
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
            $sql = $this->conn->prepare("
            SELECT 	
              stock.id,
              stock.product_no,
              type.type_name,
              cate.cate_name,
              stock.cost_id,
              stock.wage,
              stock.weight,
              stock.status,
              pic.pic_path
            FROM stock_gold as stock
            JOIN product_cate as cate ON cate.id = stock.type_product
            JOIN product_type as type ON type.id = cate.type_id
            JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
            WHERE stock.position = 1 AND stock.status = 1
            ");
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
          FROM stock_gold
          WHERE id = :id
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

    public function get_data_type($cate_id){
      try{
        $sql = $this->conn->prepare("
          SELECT cate.id,cate.cate_name,cate.type_id,type.type_name
          FROM product_cate as cate
          JOIN product_type as type ON cate.type_id = type.id
          WHERE cate.id = :cate_id AND cate.status = 1
        ");
        $sql->bindParam(':cate_id',$cate_id);
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

    public function get_pic($id){
      try{
        $sql = $this->conn->prepare("SELECT * FROM stock_gold_pic WHERE stock_id = :id");
        $sql->bindParam(':id',$id);
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

    public function update(){
      $position = 1;
      
      try{
        $sql = $this->conn->prepare("UPDATE stock_gold SET
          position = :position,
          type_supplier = :type_supplier,
          type_product = :type_product,
          product_no = :product_no,
          detail = :detail,
          import_date = :import_date,
          size = :size,
          weight = :weight,
          cost = :cost,
          cost_id = :cost_id,
          cost_price = :cost_price,
          wage = :wage,
          cost_wage_id = :cost_wage_id,
          cost_wage = :cost_wage,
          sale_date = :sale_date,
          price = :price,
          price_id = :price_id
        WHERE id = :id");
        $sql->bindParam(':position',$position);
        $sql->bindParam(':type_supplier',$this->type_supplier);
        $sql->bindParam(':type_product',$this->type_product);
        $sql->bindParam(':product_no',$this->product_no);
        $sql->bindParam(':detail',$this->detail);
        $sql->bindParam(':import_date',$this->import_date);
        $sql->bindParam(':size',$this->size);
        $sql->bindParam(':weight',$this->weight);
        $sql->bindParam(':cost',$this->cost);
        $sql->bindParam(':cost_id',$this->cost_id);
        $sql->bindParam(':cost_price',$this->cost_price);
        $sql->bindParam(':wage',$this->wage);
        $sql->bindParam(':cost_wage_id',$this->cost_wage_id);
        $sql->bindParam(':cost_wage',$this->cost_wage);
        $sql->bindParam(':sale_date',$this->sale_date);
        $sql->bindParam(':price',$this->price);
        $sql->bindParam(':price_id',$this->price_id);
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

    public function upload_file($pic,$item_id){
      $suc = 0;
      $id = $item_id;
      $now = date('Y-m-d H:i:s');

      // return $pic['file'];

      if(count($pic['file'])>0){
        $txt_path = array();

        for($i=0;$i<count($pic['file']);$i++){
          $target_dir1     =   "../../../uploads/stock-gold";
          $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($pic['file']['file_'.$i]['name']);
          $target_file1    =   $target_dir1 .'/'.$avatar_name1;
          $uploadOk1       =   1;
          $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
  
          $check1 = getimagesize($pic['file']['file_'.$i]["tmp_name"]);
  
          if($check1 !== false) {
            $uploadOk1 = 1;
          } else {
            $uploadOk1 = 0;
          }
  
          if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
            $uploadOk1 = 0;
          }
  
          if ($uploadOk1 == 1) {
            if (move_uploaded_file($pic['file']['file_'.$i]["tmp_name"], $target_file1)) {
                $txt_path[$i] = $avatar_name1;
            }
          }
          
        }
      }

      // insert path
      for($i=0;$i<count($txt_path);$i++){
        $sql2 = $this->conn->prepare("INSERT INTO stock_gold_pic(stock_id,pic_path,create_date) 
                                      VALUES(:stock_id,:pic_path,:create_date)");
        $sql2->bindParam(':create_date',$now);
        $sql2->bindParam(':stock_id',$id);
        $sql2->bindParam(':pic_path',$txt_path[$i]);
        if($sql2->execute()){
          $suc += 1;
        }
        else{
          $suc -= 1;
        }
      }

      if($suc == count($txt_path)){
        return true;
      }
      else{
        return false;
      }
      
    }

    public function update_file($pic){
      $suc = 0;
      $now = date('Y-m-d H:i:s');

      if(count($pic['file'])>0){
        $txt_path = array();
        $random = rand(0,100);

        if($pic['file']['file_0']){
          $target_dir1     =   "../../../uploads/stock-gold";
          $avatar_name1    =   md5('YmdHis').'-'.$random.'-'.date("Ymd-His").'-'.basename($pic['file']['file_0']['name']);
          $target_file1    =   $target_dir1 .'/'.$avatar_name1;
          $uploadOk1       =   1;
          $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
  
          $check1 = getimagesize($pic['file']['file_0']["tmp_name"]);
  
          if($check1 !== false) {
            $uploadOk1 = 1;
          } else {
            $uploadOk1 = 0;
          }
  
          if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
            $uploadOk1 = 0;
          }
  
          if ($uploadOk1 == 1) {
            if (move_uploaded_file($pic['file']['file_0']["tmp_name"], $target_file1)) {
                $txt_path[0] = $avatar_name1;
            }
          }
        }
        else{
          $txt_path[0] = "";
        }

        if($pic['file']['file_1']){
          $target_dir1     =   "../../../uploads/stock-gold";
          $avatar_name1    =   md5('YmdHis').'-'.$random.'-'.date("Ymd-His").'-'.basename($pic['file']['file_1']['name']);
          $target_file1    =   $target_dir1 .'/'.$avatar_name1;
          $uploadOk1       =   1;
          $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
  
          $check1 = getimagesize($pic['file']['file_1']["tmp_name"]);
  
          if($check1 !== false) {
            $uploadOk1 = 1;
          } else {
            $uploadOk1 = 0;
          }
  
          if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
            $uploadOk1 = 0;
          }
  
          if ($uploadOk1 == 1) {
            if (move_uploaded_file($pic['file']['file_1']["tmp_name"], $target_file1)) {
                $txt_path[1] = $avatar_name1;
            }
          }
        }
        else{
          $txt_path[1] = "";
        }

        if($pic['file']['file_2']){
          $target_dir1     =   "../../../uploads/stock-gold";
          $avatar_name1    =   md5('YmdHis').'-'.$random.'-'.date("Ymd-His").'-'.basename($pic['file']['file_2']['name']);
          $target_file1    =   $target_dir1 .'/'.$avatar_name1;
          $uploadOk1       =   1;
          $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
  
          $check1 = getimagesize($pic['file']['file_2']["tmp_name"]);
  
          if($check1 !== false) {
            $uploadOk1 = 1;
          } else {
            $uploadOk1 = 0;
          }
  
          if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
            $uploadOk1 = 0;
          }
  
          if ($uploadOk1 == 1) {
            if (move_uploaded_file($pic['file']['file_2']["tmp_name"], $target_file1)) {
                $txt_path[2] = $avatar_name1;
            }
          }
        }
        else{
          $txt_path[2] = "";
        }

        // insert path
        for($i=0;$i<count($txt_path);$i++){
          if($txt_path[$i] != ""){
            $id = $pic['position']['file_id_'.$i];

            $sql2 = $this->conn->prepare(
            " UPDATE stock_gold_pic SET
                pic_path = :pic_path,
                create_date = :create_date
              WHERE id = :id
            ");
            $sql2->bindParam(':create_date',$now);
            $sql2->bindParam(':id',$id);
            $sql2->bindParam(':pic_path',$txt_path[$i]);
            if($sql2->execute()){
              $suc += 1;
            }
            else{
              $suc -= 1;
            }
          }
        }

        $score_pass = 0;
        foreach($txt_path as $data){
          if($data != ""){
            $score_pass += 1;
          }
        }

        if($suc == $score_pass){
          return true;
        }
        else{
          return false;
        }
      } 
    }

    public function delete(){
      try{
        $sql = $this->conn->prepare("DELETE FROM stock_gold WHERE id = :id ");
        $sql->bindParam(':id',$this->id);
  
        if($sql->execute()){
          $del_history = $this->del_history($this->id);

          $sql2 = $this->conn->prepare("DELETE FROM stock_gold_pic WHERE stock_id = :stock_id ");
          $sql2->bindParam(':stock_id',$this->id);

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

    private function check_insert_item(){
      $sql = $this->conn->prepare("SELECT * FROM stock_gold WHERE product_no = ? AND status = 1 ");
      if($sql->execute([$this->product_no])){
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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    // Warehouse
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_warehouse(){
      try{
        $sql = $this->conn->prepare("
        SELECT 	
          stock.id,
          stock.product_no,
          type.type_name,
          cate.cate_name,
          stock.cost_id,
          stock.wage,
          stock.weight,
          stock.status,
          pic.pic_path
        FROM stock_gold as stock
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON type.id = cate.type_id
        JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
        WHERE stock.position = 2 AND stock.status = 1
        ");
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

    public function add_warehouse(){
      if($this->check_insert_item()){
        $position = 2;

        try{
            $sql = $this->conn->prepare("INSERT INTO stock_gold (position, type_supplier, type_product, product_no, detail, import_date, size, weight, cost, cost_id, cost_price, wage, cost_wage_id, cost_wage, sale_date, price, price_id, status)
            VALUES (:position,:type_supplier,:type_product,:product_no,:detail,:import_date,:size,:weight,:cost,:cost_id,:cost_price,:wage,:cost_wage_id,:cost_wage,:sale_date,:price,:price_id,:status)");
            $sql->bindParam(':position',$position);
            $sql->bindParam(':type_supplier',$this->type_supplier);
            $sql->bindParam(':type_product',$this->type_product);
            $sql->bindParam(':product_no',$this->product_no);
            $sql->bindParam(':detail',$this->detail);
            $sql->bindParam(':import_date',$this->import_date);
            $sql->bindParam(':size',$this->size);
            $sql->bindParam(':weight',$this->weight);
            $sql->bindParam(':cost',$this->cost);
            $sql->bindParam(':cost_id',$this->cost_id);
            $sql->bindParam(':cost_price',$this->cost_price);
            $sql->bindParam(':wage',$this->wage);
            $sql->bindParam(':cost_wage_id',$this->cost_wage_id);
            $sql->bindParam(':cost_wage',$this->cost_wage);
            $sql->bindParam(':sale_date',$this->sale_date);
            $sql->bindParam(':price',$this->price);
            $sql->bindParam(':price_id',$this->price_id);
            $sql->bindParam(':status',$this->status);

            if($sql->execute()){
              $product_id = $this->conn->lastInsertId();

              $add_history = $this->add_history($product_id,1,1);

              return $product_id;
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

    public function update_warehouse(){
      if($this->status == 2){
        $position = 1;
      }
      else{
        $position = 2;
      }

      try{
        $sql = $this->conn->prepare("UPDATE stock_gold SET
          position = :position,
          type_supplier = :type_supplier,
          type_product = :type_product,
          product_no = :product_no,
          detail = :detail,
          import_date = :import_date,
          size = :size,
          weight = :weight,
          cost = :cost,
          cost_id = :cost_id,
          cost_price = :cost_price,
          wage = :wage,
          cost_wage_id = :cost_wage_id,
          cost_wage = :cost_wage,
          sale_date = :sale_date,
          price = :price,
          price_id = :price_id
        WHERE id = :id");
        $sql->bindParam(':position',$position);
        $sql->bindParam(':type_supplier',$this->type_supplier);
        $sql->bindParam(':type_product',$this->type_product);
        $sql->bindParam(':product_no',$this->product_no);
        $sql->bindParam(':detail',$this->detail);
        $sql->bindParam(':import_date',$this->import_date);
        $sql->bindParam(':size',$this->size);
        $sql->bindParam(':weight',$this->weight);
        $sql->bindParam(':cost',$this->cost);
        $sql->bindParam(':cost_id',$this->cost_id);
        $sql->bindParam(':cost_price',$this->cost_price);
        $sql->bindParam(':wage',$this->wage);
        $sql->bindParam(':cost_wage_id',$this->cost_wage_id);
        $sql->bindParam(':cost_wage',$this->cost_wage);
        $sql->bindParam(':sale_date',$this->sale_date);
        $sql->bindParam(':price',$this->price);
        $sql->bindParam(':price_id',$this->price_id);
        $sql->bindParam(':id',$this->id);
  
        if($sql->execute()){
          if($position == 1){
            $change_history = $this->change_history($this->id,2);
            if($change_history){
              $add_history = $this->add_history($this->id,2,1);
            }
          }

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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    // Border
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    public function add_border(){
      if($this->check_insert_item()){
        $position = 3;

        try{
            $sql = $this->conn->prepare("INSERT INTO stock_gold (position, type_supplier, type_product, product_no, detail, import_date, size, weight, cost, cost_id, cost_price, wage, cost_wage_id, cost_wage, sale_date, price, price_id, status)
            VALUES (:position,:type_supplier,:type_product,:product_no,:detail,:import_date,:size,:weight,:cost,:cost_id,:cost_price,:wage,:cost_wage_id,:cost_wage,:sale_date,:price,:price_id,:status)");
            $sql->bindParam(':position',$position);
            $sql->bindParam(':type_supplier',$this->type_supplier);
            $sql->bindParam(':type_product',$this->type_product);
            $sql->bindParam(':product_no',$this->product_no);
            $sql->bindParam(':detail',$this->detail);
            $sql->bindParam(':import_date',$this->import_date);
            $sql->bindParam(':size',$this->size);
            $sql->bindParam(':weight',$this->weight);
            $sql->bindParam(':cost',$this->cost);
            $sql->bindParam(':cost_id',$this->cost_id);
            $sql->bindParam(':cost_price',$this->cost_price);
            $sql->bindParam(':wage',$this->wage);
            $sql->bindParam(':cost_wage_id',$this->cost_wage_id);
            $sql->bindParam(':cost_wage',$this->cost_wage);
            $sql->bindParam(':sale_date',$this->sale_date);
            $sql->bindParam(':price',$this->price);
            $sql->bindParam(':price_id',$this->price_id);
            $sql->bindParam(':status',$this->status);

            if($sql->execute()){
              $product_id = $this->conn->lastInsertId();

              $add_history = $this->add_history($product_id,3,1);

              return $product_id;
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

    public function get_border(){
      try{
        $sql = $this->conn->prepare("
        SELECT 	
          stock.id,
          stock.product_no,
          type.type_name,
          cate.cate_name,
          stock.cost_id,
          stock.wage,
          stock.weight,
          stock.status,
          pic.pic_path
        FROM stock_gold as stock
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON type.id = cate.type_id
        JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
        WHERE stock.position = 3 AND stock.status = 1
        ");
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

    public function update_border(){
      $position = 3;

      try{
        $sql = $this->conn->prepare("UPDATE stock_gold SET
          position = :position,
          type_supplier = :type_supplier,
          type_product = :type_product,
          product_no = :product_no,
          detail = :detail,
          import_date = :import_date,
          size = :size,
          weight = :weight,
          cost = :cost,
          cost_id = :cost_id,
          cost_price = :cost_price,
          wage = :wage,
          cost_wage_id = :cost_wage_id,
          cost_wage = :cost_wage,
          sale_date = :sale_date,
          price = :price,
          price_id = :price_id
        WHERE id = :id");
        $sql->bindParam(':position',$position);
        $sql->bindParam(':type_supplier',$this->type_supplier);
        $sql->bindParam(':type_product',$this->type_product);
        $sql->bindParam(':product_no',$this->product_no);
        $sql->bindParam(':detail',$this->detail);
        $sql->bindParam(':import_date',$this->import_date);
        $sql->bindParam(':size',$this->size);
        $sql->bindParam(':weight',$this->weight);
        $sql->bindParam(':cost',$this->cost);
        $sql->bindParam(':cost_id',$this->cost_id);
        $sql->bindParam(':cost_price',$this->cost_price);
        $sql->bindParam(':wage',$this->wage);
        $sql->bindParam(':cost_wage_id',$this->cost_wage_id);
        $sql->bindParam(':cost_wage',$this->cost_wage);
        $sql->bindParam(':sale_date',$this->sale_date);
        $sql->bindParam(':price',$this->price);
        $sql->bindParam(':price_id',$this->price_id);
        $sql->bindParam(':id',$this->id);
  
        if($sql->execute()){
          $change_history = $this->change_history($this->id,1);

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

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    // dashboard
    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_dashboard(){
      $farr = array();

      try{
        $presql = $this->conn->prepare("SELECT COUNT(id) as warehouse FROM stock_gold WHERE position = 2");
        if($presql->execute()){
          $result = $presql->fetch(PDO::FETCH_NAMED);
          $farr['warehouse'] = $result['warehouse'];
        }
        else{
          $farr['warehouse'] = 0;
        }

        $presql2 = $this->conn->prepare("SELECT COUNT(id) as stock FROM stock_gold WHERE position = 1");
        if($presql2->execute()){
          $result = $presql2->fetch(PDO::FETCH_NAMED);
          $farr['stock'] = $result['stock'];
        }
        else{
          $farr['stock'] = 0;
        }

        $presql3 = $this->conn->prepare("SELECT COUNT(id) as list_sale,SUM(price) as sum_sale FROM stock_gold WHERE position = 1 AND status = 2");
        if($presql3->execute()){
          $result = $presql3->fetch(PDO::FETCH_NAMED);
          $farr['sale']['list_sale'] = $result['list_sale'];
          $farr['sale']['sum_sale'] = $result['sum_sale'];
        }
        else{
          $farr['sale']['list_sale'] = 0;
          $farr['sale']['sum_sale'] = 0;
        }

        $sql = $this->conn->prepare("
        SELECT stock.product_no,stock.weight,stock.sale_date,stock.price,user.fullname
        FROM stock_gold as stock
        JOIN transection_gold as trans ON stock.id = trans.item_id
        JOIN user ON user.id = trans.user_id
        WHERE stock.status = 2
        ORDER BY stock.sale_date DESC
        LIMIT 10
        ");
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          $farr['item'] = $arr;
        }


        if(count($farr) > 0){
          return $farr;
        }
        else{
          return false;
        }
      }
      catch(PDOException $e){
          echo "Error: " . $e->getMessage();
      }
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    // search & history
    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    public function search($position,$txt,$type,$cate){
      $txt_f = '%'.$txt.'%';

      $pre_sql = "
        SELECT 	
          stock.id,
          stock.product_no,
          type.type_name,
          cate.cate_name,
          stock.cost_id,
          stock.wage,
          stock.weight,
          stock.status,
          pic.pic_path
        FROM stock_gold as stock
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON type.id = cate.type_id
        JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
        WHERE stock.position = :position
      "; 

      if($txt != ""){
        $pre_sql .= " AND stock.product_no LIKE :product_no";
      }

      try{
        if($type != ""){
          $pre_sql .= " AND stock.type_product = :cate ";
        }

        $sql = $this->conn->prepare($pre_sql);
        $sql->bindParam(':position',$position);
        if($txt != ""){
          $sql->bindParam(':product_no',$txt_f);
        }
        if($type != ""){
          $sql->bindParam(':cate',$cate);
        }
        
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

    private function add_history($product_id,$history_type,$history_status){
      $sql2 = $this->conn->prepare("INSERT INTO history_product(product_id,product_type,date,id_admin,status)
        VALUES (:product_id,:product_type,:date,:id_admin,:status)
      ");
      $now = date("Y-m-d H:i:s");
      $history_adamin = $_SESSION['admin_id'];
      $sql2->bindParam(':product_id',$product_id);
      $sql2->bindParam(':product_type',$history_type);
      $sql2->bindParam(':date',$now);
      $sql2->bindParam(':id_admin',$history_adamin);
      $sql2->bindParam(':status',$history_status);
      if($sql2->execute()){
        return true;
      }
      else{
        return false;
      }
    }

    private function change_history($product_id,$history_status){
      $now = date("Y-m-d H:i:s");
      $sql2 = $this->conn->prepare("UPDATE history_product SET
          id_admin = :id_admin,
          date = :date,
          status = :status
        WHERE product_id = :product_id
      ");
      $history_adamin = $_SESSION['admin_id'];
      $sql2->bindParam(':product_id',$product_id);
      $sql2->bindParam(':date',$now);
      $sql2->bindParam(':id_admin',$history_adamin);
      $sql2->bindParam(':status',$history_status);
      if($sql2->execute()){
        return true;
      }
      else{
        return false;
      }
    }

    private function del_history($product_id){
      $sql2 = $this->conn->prepare("UPDATE history_product SET
          id_admin = :id_admin,
          status = 3 
        WHERE product_id = :product_id
      ");
      $history_adamin = $_SESSION['admin_id'];
      $sql2->bindParam(':product_id',$product_id);
      $sql2->bindParam(':id_admin',$history_adamin);
      if($sql2->execute()){
        return true;
      }
      else{
        return false;
      }
    }

    public function call_history($product_cate,$his_type,$his_status){
      $sql = $this->conn->prepare("
        SELECT his.date as date, 
        (SELECT COUNT(h.id) FROM history_product as h JOIN stock_gold as s ON s.id = h.product_id where h.product_type = :his_type and h.status = :his_status AND s.type_product = :product_cate) as amount
        FROM history_product as his
        JOIN stock_gold as stock ON stock.id = his.product_id
        WHERE his.product_type = :his_type AND his.status = :his_status AND stock.type_product = :product_cate
        ORDER BY his.date DESC LIMIT 1
      ");
      $sql->bindParam(':product_cate',$product_cate);
      $sql->bindParam(':his_type',$his_type);
      $sql->bindParam(':his_status',$his_status);
      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_NAMED);

        if($result != ""){
          return $result;
        }
        else{
          return false;
        }
      }
    }

    public function amount_table($cate_id,$position){
      try{
        $sql = $this->conn->prepare("SELECT COUNT(id) as amount FROM stock_gold WHERE type_product = :type_product AND position = :position AND status = 1;");
        $sql->bindParam(':type_product',$cate_id);
        $sql->bindParam(':position',$position);
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
}