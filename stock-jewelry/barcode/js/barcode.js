function view(id){
  window.open("https://thavorn-jewelry.com/stock-jewelry/barcode/get-sale.php?id="+id,"_blank")
}

function goback(){
  location.href = "https://thavorn-jewelry.com/stock-jewelry/barcode/"
}

function search_barcode(){
  let barcode = document.querySelector('#search_product').value

  $.ajax({
    method: "POST",
    url: "functions/search-barcode.php",
    data:{barcode:barcode},
    dataType: 'json',
    success:function(result){
      let ele = {
        "product_no" : document.querySelector('#product_no'),
        "item_id" : document.querySelector('#item_id'),
        "product_name" : document.querySelector('#product_name'),
        "type_product" : document.querySelector('#type_product'),
        "cate_product" : document.querySelector('#cate_product'),
        "weight" : document.querySelector('#weight'),
        "size" : document.querySelector('#size'),
        "detail" : document.querySelector('#detail'),
        "cost_id" : document.querySelector('#cost_id'),
        "cost_price" : document.querySelector('#cost_price'),
        "pic" : document.querySelector('.thumbnail img')
      }

      ele.product_no.value = result['product_no']
      ele.item_id.value = result['id']
      ele.product_name.value = result['product_name']
      ele.type_product.value = result['type_name']
      ele.cate_product.value = result['cate_name']
      ele.weight.value = result['weight']
      ele.size.value = result['size']
      ele.detail.value = result['detail']
      ele.cost_id.value = result['cost_id']
      ele.cost_price.value = result['cost']
      ele.pic.src = "https://thavorn-jewelry.com/uploads/stock-jewelry/"+result['path_1']
    },
    error:function(textStatus){
      const table = document.querySelector('#table-report tbody')
      let tem = `
        <tr>
          <td>ไม่มีข้อมูลสแดงผล</td>
        </tr>
        `
      table.insertAdjacentHTML('beforeend',tem)
      console.log(textStatus.responseText)
    }
  })
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
        let ele = {
          "cus_sale_id" : document.querySelector('#cus_sale_id'),
          "customer_id" : document.querySelector('#customer_id'),
          "cus_name" : document.querySelector('#cus_name'),
          "id_no" : document.querySelector('#id_no'),
          "phone" : document.querySelector('#phone'),
          "dob" : document.querySelector('#dob'),
          "sex" : document.querySelector('#sex'),
          "address" : document.querySelector('#address'),
          "point" : document.querySelector('#point')
        }

        ele.cus_sale_id.value = result.id
        ele.customer_id.innerHTML = result.id_customer
        ele.cus_name.value = result.fullname
        ele.id_no.value = result.id_no
        ele.phone.value = result.phone
        ele.dob.value = result.DOB
        ele.sex.value = result.sex
        ele.address.value = result.address
        ele.point.value = result.point
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

function sale(){
  let chk_data = {
    "cus_id" : document.querySelector('#cus_sale_id').value,
    "item_id" : document.querySelector('#item_id').value,
    "sale_date" : document.querySelector('#date_sale').value,
    "price" : Number(document.querySelector('#sale_price').value.replace(/[^0-9.-]+/g,"")),
  }
  let data = {
    "cus_id" : document.querySelector('#cus_sale_id').value,
    "item_id" : document.querySelector('#item_id').value,
    "sale_date" : document.querySelector('#date_sale').value,
    "price" : Number(document.querySelector('#sale_price').value.replace(/[^0-9.-]+/g,"")),
    "sell_price" : Number(document.querySelector('#sell_price').value.replace(/[^0-9.-]+/g,""))
  }
  let chk_null = true

  for(const val of Object.keys(chk_data)){
    if(chk_data[val] == ""){
      chk_null = false
    }
  }

  if(chk_null){
    $.ajax({
      method: "POST",
      url: "functions/add-sale.php",
      data:data,
      success:function(result){
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จแล้ว',
        }).then(()=>{
          location.href = "https://thavorn-jewelry.com/stock-jewelry/barcode/"
        })
      },
      error:function(textStatus){
        console.log(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถเพิ่มข้อมูลได้ โปรดตรวจสอบข้อมูล',
        })
      }
    })
  }
  else{
    Swal.fire({
      icon: 'error',
      title: 'เกิดข้อผิดพลาด!',
      text: 'คุณกรอกข้อมูลไม่ครบถ้วน',
    })
    return false
  }
}

function search_sale_his(){
  let data = {
    "date" : document.querySelector('#range_date').value.replace(/\s/g,''),
    "name" : document.querySelector('#search_name').value
  }
  let chk_null = true

  if(data['date'] == ""){
    chk_null = false
  }
  if(chk_null){
    $.ajax({
      method: "POST",
      url: "functions/search-history.php",
      data:data,
      dataType: 'json',
      success:function(result){
        const table = document.querySelector('#table-report tbody')
        $('#table-report tbody').empty()

        result.forEach(data => {
          let col = `
            <tr>
              <td>${data.create_date}</td>
              <td>${data.fullname}</td>
              <td>${data.product_name}</td>
              <td>${data.type_name}</td>
              <td>${data.sale_price}</td>
              <td><button class="btn btn-gold" onclick="view(${data.id})">ดู/แก้ไข</button></td>
            </tr>
          `
          table.insertAdjacentHTML('afterbegin',col)
        });
      },
      error:function(textStatus){
        Swal.fire({
          icon: 'error',
          title: 'ไม่พบข้อมูล!',
          text: 'ไม่พบข้อมูลที่ท่านค้นหา',
        })
        console.log(textStatus.responseText)
      }
    })
  }
  else{
    Swal.fire({
      icon: 'error',
      title: 'เกิดข้อผิดพลาด!',
      text: 'คุณกรอกข้อมูลไม่ครบถ้วน',
    })
    return false
  }
}

// ยกเลิกการขาย
function disable_sale(id,item_id){
  Swal.fire({
    title: 'คุณต้องการยกเลิกการขายใช่หรือไม่?',
    showDenyButton: true,
    confirmButtonText: 'ใช่',
    denyButtonText: `ไม่ใช่`,
  }).then((result) =>{
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "functions/disable-sale.php",
        data: {
          id:id,
          item_id:item_id
        },
        success:function(result){
          if(result == "success"){
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: 'ยกเลิกการขายสำเร็จ',
            }).then(()=>{
              location.href = "https://thavorn-jewelry.com/stock-jewelry/barcode/";
            })
          }
        },
        error:function(textStatus){
          console.log(textStatus.responseText)
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถยกเลิกการขายได้',
          })
        }
      })
    } 
    else if (result.isDenied) {
      return false
    }
  })
}