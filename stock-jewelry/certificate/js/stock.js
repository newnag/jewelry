function add(){
  let data = new FormData()
  data.append('type_build',document.querySelector('#type_build').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('type_product',document.querySelector('#product_cate').value)
  data.append('product_no',document.querySelector('#product_no').value)
  data.append('detail',document.querySelector('#detail').value)
  data.append('size',document.querySelector('#size').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('cost',document.querySelector('#cost').value)
  data.append('cost_id',document.querySelector('#cost_id').value)
  data.append('status_product',document.querySelector('#status_product').value)
  data.append('reuse_product',document.querySelector('#reuse_product').value)
  data.append('reuse_detail',document.querySelector('#reuse_detail').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  data.append('file_2',document.querySelector('#file_2').files[0])  
  data.append('file_3',document.querySelector('#file_3').files[0])  

  $.ajax({
    method: "POST",
    url: "functions/add-item.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){ 
      Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จ',
      }).then(()=>{
          location.href = "https://thavorn-jewelry.com/stock-jewelry/certificate"
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
      })
    }
  })
}

function get(){
    $.ajax({
      method: "POST",
      url: "functions/get-item.php",
      dataType: 'json',
      success:function(result){
        // console.log(result)
        const table = document.querySelector('#table-gold tbody')
  
        for(i=0;i<result.length;i++){
            let sale_date
            if(result[i].sale_date == "0000-00-00"){
                sale_date = "-"
            }
            else{
                sale_date = result[i].sale_date
            }

            let status = ""
            switch (result[i].status) {
              case "1":
                status = "สต็อก"
                break;
              case "2":
                status = "ขายแล้ว"
                break;
            }

            let tem = `
            <tr>
              <td class="no">${result[i].product_no}</td>
              <td class="type_product">${result[i].type_name}</td>
              <td class="import_date">${result[i].import_date}</td>
              <td class="sale_date">${sale_date}</td>
              <td class="weight">${result[i].weight} กรัม</td>
              <td class="status">${status}</td>
              <td>
                  <div class="col-12">
                  <div class="row">
                  <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit(${result[i].id})">ดู/แก้ไข</button></div>
                  <div class="col-auto"><button type="button" style="width:fit-content;" class="btn btn-block bg-gradient-danger btn-cus-w" onclick="item_delete(${result[i].id})">ลบ</button></div>
                  <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-success btn-cus-w" onclick="get_barcode('${result[i].product_no}')">บาร์โค้ด</button></div>
                  </div>
                  </div>
              </td>
            </tr>
            `
            table.insertAdjacentHTML('beforeend',tem)
        }
        
      },
      error:function(textStatus){
        const table = document.querySelector('#table-gold tbody')
        let tem = `
          <tr>
            <td>ไม่มีข้อมูลแสดงผล</td>
          </tr>
          `
        table.insertAdjacentHTML('beforeend',tem)
        console.log(textStatus.responseText)
      }
    })
}

function get_type(){
  $.ajax({
    method: "POST",
    url: "functions/get-type.php",
    dataType: 'json',
    success:function(result){
      const select_type = document.querySelector('#product_type')

      let pretem = `
          <option value="">เลือกประเภทสินค้า</option>
          `
          select_type.insertAdjacentHTML('beforeend',pretem)

      for(i=0;i<result.length;i++){
          
          let tem = `
          <option value="${result[i].id}">${result[i].type_name}</option>
          `
          select_type.insertAdjacentHTML('beforeend',tem)
      }
      
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

function update(){
  let data = new FormData()
  data.append('supplier_type',document.querySelector('#supplier_type').value)
  data.append('product_no',document.querySelector('#product_no').value)
  data.append('product_cate',document.querySelector('#product_cate').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('detail',document.querySelector('#detail').value)
  data.append('import_date',document.querySelector('#import_date').value)
  data.append('cost_id',document.querySelector('#cost_id').value)
  data.append('cost',document.querySelector('#cost').value)
  data.append('sale_date',document.querySelector('#sale_date').value)
  data.append('price_id',document.querySelector('#price_id').value)
  data.append('price',document.querySelector('#price').value)
  data.append('status',document.querySelector('#status').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  data.append('file_2',document.querySelector('#file_2').files[0])  
  data.append('file_3',document.querySelector('#file_3').files[0])  
  data.append('file_id_0',document.querySelector('#file_id_0').value)
  data.append('file_id_1',document.querySelector('#file_id_1').value)
  data.append('file_id_2',document.querySelector('#file_id_2').value)
  data.append('item_id',document.querySelector('#item_id').value)

  $.ajax({
    method: "POST",
    url: "functions/update-item.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){ 
      Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จ',
      }).then(()=>{
          location.href = "https://thavorn-jewelry.com/stock-jewelry/certificate"
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
      })
      return false;
    }
  })
}

function item_delete(id){
  Swal.fire({
    title: 'คุณต้องการลบใช่หรือไม่?',
    showDenyButton: true,
    confirmButtonText: 'ลบ',
    denyButtonText: `ไม่ลบ`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "functions/delete-item.php",
        data: {
          id:id
        },
        success:function(result){
          if(result == "success"){
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: 'ลบข้อมูลสำเร็จ',
            }).then(()=>{
              location.reload();
            })
          }
        },
        error:function(textStatus){
          console.log(textStatus.responseText)
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถลบข้อมูลได้',
          })
        }
      })
    } 
    else if (result.isDenied) {
      return false
    }
  })
}

