function add(){
  let data = new FormData()
  data.append('cus_sale_id',document.querySelector('#cus_sale_id').value)
  data.append('product_name',document.querySelector('#product_name').value)
  data.append('price_rental',document.querySelector('#price_rental').value)
  data.append('interest',document.querySelector('#interest').value)
  data.append('value',document.querySelector('#value').value)
  data.append('detail',document.querySelector('#detail').value)
  data.append('file_1',document.querySelector('#file_1').files[0])
  
  if(data.get('cus_sale_id') != "" || data.get('price_rental') != "" || data.get('interest') != ""){
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
            location.href = "https://thavorn-jewelry.com/stock-gold-rental/pawn"
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
  data.append('item_id',document.querySelector('#item_id').value)
  data.append('product_name',document.querySelector('#product_name').value)
  data.append('price_rental',document.querySelector('#price_rental').value)
  data.append('interest',document.querySelector('#interest').value)
  data.append('value',document.querySelector('#value').value)
  data.append('detail',document.querySelector('#detail').value)

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
          location.href = "https://thavorn-jewelry.com/stock-gold-rental/pawn"
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
              location.href = "https://thavorn-jewelry.com/stock-gold-rental/pawn";
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
  location.href = "https://thavorn-jewelry.com/stock-gold-rental/pawn"
}

function search_customer_data(){
  let id = document.querySelector('#search_name').value

  if(id != ""){
    $.ajax({
      method: "POST",
      url: "functions/search-customer.php",
      data:{id:id},
      dataType: 'json',
      success:function(result){
        // console.log(result)
        let ele = {
          "cus_sale_id" : document.querySelector('#cus_sale_id'),
          "customer_id" : document.querySelector('#customer_id'),
          "cus_name" : document.querySelector('#cus_name'),
          "id_no" : document.querySelector('#id_no'),
          "phone" : document.querySelector('#phone'),
          "point" : document.querySelector('#point'),
          "dob" : document.querySelector('#dob'),
          "sex" : document.querySelector('#sex'),
          "address" : document.querySelector('#address'),
        }

        ele.cus_sale_id.value = result.id
        ele.customer_id.innerHTML = result.id_customer
        ele.cus_name.value = result.fullname
        ele.id_no.value = result.id_no
        ele.phone.value = result.phone
        ele.point.value = result.point
        ele.dob.value = result.DOB
        ele.address.value = result.address

        opt = document.createElement('option');
        opt.value = result.sex;
        opt.innerHTML = result.sex;
        ele.sex.appendChild(opt);
      },
      error:function(textStatus){ 
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่พบสมาชิก',
        })
        console.log(textStatus.responseText)
      }
    })
  }
  else{
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน!',
      text: 'คุณยังไม่ได้กรอกข้อมูลลูกค้า',
    })
    return false
  }

}

// เมื่อเลือกรูปภาพ
function change_name_pic(that){
  let name = that.files[0]['name']
  that.closest('.custom-file').querySelector('.custom-file-label').textContent = name
}