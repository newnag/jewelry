function add(){
  let data = new FormData()
  data.append('supplier',document.querySelector('#supplier').value)
  data.append('supplier_lot',document.querySelector('#supplier_lot').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('price',document.querySelector('#price').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('amount',document.querySelector('#amount').value)
  data.append('weight_total',document.querySelector('#weight_total').value)
  data.append('size',document.querySelector('#size').value)
  data.append('color',document.querySelector('#color').value)
  data.append('other',document.querySelector('#other').value)
  data.append('clarity',document.querySelector('#clarity').value)
  data.append('proportion_cut',document.querySelector('#proportion_cut').value)
  data.append('symmetry_cut',document.querySelector('#symmetry_cut').value)
  data.append('polish_cut',document.querySelector('#polish_cut').value)
  data.append('fluorescent',document.querySelector('#fluorescent').value)
  data.append('diamond_shape',document.querySelector('#diamond_shape').value)
  data.append('certificate',document.querySelector('#certificate').value)
  data.append('name_certificate',document.querySelector('#name_certificate').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  
  if(data.get('supplier') != "" || data.get('stock_date') != "" || data.get('price') != "" || data.get('weight') != "" || data.get('amount') != "" || data.get('size') != "" || data.get('color') != "" || data.get('clarity') != ""){
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
            location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-loose"
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
  data.append('supplier_lot',document.querySelector('#supplier_lot').value)
  data.append('stock_date',document.querySelector('#stock_date').value)
  data.append('price',document.querySelector('#price').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('amount',document.querySelector('#amount').value)
  data.append('weight_total',document.querySelector('#weight_total').value)
  data.append('size',document.querySelector('#size').value)
  data.append('color',document.querySelector('#color').value)
  data.append('other',document.querySelector('#other').value)
  data.append('clarity',document.querySelector('#clarity').value)
  data.append('proportion_cut',document.querySelector('#proportion_cut').value)
  data.append('symmetry_cut',document.querySelector('#symmetry_cut').value)
  data.append('polish_cut',document.querySelector('#polish_cut').value)
  data.append('fluorescent',document.querySelector('#fluorescent').value)
  data.append('diamond_shape',document.querySelector('#diamond_shape').value)
  data.append('certificate',document.querySelector('#certificate').value)
  data.append('name_certificate',document.querySelector('#name_certificate').value)
  data.append('id',document.querySelector('#item_id').value)
  data.append('file_1',document.querySelector('#file_1').files[0])

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
          location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-loose"
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

// เมื่อเลือกรูปภาพ
function change_name_pic(that){
  let name = that.files[0]['name']
  that.closest('.custom-file').querySelector('.custom-file-label').textContent = name
}

// ปุ่มกลับไปหน้าแรก
function goback(){
  location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-loose/"
}