// เมื่อเลือกประเภทสินค้า
document.querySelector('#product_type').addEventListener('change',()=>{
  let data = {id:document.querySelector('#product_type').value}
  $("#product_cate").empty()

  $.ajax({
    method: "POST",
    url: "functions/get-cate.php",
    data: data,
    dataType: 'json',
    success:function(result){
      // console.log(result)
      if(result != "error"){
        const select_type = document.querySelector('#product_cate')

        for(i=0;i<result.length;i++){
            
            let tem = `
            <option value="${result[i].id}">${result[i].cate_name}</option>
            `
            select_type.insertAdjacentHTML('beforeend',tem)
        }
      } 
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
      let sel = document.querySelector('#product_type')
      let sel_val = sel.value
      let txt = sel.options[sel.selectedIndex].text

      const select_type = document.querySelector('#product_cate')
      let tem = `
      <option value="${sel_val}">${txt}</option>
      `
      select_type.insertAdjacentHTML('beforeend',tem)
    }
  })
})

// เมื่อเลือกรูปภาพ
function change_name_pic(that){
  let name = that.files[0]['name']
  that.closest('.custom-file').querySelector('.custom-file-label').textContent = name
}

// ปุ่มกลับไปหน้าแรก
function goback(){
  location.href = "https://thavorn-jewelry.com/stock-jewelry/certificate/"
}

// สร้างบาร์โค้ดเป็นรูป
function get_barcode(barcode){
  window.open("https://thavorn-jewelry.com/stock-jewelry/certificate/barcode.php?barcode="+barcode,'_blank')
}


//////////////////////////////////////////////////////////////////////////////////////////
// zone modal loose
//////////////////////////////////////////////////////////////////////////////////////////

// get loose for add modal
function get_loose_modal(){
  $('#add-loose-item').empty()

  $.ajax({
    method: "POST",
    url: "functions/get-loose-modal.php",
    dataType: 'json',
    success:function(result){
      const select = document.querySelector('#add-loose-item')

      for(i=0;i<result.length;i++){
        let tem = `
        <option value="${result[i].id}" data-option-amount="${result[i].amount}" data-option-name="${result[i].supplier}" data-option-cost="${result[i].price}" data-option-weight="${result[i].weight}" data-option-diamond_shape="${result[i].diamond_shape}">${result[i].supplier} | หนัก: ${result[i].weight} | จำนวน: ${result[i].amount}</option>
        `
        select.insertAdjacentHTML('beforeend',tem)
      }
      
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

// check amount selector modal add loose
document.querySelector('#add-loose-amount').addEventListener('keyup',()=>{
  const inputnum = document.querySelector('#add-loose-amount')
  const option = document.querySelector('#add-loose-item')
  let amount = option.options[option.selectedIndex].getAttribute('data-option-amount')

  if(parseInt(inputnum.value) > parseInt(amount)){
    inputnum.value = amount
  }
})

// clear amount when change select
document.querySelector('#add-loose-item').addEventListener('change',()=>{
  document.querySelector('#add-loose-amount').value = ""
})

// add option loose
function add_loose_modal(){
  const option = document.querySelector('#add-loose-item')
  let data = {
    "id" : document.querySelector('#add-loose-item').value,
    "name" : option.options[option.selectedIndex].getAttribute('data-option-name'),
    "amount" : document.querySelector('#add-loose-amount').value,
    "cost" : option.options[option.selectedIndex].getAttribute('data-option-cost'),
    "weight" : option.options[option.selectedIndex].getAttribute('data-option-weight'),
    "shape" : option.options[option.selectedIndex].getAttribute('data-option-diamond_shape'),
  }

  if(data.amount == "" || data.amount == 0){
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน',
      text: 'ท่านไม่ได้ใส่จำนวน',
    }).then(()=>{
      $('#modal-add-loose').modal('toggle');
      return false
    })
  }

  let total_cost = parseInt(data.amount)*parseFloat(data.cost)

  const table = document.querySelector('#table-loose tbody')
  let tem = `
            <tr data-loose-id="${data.id}">
              <th>${data.name}</th>
              <th>${data.shape}</th>
              <th>${data.weight}</th>
              <th class="amount">${data.amount}</th>
              <th class="cost">${total_cost.toLocaleString('en-US')}</th>
              <th><button class="btn btn-sm btn-danger" onclick="delete_item_table_loose(this)">ลบ</button></th>
            </tr>   
            `
  table.insertAdjacentHTML('beforeend',tem)
  document.querySelector('#add-loose-amount').value = ""
  $('#modal-add-loose').modal('toggle');

  resume_cost()
}

// delete option loose
function delete_item_table_loose(that){
  const ele = that.closest('tr')
  ele.remove()
}

//////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////
// zone modal body
//////////////////////////////////////////////////////////////////////////////////////////

document.querySelector('#select_body').addEventListener('change',()=>{
  let option_body = document.querySelector('#select_body').value

  $.ajax({
    method: "POST",
    url: "functions/get-body-modal.php",
    data: {id:option_body},
    dataType: 'json',
    success:function(result){
      document.querySelector('#body_weight').value = result.weight
      document.querySelector('#body_cost').value = result.price

      resume_cost()
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
})



//////////////////////////////////////////////////////////////////////////////////////////

// open textarea reuseProduct
document.querySelector("#reuse_product").addEventListener('change',(e)=>{
  if(e.target.value != ""){
    document.querySelector('#reuse_detail').disabled = false
  }
  else{
    document.querySelector('#reuse_detail').disabled = true
    document.querySelector('#reuse_detail').value = ""
  }
})

// sumcost
function resume_cost(){
  let text = document.querySelectorAll('#table-loose tbody tr')
  let body = document.querySelector('#body_cost')
  let sum = 0
  text.forEach(ele => {
    stext = ele.querySelector('.cost').textContent.replace(/,/g,'') 
    sum += parseInt(stext)
  });

  if(body.value > 0 || body.value > ""){
    sum += parseInt(body.value)
  }

  document.querySelector('#cost').value = sum
}