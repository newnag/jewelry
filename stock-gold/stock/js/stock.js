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
            location.href = "https://thavorn-jewelry.com/stock-gold/stock"
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
        const table = document.querySelector('#table-gold tbody')
  
        for(i=0;i<result.length;i++){

            let tem = `
            <tr>
            <td class="no">${result[i].product_no}</td>
            <td class="type_product">${result[i].type_name}</td>
            <td class="import_date">${result[i].import_date}</td>
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
          location.href = "https://thavorn-jewelry.com/stock-gold/stock"
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
  location.href = "https://thavorn-jewelry.com/stock-gold/stock/"
}

// สร้างบาร์โค้ดเป็นรูป
function get_barcode(barcode){
  window.open("https://thavorn-jewelry.com/stock-gold/stock/barcode.php?barcode="+barcode,'_blank')
}