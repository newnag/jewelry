function add(){
  let chk_front = 2
  if(document.querySelector('#show_catalog').checked){
    chk_front = 1
  }

  let data = new FormData()
  data.append('type_build',document.querySelector('#type_build').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('type_product',document.querySelector('#product_cate').value)
  data.append('product_no',document.querySelector('#product_no').value)
  data.append('product_name',document.querySelector('#product_name').value)
  data.append('detail',document.querySelector('#detail').value)
  data.append('size',document.querySelector('#size').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('cost',document.querySelector('#cost').value)
  data.append('other_cost',document.querySelector('#other_cost').value)
  data.append('cost_id',document.querySelector('#cost_id').value)
  data.append('status_product',document.querySelector('#status_product').value)
  data.append('reuse_product',document.querySelector('#reuse_product').value)
  data.append('reuse_detail',document.querySelector('#reuse_detail').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  data.append('file_2',document.querySelector('#file_2').files[0])  
  data.append('file_3',document.querySelector('#file_3').files[0])  
  data.append('show_front',chk_front)  

  // prepair data loose diamond
  let loose_arr = []
  let loose_diamond = document.querySelectorAll('#table-loose tbody tr')
  loose_diamond.forEach(data => {
    let ex_arr = {
      "loose_id"  : data.getAttribute('data-loose-id'),
      "amount"    : data.querySelector('.amount').textContent,
      "weight"    : data.querySelector('.weight').textContent 
    }
    loose_arr.push(ex_arr)
  });
  data.append('loose_diamond',JSON.stringify(loose_arr))

  // prepair data body
  let body_diamond = document.querySelector('#select_body').value
  data.append('body_diamond',body_diamond)

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
          location.href = "https://thavorn-jewelry.com/stock-jewelry/stock"
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
  let chk_front = 2
  if(document.querySelector('#show_catalog').checked){
    chk_front = 1
  }

  let data = new FormData()
  data.append('item_id',document.querySelector('#item_id').value)
  data.append('type_build',document.querySelector('#type_build').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('type_product',document.querySelector('#product_cate').value)
  data.append('product_no',document.querySelector('#product_no').value)
  data.append('product_name',document.querySelector('#product_name').value)
  data.append('detail',document.querySelector('#detail').value)
  data.append('size',document.querySelector('#size').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('cost',document.querySelector('#cost').value)
  data.append('other_cost',document.querySelector('#other_cost').value)
  data.append('cost_id',document.querySelector('#cost_id').value)
  data.append('status_product',document.querySelector('#status_product').value)
  data.append('reuse_product',document.querySelector('#reuse_product').value)
  data.append('reuse_detail',document.querySelector('#reuse_detail').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  data.append('file_2',document.querySelector('#file_2').files[0])  
  data.append('file_3',document.querySelector('#file_3').files[0])  
  data.append('show_front',chk_front)  

  $.ajax({
    method: "POST",
    url: "functions/update-item.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){ 
      save_history()
      Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จ',
      }).then(()=>{
          
          location.href = "https://thavorn-jewelry.com/stock-jewelry/stock"
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
              location.href = "https://thavorn-jewelry.com/stock-jewelry/stock/";
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

// เพิ่มราคาต้นทุนตัวเรือนที่สินค้านำเข้า
if(document.querySelector('#body_cost')){
  document.querySelector('#body_cost').addEventListener('change',()=>{
    document.querySelector('#cost').value = ""

    resume_cost()

    let cost = document.querySelector('#cost').value
    document.querySelector('#cost').value = parseFloat(cost) + parseFloat(document.querySelector('#body_cost').value)
  })
}

// เมื่อเลือกรูปภาพ
function change_name_pic(that){
  let name = that.files[0]['name']
  that.closest('.custom-file').querySelector('.custom-file-label').textContent = name
}

// ปุ่มกลับไปหน้าแรก
function goback(){
  location.href = "https://thavorn-jewelry.com/stock-jewelry/stock/"
}

// สร้างบาร์โค้ดเป็นรูป
function get_barcode(barcode){
  window.open("https://thavorn-jewelry.com/stock-jewelry/stock/barcode.php?barcode="+barcode,'_blank')
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
function add_loose_amount(){
  document.querySelector('#add-loose-amount').addEventListener('keyup',()=>{
    const inputnum = document.querySelector('#add-loose-amount')
    const option = document.querySelector('#add-loose-item')
    let amount = option.options[option.selectedIndex].getAttribute('data-option-amount')
  
    if(parseInt(inputnum.value) > parseInt(amount)){
      inputnum.value = amount
    }
  })
}

// clear amount when change select
function add_loose_item(){
  document.querySelector('#add-loose-item').addEventListener('change',()=>{
    document.querySelector('#add-loose-amount').value = ""
  })
}

// add option loose import
function add_loose_modal(){
  let data = {
    "name" : document.querySelector('#modal_supplie').value,
    "amount" : document.querySelector('#modal_amount').value,
    "cost" : document.querySelector('#modal_cost').value,
    "weight" : document.querySelector('#modal_weight').value,
    "shape" : document.querySelector('#modal_shape').value
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

  // let total_cost = parseInt(data.amount)*parseFloat(data.cost)

  const table = document.querySelector('#table-loose tbody')
  let tem = `
            <tr data-loose-id="">
              <th class="name">${data.name}</th>
              <th class="shape">${data.shape}</th>
              <th class="weight">${data.weight}</th>
              <th class="amount">${data.amount}</th>
              <th class="cost">${data.cost}</th>
              <th><button class="btn btn-sm btn-danger" onclick="delete_item_table_loose(this)">ลบ</button></th>
            </tr>   
            `
  table.insertAdjacentHTML('beforeend',tem)
  
  document.querySelector('#modal_supplie').value = ""
  document.querySelector('#modal_amount').value = ""
  document.querySelector('#modal_cost').value = ""
  document.querySelector('#modal_weight').value = ""
  document.querySelector('#modal_shape').value = ""
  
  $('#modal-add-loose').modal('toggle');

  resume_cost()
}

// add option loose
function add_loose_modal_ori(){
  let opt = document.querySelector('#add-loose-item')
  let chk_sts = true;

  let data = {
    "name" : opt.options[opt.selectedIndex].getAttribute('data-option-name'),
    "amount" : document.querySelector('#add-loose-amount').value,
    "cost" : opt.options[opt.selectedIndex].getAttribute('data-option-cost'),
    "weight" : opt.options[opt.selectedIndex].getAttribute('data-option-weight'),
    "weight_use" : document.querySelector('#add-loose-weight').value,
    "shape" : opt.options[opt.selectedIndex].getAttribute('data-option-diamond_shape'),
    "id" : opt.options[opt.selectedIndex].value
  }

  if(data.amount == "" || data.amount == 0){
    chk_sts = false
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน',
      text: 'ท่านไม่ได้ใส่จำนวน',
    }).then(()=>{
      $('#modal-add-loose').modal('toggle');
    })
  }
  if(data.weight_use == "" || data.weight_use == 0){
    chk_sts = false
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน',
      text: 'ท่านไม่ได้ใส่น้ำหนัก',
    }).then(()=>{
      $('#modal-add-loose').modal('toggle');
    })
  }

  if(chk_sts){
    const table = document.querySelector('#table-loose tbody')
    let tem = `
              <tr data-loose-id="${data.id}">
                <th>${data.name}</th>
                <th>${data.shape}</th>
                <th>${data.weight}</th>
                <th class="weight">${data.weight_use}</th>
                <th class="amount">${data.amount}</th>
                <th class="cost">${data.cost}</th>
                <th><button class="btn btn-sm btn-danger" onclick="delete_item_table_loose(this)">ลบ</button></th>
              </tr>   
              `
    table.insertAdjacentHTML('beforeend',tem)
    
    document.querySelector('#add-loose-amount').value = ""
    
    $('#modal-add-loose').modal('toggle');
  
    resume_cost()
  }
  
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

function select_body(){
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
}

//////////////////////////////////////////////////////////////////////////////////////////

// open textarea reuseProduct
document.querySelector("#reuse_product").addEventListener('change',(e)=>{
  if(e.target.value != 0){
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

function add_import(){
  let data = new FormData()
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

  // prepair data loose diamond
  let loose_arr = []
  let loose_diamond = document.querySelectorAll('#table-loose tbody tr')
  loose_diamond.forEach(data => {
    let ex_arr = {
      "supplier"  : data.querySelector('.name').textContent,
      "shape"  : data.querySelector('.shape').textContent,
      "weight"  : data.querySelector('.weight').textContent,
      "amount"    : data.querySelector('.amount').textContent ,
      "cost"  : data.querySelector('.cost').textContent
    }
    loose_arr.push(ex_arr)
  });
  data.append('loose_diamond',JSON.stringify(loose_arr))

  // prepair data body
  let body_diamond = document.querySelector('#body_supplier').value
  let body_cost = document.querySelector('#body_cost').value
  let body_weight = document.querySelector('#body_weight').value
  let body_color = document.querySelector('#color').value
  let body_percentage = document.querySelector('#body_percent').value
  let body_type = document.querySelector('#type_product').value

  data.append('body_diamond',body_diamond)
  data.append('body_cost',body_cost)
  data.append('body_weight',body_weight)
  data.append('body_color',body_color)
  data.append('body_percentage',body_percentage)
  data.append('body_type',body_type)

  $.ajax({
    method: "POST",
    url: "functions/add-item-import.php",
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
          location.href = "https://thavorn-jewelry.com/stock-jewelry/stock"
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

function save_history(){
  let data = new FormData()
  data.append('product_id',document.querySelector('#item_id').value,)
  data.append('old_weight',document.querySelector('#old_weight').value,)
  data.append('weight',document.querySelector('#weight').value,)
  data.append('admin_id',document.querySelector('#admin_id').value,)

  $.ajax({
    method: "POST",
    url: "functions/save-history.php",
    data : data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){ 
      console.log(result)
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
    }
  })
}