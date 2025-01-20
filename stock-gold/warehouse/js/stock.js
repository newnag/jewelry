function add(){
    let data = new FormData()
    data.append('supplier_type',document.querySelector('#supplier_type').value)
    data.append('product_no',document.querySelector('#product_no').value)
    data.append('product_cate',document.querySelector('#product_cate').value)
    data.append('weight',document.querySelector('#weight').value)
    data.append('detail',document.querySelector('#detail').value)
    data.append('import_date',document.querySelector('#import_date').value)
    data.append('size',document.querySelector('#size').value)
    data.append('cost_id',document.querySelector('#cost_id').value)
    data.append('cost',document.querySelector('#cost').value)
    data.append('cost_price',document.querySelector('#cost_price').value)
    data.append('wage',document.querySelector('#wage').value)
    data.append('cost_wage_id',document.querySelector('#cost_wage_id').value)
    data.append('cost_wage',document.querySelector('#cost_wage').value)
    data.append('status',document.querySelector('#status').value)
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
            location.href = "https://thavorn-jewelry.com/stock-gold/warehouse"
        })
      },
      error:function(textStatus){
        console.error(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
        })
        $('#modal-add').modal('hide')
      }
    })
}

function get(){
    $.ajax({
      method: "POST",
      url: "functions/get-item.php",
      dataType: 'json',
      success:function(result){
        const table = document.querySelector('#table-gold tbody')
  
        for(i=0;i<result.length;i++){
            let tem = `
            <tr>
              <td class="no">${result[i].product_no}</td>
              <td class="type_product">${result[i].type_name}</td>
              <td class="import_date">${result[i].import_date}</td>
              <td class="type_supplier">${result[i].type_supplier}</td>
              <td class="weight">${result[i].weight} กรัม</td>
              <td class="thumbnail"><img src="https://thavorn-jewelry.com/uploads/stock-gold/${result[i].pic_path}"></td>
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
  data.append('size',document.querySelector('#size').value)
  data.append('cost_id',document.querySelector('#cost_id').value)
  data.append('cost',document.querySelector('#cost').value)
  data.append('cost_price',document.querySelector('#cost_price').value)
  data.append('wage',document.querySelector('#wage').value)
  data.append('cost_wage_id',document.querySelector('#cost_wage_id').value)
  data.append('cost_wage',document.querySelector('#cost_wage').value)
  data.append('status',document.querySelector('#status').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  data.append('file_2',document.querySelector('#file_2').files[0])  
  data.append('file_3',document.querySelector('#file_3').files[0])  
  data.append('item_id',document.querySelector('#item_id').value)

  if(document.querySelector('#status').value == 2){
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน!',
      text: 'มีการย้ายสถานะเข้าสู่สต็อก กรุณาตรวจเช็คข้อมูลที่สต็อก',
    }).then(()=>{
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
              location.href = "https://thavorn-jewelry.com/stock-gold/warehouse"
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
    })
  }
  else{
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
            location.href = "https://thavorn-jewelry.com/stock-gold/warehouse"
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
              location.href = "https://thavorn-jewelry.com/stock-gold/warehouse"
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

window.onload = ()=>{
    get_type()
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
  location.href = "https://thavorn-jewelry.com/stock-gold/warehouse/"
}

// สร้างบาร์โค้ดเป็นรูป
function get_barcode(barcode){
  window.open("https://thavorn-jewelry.com/stock-gold/stock/barcode.php?barcode="+barcode,'_blank')
}

// search
function search(){
  let search_txt = document.querySelector('#search_name').value
  let search_type = document.querySelector('#search_type').value
  let search_cate = document.querySelector('#search_cate').value

  $.ajax({
    method: "POST",
    url: "functions/search.php",
    data: {
      txt : search_txt,
      type: search_type,
      cate: search_cate
    },
    dataType: 'json',
    success:function(result){
      console.log(result)
      let tabledata = $('#table-gold').DataTable()
      tabledata.destroy()

      $('#table-gold tbody').empty()

      const table = document.querySelector('#table-gold tbody')
      for(i=0;i<result.length;i++){
        let tem = `
        <tr>
          <td class="">${result[i].product_no}</td>
          <td class="">${result[i].type_name}</td>
          <td class="">${result[i].cate_name}</td>
          <td class="">${result[i].weight}</td>
          <td class="cost-id">${result[i].cost_id}</td>
          <td class="">${result[i].wage}</td>
          <td class="thumbnail"><img src="https://thavorn-jewelry.com/uploads/stock-gold/${result[i].pic_path}"></td>
          <td>
            <button type="button" class="btn btn-block btn-cus-w btn-action" onclick="edit(${result[i].id})">ดู/แก้ไข</button>
          </td>
        </tr>
        `
        table.insertAdjacentHTML('beforeend',tem)
      }

      $('#table-gold').DataTable({
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "searching":false,
        "autoWidth": false,
        "responsive": true,
      });
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

function barcode_page(){
  window.open("https://thavorn-jewelry.com/stock-gold/warehouse/get-barcode.php",'_blank')
}

function search_item_barcode(){
  $('#select_form').empty()

  let data = {
    // "txt" : document.querySelector('#product_no').value,
    "type" : document.querySelector('#type_product').value
  }

  $.ajax({
    method: "POST",
    url: "functions/get-barcode.php",
    data: data,
    dataType: 'json',
    success:function(result){
      console.log(result)
      const select_form = document.querySelector('#select_form')
      for (i=0;i<result.length;i++){
        template = `
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="product_no" id="chk${i}" value="${result[i].product_no}" data-type="${result[i].type_name}" data-weight="${result[i].cate_name}" data-size="${result[i].size}" data-wage="${result[i].wage}">
            <label class="form-check-label" for="chk${i}">${result[i].product_no}</label>
          </div>
        `
        select_form.insertAdjacentHTML('afterbegin',template)
      }
      
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'ไม่พบข้อมูล!',
        text: 'ไม่พบข้อมูลในการค้นหา',
      })
      return false;
    }
  })
}

function print_warehouse(){
  let checkboxes = document.getElementsByName('product_no')
  const form_data = document.querySelector('#barcode-form')
  let arr = []

  for(i=0;i<checkboxes.length;i++){
    if(checkboxes[i].checked){
      arr_ob = {
        product_no : checkboxes[i].value,
        type: checkboxes[i].dataset.type,
        weight: checkboxes[i].dataset.weight,
        size: checkboxes[i].dataset.size, 
        wage: checkboxes[i].dataset.wage
      }
      arr.push(arr_ob)
    }
  }
  
  let f_data = JSON.stringify(arr)

  template = `
    <input type="hidden" name="data[]" id="data_form" value='${f_data}'>
  `
  form_data.insertAdjacentHTML('afterbegin',template)

  // console.log(f_data)
  // console.log(document.querySelector('#data_form').value)

  document.querySelector('#barcode-form').submit()

}