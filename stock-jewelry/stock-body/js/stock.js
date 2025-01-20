function add(){
  let data = new FormData()
  data.append('supplier',document.querySelector('#supplier').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('price',document.querySelector('#price').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('amount',document.querySelector('#amount').value)
  data.append('type',document.querySelector('#product_type').value)
  data.append('color',document.querySelector('#color').value)
  data.append('si',document.querySelector('#si').value)
  data.append('weight_total',document.querySelector('#weight_total').value)
  data.append('note',document.querySelector('#note').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  if(document.querySelector('#percent_gold').value == "other"){
    data.append('percent_gold',document.querySelector('#percent_gold_other').value)
  }
  else{
    data.append('percent_gold',document.querySelector('#percent_gold').value)
  }
  
  if(data.get('supplier') != "" || data.get('stock_date') != "" || data.get('price') != 0 || data.get('weight') != 0 || data.get('amount') != 0 || data.get('weight_total') != 0 || data.get('color') != ""){
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
            location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-body"
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
  else{
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน!',
      text: 'คุณใส่ข้อมูลไม่ครบถ้วน',
    })
    return false
  }
}

function update(){
  let data = new FormData()
  data.append('supplier',document.querySelector('#supplier').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('price',document.querySelector('#price').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('amount',document.querySelector('#amount').value)
  data.append('type',document.querySelector('#product_type').value)
  data.append('color',document.querySelector('#color').value)
  data.append('si',document.querySelector('#si').value)
  data.append('weight_total',document.querySelector('#weight_total').value)
  data.append('note',document.querySelector('#note').value)
  if(document.querySelector('#percent_gold').value == "other"){
    data.append('percent_gold',document.querySelector('#percent_gold_other').value)
  }
  else{
    data.append('percent_gold',document.querySelector('#percent_gold').value)
  }
  data.append('id',document.querySelector('#item_id').value)

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
          text: 'แก้ไขข้อมูลสำเร็จ',
      }).then(()=>{
          location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-body"
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถแก้ไขข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
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

// ปุ่มกลับไปหน้าแรก
function goback(){
  location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-body/"
}

// ดึงประเภท
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

// เมื่อเลือกเปอร์เซ็นทอง
document.querySelector('#percent_gold').addEventListener('change',(e)=>{
  if(e.target.value == "other"){
    document.querySelector('#percent_gold_other').disabled = false
  }
  else{
    document.querySelector('#percent_gold_other').disabled = true
  }
})

//////////////////////////////////////////////////////////////////////////
// คำนวนซิ
document.querySelector('#weight').addEventListener('keyup',(e)=>{
  calpercentSi()
})
document.querySelector('#si').addEventListener('keyup',(e)=>{
  calpercentSi()
})

function calpercentSi(){
  const si = document.querySelector('#si').value
  const weight = document.querySelector('#weight').value
  total = document.querySelector('#weight_total')

  let percent = (parseFloat(si) * parseFloat(weight)) / 100
  total.value = Number(parseFloat(weight)+percent).toFixed(2)
}
//////////////////////////////////////////////////////////////////////////
