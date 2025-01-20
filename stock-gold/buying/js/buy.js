function view(id){
  location.href = "https://thavorn-jewelry.com/stock-gold/buying/get-sale.php?id="+id
}

function add(){
  location.href = "https://thavorn-jewelry.com/stock-gold/buying/add.php"
}

function add_user(){
  window.open("https://thavorn-jewelry.com/member/membership/",'_blank');
}

function goback(){
  location.href = "https://thavorn-jewelry.com/stock-gold/buying/"
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
        console.log(result)
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

function get_gold_price(){
  $.ajax({
    method: "GET",
    url: "https://thai-gold-api.herokuapp.com/latest",
    dataType: 'json',
    success:function(result){
      document.querySelector('#price_buy').value = result.response.price.gold_bar.buy
      document.querySelector('#price_sell').value = result.response.price.gold_bar.sell
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

// เช็คราคาขายต้องไม่น้อยกว่าราคาตลาด
if(document.querySelector('#gold_price')){
  document.querySelector('#gold_price').addEventListener('change',()=>{
    let price = document.querySelector('#gold_price')
    let market_price = document.querySelector('#market_price')
  
    if(price.value < market_price.value){
      Swal.fire({
        icon: 'warning',
        title: 'แจ้งเตือน!',
        text: 'คุณกรอกราคาต่ำกว่าราคาตลาด กรุณากรอกใหม่',
      })
      price.value = market_price.value
      return false
    }
  })
}

function search_sale_his(){
  let data = {
    "date" : document.querySelector('#range_date').value.replace(/\s/g,''),
    "name" : document.querySelector('#search_name').value
  }
  let chk_null = true

  for(const val of Object.keys(data)){
    if(data[val] == ""){
      chk_null = false
    }
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
              <td>${data.date}</td>
              <td>${data.fullname}</td>
              <td>${data.po_no}</td>
              <td>${data.type_name}</td>
              <td>${data.price_buy_num}</td>
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

function print_invoice(){
  let data = {
    "cus_id_invoice" : document.querySelector('#cus_id_invoice'),
    "cus_name_invoice" : document.querySelector('#cus_name_invoice'),
    "cus_idcard_invoice" : document.querySelector('#cus_idcard_invoice'),
    "address_invoice" : document.querySelector('#address_invoice'),
    "date_invoice" : document.querySelector('#date_invoice'),
    "gold_price_invoice" : document.querySelector('#gold_price_invoice'),
    "item_name_invoice" : document.querySelector('#item_name_invoice'),
    "item_weight_invoice" : document.querySelector('#item_weight_invoice'),
    "net_vat_invoice" : document.querySelector('#net_vat_invoice'),
    "resale_invoice" : document.querySelector('#resale_invoice'),
    "diff_invoice" : document.querySelector('#diff_invoice'),
    "vat_base_invoice" : document.querySelector('#vat_base_invoice'),
    "vat_invoice" : document.querySelector('#vat_invoice'),
    "vat_exclude_invoice" : document.querySelector('#vat_exclude_invoice'),
  }

  // Date current
  let today = new Date();
  let dd = String(today.getDate()).padStart(2, '0');
  let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  let yyyy = today.getFullYear();
  let hour = today.getHours()
  let minute = today.getMinutes()

  today = dd + '/' + mm + '/' + yyyy + " " + hour + ":" + minute;

  // item name
  let item_name_raw = document.querySelector('#type_product').value
  let item_name_cate = document.querySelector('#cate_product').value
  let item_name = item_name_raw+" "+item_name_cate

  data.cus_id_invoice.value = document.querySelector('#customer_id').innerHTML
  data.cus_name_invoice.value = document.querySelector('#cus_name').value
  data.cus_idcard_invoice.value = document.querySelector('#id_no').value
  data.address_invoice.value = document.querySelector('#address').value
  data.date_invoice.value = today
  data.gold_price_invoice.value = document.querySelector('#gold_price').value
  data.item_name_invoice.value = item_name
  data.item_weight_invoice.value = document.querySelector('#weight').value
  data.net_vat_invoice.value = document.querySelector('#net_vat').value
  data.resale_invoice.value = document.querySelector('#resale_price').value
  data.diff_invoice.value = document.querySelector('#diff').value
  data.vat_base_invoice.value = document.querySelector('#vat_base').value
  data.vat_invoice.value = document.querySelector('#vat').value
  data.vat_exclude_invoice.value = document.querySelector('#price_exclude').value

  document.getElementById('invoice-form').submit();

  // window.open("https://thavorn-jewelry.com/stock-gold/barcode/invoice.php",'_blank');
}

function get_type(){
  $.ajax({
    method: "POST",
    url: "functions/get-type.php",
    dataType: 'json',
    success:function(result){
      const select_type = document.querySelector('#type_product')

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

function buying(){
  let data = new FormData()
  data.append('datetime',document.querySelector('#datetime').value)
  data.append('type_product',document.querySelector('#type_product').value)
  data.append('amount',document.querySelector('#amount ').value)
  data.append('weight',document.querySelector('#weight').value)
  data.append('detail',document.querySelector('#detail').value)
  data.append('price_buy',document.querySelector('#price_buy').value)
  data.append('price_sell',document.querySelector('#price_sell').value)
  data.append('price_buy_num',document.querySelector('#price_buy_num').value)
  data.append('price_buy_txt',document.querySelector('#price_buy_txt').value)
  data.append('customFile',document.querySelector('#customFile').files[0])
  data.append('cus_id',document.querySelector('#cus_sale_id').value)
  data.append('po_no',document.querySelector('#po_no').value)
  let chk_null = true
  for(const val of Object.keys(data)){
    if(data[val] == ""){
      chk_null = false
    }
  }

  if(chk_null){
    $.ajax({
      method: "POST",
      url: "functions/buying.php",
      data:data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(result){
        console.log(result)
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จแล้ว',
        }).then(()=>{
          location.href = "https://thavorn-jewelry.com/stock-gold/buying"
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

function print_PO(){
  let data = {
    "po_no" : document.querySelector('#po_no_form'),
    "datetime" : document.querySelector('#datetime_form'),
    "cus_name" : document.querySelector('#cus_name_form'),
    "id_no" : document.querySelector('#id_no_form'),
    "address" : document.querySelector('#address_form'),
    "phone" : document.querySelector('#phone_form'),
    "detail" : document.querySelector('#detail_form'),
    "price_buy" : document.querySelector('#price_buy_form'),
    "price_sell" : document.querySelector('#price_sell_form'),
    "price_buy_num" : document.querySelector('#price_buy_num_form'),
    "price_buy_txt" : document.querySelector('#price_buy_txt_form'),
    // "picture" : document.querySelector('#picture_form')
  }

  data.po_no.value = document.querySelector('#po_no').value
  data.datetime.value = document.querySelector('#datetime').value
  data.cus_name.value = document.querySelector('#cus_name').value
  data.id_no.value = document.querySelector('#id_no').value
  data.address.value = document.querySelector('#address').value
  data.phone.value = document.querySelector('#phone').value
  data.detail.value = document.querySelector('#detail').value
  data.price_buy.value = document.querySelector('#price_buy').value
  data.price_sell.value = document.querySelector('#price_sell').value
  data.price_buy_num.value = document.querySelector('#price_buy_num').value
  data.price_buy_txt.value = document.querySelector('#price_buy_txt').value
  // data.picture.value = document.querySelector('.thumbnail img').src

  document.getElementById('po-form').submit();
}

// เปลี่ยนรูปอัพโหลด
function change_pic(event){
  let data = new FormData()
  data.append('img',document.querySelector('#customFile').files[0])
  $.ajax({
    method: "POST",
    url: "functions/upload-file.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){
      // console.log(result)
      document.querySelector('#picture_form').value = `https://thavorn-jewelry.com/uploads/pre-upload/${result}`
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })

  document.querySelector('.thumbnail img').src = URL.createObjectURL(event.target.files[0])
  document.querySelector('.thumbnail img').onload = function() {
    URL.revokeObjectURL(document.querySelector('.thumbnail img').src) // free memory
  }
  document.querySelector('.custom-file label').innerHTML = event.target.files[0].name
}