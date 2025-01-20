<?php

class Stock_jewelry_product{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->type_build = $data['type_build'];
    $this->stock_date = $data['stock_date'];
    $this->type_product = $data['type_product'];
    $this->product_no = $data['product_no'];
    $this->detail = $data['detail'];
    $this->size = $data['size'];
    $this->weight = $data['weight'];
    $this->cost = $data['cost'];
    $this->cost_id = $data['cost_id'];
    $this->price_sale = $data['price_sale'];
    $this->price_id = $data['price_id'];
    $this->sale_date = $data['sale_date'];
    $this->status_product = $data['status_product'];
    $this->reuse_product = $data['reuse_product'];
    $this->reuse_detail = $data['reuse_detail'];
    $this->id = $data['id'];
  }

  public function add($product_name,$other_cost,$show_front){
    try{
      $sql = $this->conn->prepare("INSERT INTO stock_product_diamond (type_build, stock_date, type_product, product_no, product_name, detail, size, weight, cost, other_cost, cost_id, price_sale, price_id, sale_date, status_product, reuse_product, reuse_detail, show_front)
      VALUES (:type_build,:stock_date,:type_product,:product_no,:product_name,:detail,:size,:weight,:cost,:other_cost,:cost_id,:price_sale,:price_id,:sale_date,:status_product,:reuse_product,:reuse_detail,:show_front)");
      $sql->bindParam(':type_build',$this->type_build);
      $sql->bindParam(':stock_date',$this->stock_date);
      $sql->bindParam(':type_product',$this->type_product);
      $sql->bindParam(':product_no',$this->product_no);
      $sql->bindParam(':product_name',$product_name);
      $sql->bindParam(':detail',$this->detail);
      $sql->bindParam(':size',$this->size);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':cost',$this->cost);
      $sql->bindParam(':other_cost',$other_cost);
      $sql->bindParam(':cost',$this->cost);
      $sql->bindParam(':cost_id',$this->cost_id);
      $sql->bindParam(':price_sale',$this->price_sale);
      $sql->bindParam(':price_id',$this->price_id);
      $sql->bindParam(':sale_date',$this->sale_date);
      $sql->bindParam(':status_product',$this->status_product);
      $sql->bindParam(':reuse_product',$this->reuse_product);
      $sql->bindParam(':reuse_detail',$this->reuse_detail);
      $sql->bindParam(':show_front',$show_front);

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

  public function add_import($data){
    $status = 1;
    $now = date('Y-m-d H:i:s');

    try{
      $sql = $this->conn->prepare("INSERT INTO stock_product_diamond_import(loose_id, body_supplier, body_cost, body_weight, body_gold, body_percent, body_type, product_id, import_date, product_cate, product_size, product_weight, product_status, product_reuse, product_reuse_detail, status)
      VALUES(:loose_id,:body_supplier,:body_cost,:body_weight,:body_gold,:body_percent,:body_type,:product_id,:import_date,:product_cate,:product_size,:product_weight,:product_status,:product_reuse,:product_reuse_detail,:status)");
      $sql->bindParam(':loose_id',$data['loose_diamond']);
      $sql->bindParam(':body_supplier',$data['body_diamond']);
      $sql->bindParam(':body_cost',$data['body_cost']);
      $sql->bindParam(':body_weight',$data['body_weight']);
      $sql->bindParam(':body_gold',$data['body_color']);
      $sql->bindParam(':body_percent',$data['body_percentage']);
      $sql->bindParam(':body_type',$data['body_type']);
      $sql->bindParam(':product_id',$this->product_no);
      $sql->bindParam(':import_date',$now);
      $sql->bindParam(':product_cate',$this->type_product);
      $sql->bindParam(':product_size',$this->size);
      $sql->bindParam(':product_weight',$this->weight);
      $sql->bindParam(':product_status',$this->status_product);
      $sql->bindParam(':product_reuse',$this->reuse_product);
      $sql->bindParam(':product_reuse_detail',$this->reuse_detail);
      $sql->bindParam(':status',$status);

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

  public function assembly_diamond($data){
    $now = date("Y-m-d H:i:s");
    $loose_arr = $data['loose_diamond'];

    try{
      $sql = $this->conn->prepare("INSERT INTO diamond_assembly(product_id, loose_diamond, body_id, create_date)
      VALUES(:product_id,:loose_diamond,:body_id,:create_date)");
      $sql->bindParam(':product_id',$data['product_id']);
      $sql->bindParam(':loose_diamond',$loose_arr);
      $sql->bindParam(':body_id',$data['body_diamond']);
      $sql->bindParam(':create_date',$now);

      if($sql->execute()){
        if($this->update_diamond_assembly($data['loose_diamond']) && $this->update_body_assembly($data['body_diamond'])){
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

  public function get(){
      try{
          $sql = $this->conn->prepare("SELECT * FROM stock_product_diamond WHERE status_product = 1");
          if($sql->execute()){
            $arr = array();
            while($result = $sql->fetch(PDO::FETCH_NAMED)){
              $result['import'] = "";
              $arr[] = $result;
            }

            // $sql2 = $this->conn->prepare("SELECT * FROM stock_product_diamond_import WHERE product_status = 1");
            // $sql2->execute();
            // while($result = $sql2->fetch(PDO::FETCH_NAMED)){
            //   $result['import'] = "true";
            //   $arr[] = $result;
            // }

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
        FROM stock_product_diamond
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

  public function get_assembly(){
    try{
      $sql = $this->conn->prepare("
        SELECT *
        FROM diamond_assembly
        WHERE product_id = :id
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

  public function get_data_type($type_id){
    try{
      $sql = $this->conn->prepare("
        SELECT cate.id as cate_id,cate.cate_name,type.id as type_id,type.type_name
        FROM product_cate as cate
        JOIN product_type as type ON type.id = cate.type_id
        WHERE cate.id = :type_id
      ");
      $sql->bindParam(':type_id',$type_id);
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

  public function get_type_all($product_type){
    try{
      $sql = $this->conn->prepare("
        SELECT type.id as type_id,type.type_name
        FROM product_type as type
        WHERE type.product_type = :product_type AND type.status = 1
      ");
      $sql->bindParam(':product_type',$product_type);
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

  public function get_cate_all($type_id){
    try{
      $sql = $this->conn->prepare("
        SELECT cate.id,cate.cate_name
        FROM product_cate as cate
        WHERE cate.type_id = :type_id
      ");
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

  public function update($product_name,$other_cost,$show_front){
    try{
      $sql = $this->conn->prepare("UPDATE stock_product_diamond SET
        type_build = :type_build,
        stock_date = :stock_date,
        type_product = :type_product,
        product_no = :product_no,
        product_name = :product_name,
        detail = :detail,
        size = :size,
        weight = :weight,
        cost = :cost,
        other_cost = :other_cost,
        cost_id = :cost_id,
        status_product = :status_product,
        reuse_product = :reuse_product,
        reuse_detail = :reuse_detail,
        show_front = :show_front 
      WHERE id = :id");
      $sql->bindParam(':type_build',$this->type_build);
      $sql->bindParam(':stock_date',$this->stock_date);
      $sql->bindParam(':type_product',$this->type_product);
      $sql->bindParam(':product_no',$this->product_no);
      $sql->bindParam(':product_name',$product_name);
      $sql->bindParam(':detail',$this->detail);
      $sql->bindParam(':size',$this->size);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':cost',$this->cost);
      $sql->bindParam(':other_cost',$other_cost);
      $sql->bindParam(':cost_id',$this->cost_id);
      $sql->bindParam(':status_product',$this->status_product);
      $sql->bindParam(':reuse_product',$this->reuse_product);
      $sql->bindParam(':reuse_detail',$this->reuse_detail);
      $sql->bindParam(':show_front',$show_front);
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
      $sql = $this->conn->prepare("DELETE FROM stock_product_diamond WHERE id = :id ");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        $sql2 = $this->conn->prepare("DELETE FROM stock_product_diamond_pic WHERE product_id = :id ");
        $sql2->bindParam(':id',$this->id);
        $sql2->execute();
        
        $sql3 = $this->conn->prepare("SELECT loose_diamond FROM diamond_assembly WHERE product_id = :product_id ");
        $sql3->bindParam(':product_id',$this->id);
        if($sql3->execute()){
          $result = $sql3->fetch(PDO::FETCH_NAMED);
  
          if($result){
            $raw_data = json_decode($result['loose_diamond']);

            foreach($raw_data as $data){
              $sql_return = $this->conn->prepare("
              UPDATE stock_loose_diamond SET
                amount = (SELECT stock.amount FROM stock_loose_diamond as stock WHERE stock.id = ".$data->loose_id.") + ".$data->amount."
              WHERE id = ".$data->loose_id."
              ");
              $sql_return->execute();
            }

            $sql4 = $this->conn->prepare("DELETE FROM diamond_assembly WHERE product_id = :id ");
            $sql4->bindParam(':id',$this->id);
            if($sql4->execute()){
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

  public function upload_file($pic,$item_id){
    $suc = false;
    $id = $item_id;
    $now = date('Y-m-d H:i:s');

    if(count($pic['file'])>0){
      $txt_path = array("","","");

      for($i=0;$i<count($pic['file']);$i++){
        $target_dir1     =   "../../../uploads/stock-jewelry";
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
    $sql2 = $this->conn->prepare("INSERT INTO stock_product_diamond_pic(product_id,path_1,path_2,path_3,create_date) 
                                  VALUES(:product_id,:path_1,:path_2,:path_3,:create_date)");
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':product_id',$id);
    $sql2->bindParam(':path_1',$txt_path[0]);
    $sql2->bindParam(':path_2',$txt_path[1]);
    $sql2->bindParam(':path_3',$txt_path[2]);
    if($sql2->execute()){
      $suc = true;
    }

    if($suc){
      return true;
    }
    else{
      return false;
    }
    
  }

  public function upload_file_import($pic,$item_id){
    $suc = false;
    $id = $item_id;
    $now = date('Y-m-d H:i:s');

    if(count($pic['file'])>0){
      $txt_path = array("","","");

      for($i=0;$i<count($pic['file']);$i++){
        $target_dir1     =   "../../../uploads/stock-jewelry";
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
    $sql2 = $this->conn->prepare("INSERT INTO stock_product_diamond_pic_import(product_id,path_1,path_2,path_3,create_date) 
                                  VALUES(:product_id,:path_1,:path_2,:path_3,:create_date)");
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':product_id',$id);
    $sql2->bindParam(':path_1',$txt_path[0]);
    $sql2->bindParam(':path_2',$txt_path[1]);
    $sql2->bindParam(':path_3',$txt_path[2]);
    if($sql2->execute()){
      $suc = true;
    }

    if($suc){
      return true;
    }
    else{
      return false;
    }
    
  }

  public function get_pic($id){
    try{
      $sql = $this->conn->prepare("SELECT * FROM cer_loose_diamond WHERE loose_id = :id");
      $sql->bindParam(':id',$id);
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

  public function get_pic_product($id){
    try{
      $sql = $this->conn->prepare("SELECT * FROM stock_product_diamond_pic WHERE product_id = :id");
      $sql->bindParam(':id',$id);
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

  public function update_file($pic,$id){
    $suc = false;
    $now = date('Y-m-d H:i:s');

    if($pic != ""){
      $txt_path = "";

      $target_dir1     =   "../../../uploads/loose-cer";
      $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($pic['name']);
      $target_file1    =   $target_dir1 .'/'.$avatar_name1;
      $uploadOk1       =   1;
      $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

      $check1 = getimagesize($pic["tmp_name"]);

      if($check1 !== false) {
        $uploadOk1 = 1;
      } else {
        $uploadOk1 = 0;
      }

      if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
        $uploadOk1 = 0;
      }

      if ($uploadOk1 == 1) {
        if (move_uploaded_file($pic["tmp_name"], $target_file1)) {
            $txt_path = $avatar_name1;
        }
      }
    }

    // insupdateert path
    $sql2 = $this->conn->prepare("UPDATE cer_loose_diamond SET
                                    file_part = :file_part,
                                    create_date = :create_date
                                  WHERE loose_id = :loose_id");
    $sql2->bindParam(':file_part',$txt_path);
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':loose_id',$id);
    if($sql2->execute()){
      $suc = true;
    }

    if($suc){
      return true;
    }
    else{
      return false;
    }
  }

  private function update_diamond_assembly($data){
    try{
      $status = 0;
      $loose = json_decode($data);
      for($i=0;$i<count($loose);$i++){
        $sql2 = $this->conn->prepare("UPDATE stock_loose_diamond SET
                                        amount = (SELECT stock.amount FROM stock_loose_diamond as stock WHERE stock.id = ".$loose[$i]->loose_id.")-".$loose[$i]->amount.",
                                        weight = (SELECT stock.weight FROM stock_loose_diamond as stock WHERE stock.id = ".$loose[$i]->loose_id.")-".$loose[$i]->weight."
                                      WHERE id = ".$loose[$i]->loose_id."
                                    ");
        if($sql2->execute()){
          $status += 0;
        }
        else{
          $status += 1;
        }
      }
  
      if($status == 0){
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

  private function update_body_assembly($data){
    try{
      $sql2 = $this->conn->prepare("
      UPDATE stock_body_diamond SET
        amount = (SELECT stock.amount FROM stock_body_diamond as stock WHERE stock.id = ".$data.")-1 
      WHERE id = ".$data."
      ");
      if($sql2->execute()){
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

  public function get_data_body_id($id){
    try{
      $sql = $this->conn->prepare("
        SELECT *
        FROM stock_body_diamond
        WHERE id = :id
      ");
      $sql->bindParam(':id',$id);
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

  public function get_data_loose($id){
    try{
      $sql = $this->conn->prepare("
        SELECT *
        FROM stock_loose_diamond
        WHERE id = :id
      ");
      $sql->bindParam(':id',$id);
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

  public function get_data_waranty(){
    try{
      $sql = $this->conn->prepare("
        SELECT stock.*,body.type_material,body.percent_gold,body.gold,body.weight as gold_weight,ass.loose_diamond
        FROM stock_product_diamond as stock
        JOIN diamond_assembly as ass ON ass.product_id = stock.id
        JOIN stock_body_diamond as body ON ass.body_id = body.id
        WHERE stock.id = :id;
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

  public function history_change_product($admin_id,$old_weight){
    try{
      $now = date('Y-m-d H:i:s');

      if($old_weight != $this->weight){
        $sql1 = $this->conn->prepare("INSERT INTO history_diamond_product(product_id,weight_change,update_date,admin_id)
        VALUES (:product_id,:weight_change,:update_date,:admin_id)");
        $sql1->bindParam(':product_id',$this->id);
        $sql1->bindParam(':weight_change',$this->weight);
        $sql1->bindParam(':update_date',$now);
        $sql1->bindParam(':admin_id',$admin_id);

        if($sql1->execute()){
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

  public function get_history(){
    try{
      $sql = $this->conn->prepare("
        SELECT his.*,staff.username 
        FROM history_diamond_product as his 
        JOIN staff ON staff.id = his.admin_id 
        WHERE his.product_id = :item_id AND his.status = 1 
        ORDER BY his.update_date DESC;
      ");
      $sql->bindParam(':item_id',$this->id);
      if($sql->execute()){
        $re_arr = array();

        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $re_arr[] = $result;
        }

        if($re_arr){
          return $re_arr;
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