function view(id){
  location.href = "https://thavorn-jewelry.com/stock-gold/barcode/get-sale.php?id="+id
}

function add(){
  location.href = "https://thavorn-jewelry.com/stock-gold/barcode/add.php"
}

function add_user(){
  window.open("https://thavorn-jewelry.com/member/membership/",'_blank');
}

function goback(){
  location.href = "https://thavorn-jewelry.com/stock-gold/barcode/"
}

function search_barcode(){
  let barcode = document.querySelector('#search_product').value
  const ele = {
    "item_id" : document.querySelector('#item_id'),
    "product_no" : document.querySelector('#product_no'),
    "type_product" : document.querySelector('#type_product'),
    "cate_product" : document.querySelector('#cate_product'),
    "weight" : document.querySelector('#weight'),
    "size" : document.querySelector('#size'),
    "detail" : document.querySelector('#detail'),
    "cost_id" : document.querySelector('#cost_id'),
    "wage_id" : document.querySelector('#wage_id'),
    "wage" : document.querySelector('#wage'),
    "cost_price" : document.querySelector('#cost_price'),
    "pic" : document.querySelector('.thumbnail img')
  }

  $.ajax({
    method: "POST",
    url: "functions/search-barcode.php",
    data:{barcode:barcode},
    dataType: 'json',
    success:function(result){
      ele.item_id.value = result.id
      ele.product_no.value = result.product_no
      ele.type_product.value = result.type_name
      ele.cate_product.value = result.cate_name
      ele.weight.value = result.weight
      ele.size.value = result.size
      ele.detail.value = result.detail
      ele.cost_id.value = result.cost_id
      ele.wage_id.value = result.wage_id
      ele.wage.value = result.wage
      ele.cost_price.value = result.cost_price
      ele.pic.src = `https://thavorn-jewelry.com/uploads/stock-gold/${result.pic_path}`

      cal_vat_sale()

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

function cal_vat_sale(){
  ////////////////////////////////////////////////////////////////////////////////////////
  // ยอดขายรวม
  let sum_sale = document.querySelector('#sum_sale')
  sum_sale.value = (parseFloat(document.querySelector('#wage').value.replace(",",""))+parseFloat(document.querySelector('#gold_price').value.replace(/[^0-9.-]+/g,""))).toFixed(2)

  ////////////////////////////////////////////////////////////////////////////////////////
  // ราคาขายคืน
  let sell_per_gram = document.querySelector('#sell_per_gram')
  let resale_price = document.querySelector('#resale_price')
  let weight_gram = document.querySelector('#weight')
  resale_price.value = (parseFloat(sell_per_gram.value)*parseFloat(weight_gram.value)).toFixed(2)

  ////////////////////////////////////////////////////////////////////////////////////////
  // ส่วนต่าง
  let diff = document.querySelector('#diff')
  diff.value = (parseFloat(sum_sale.value)-parseFloat(resale_price.value)).toFixed(2)

  ////////////////////////////////////////////////////////////////////////////////////////
  // ภาษี
  let vat_base = document.querySelector('#vat_base')
  vat_base.value = ((parseFloat(diff.value)*100)/107).toFixed(2)
  let vat = document.querySelector('#vat')
  vat.value = (parseFloat(vat_base.value)*0.07).toFixed(2)

  ////////////////////////////////////////////////////////////////////////////////////////
  let price_exclude = document.querySelector('#price_exclude')
  price_exclude.value = (parseFloat(sum_sale.value)-parseFloat(vat.value)).toFixed(2)

  let net_vat = document.querySelector('#net_vat')
  net_vat.value = (parseFloat(sum_sale.value)+parseFloat(vat.value)).toFixed(2)

  ////////////////////////////////////////////////////////////////////////////////////////
  // point
  const wage_index = 50 // ค่ากำเหน็ด 50บาท ได้ 1คะแนน
  let recive_point = document.querySelector('#recive_point')
  let wage = document.querySelector('#wage').value.replace(",","")
  recive_point.value = parseInt(wage)/wage_index
}

function get_gold_price(){
  $.ajax({
    method: "GET",
    url: "https://thai-gold-api.herokuapp.com/latest",
    dataType: 'json',
    success:function(result){
      // console.log(result.response.price.gold_bar.buy)
      document.querySelector('#gold_price').value = result.response.price.gold_bar.buy
      document.querySelector('#market_price').value = result.response.price.gold_bar.buy
      document.querySelector('#gold_sale_price').value = result.response.price.gold_bar.sell
      document.querySelector('#gold_sale_price_racket').value = result.response.price.gold.buy

      let sell_per_gram = document.querySelector('#sell_per_gram')
      let market_price = document.querySelector('#market_price').value
      sell_per_gram.value = Math.floor(parseInt(market_price.replace(/[^0-9.-]+/g,""))/15.49)
    },
    error:function(textStatus){
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

function sale(){
  let data = {
    "cus_id" : document.querySelector('#cus_sale_id').value,
    "item_id" : document.querySelector('#item_id').value,
    "date_sale" : document.querySelector('#date_sale').value,
    "gold_price" : Number(document.querySelector('#gold_price').value.replace(/[^0-9.-]+/g,"")),
    "wage" : document.querySelector('#wage').value,
    "sum_sale" : document.querySelector('#sum_sale').value,
    "net_vat" : document.querySelector('#net_vat').value,
    "diff" : document.querySelector('#diff').value,
    "resale_price" : document.querySelector('#resale_price').value,
    "vat_base" : document.querySelector('#vat_base').value,
    "vat" : document.querySelector('#vat').value,
    "price_exclude" : document.querySelector('#price_exclude').value,
    "point" : document.querySelector('#recive_point').value,
    "resale_price" : document.querySelector('#resale_price').value
    // "price" : Number(document.querySelector('#price').value.replace(/[^0-9.-]+/g,""))
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
      url: "functions/add-sale.php",
      data:data,
      success:function(result){
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จแล้ว',
        }).then(()=>{
          location.href = "https://thavorn-jewelry.com/stock-gold/barcode"
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

if(document.querySelector('#wage')){
  document.querySelector('#wage').addEventListener('change',()=>{
    cal_vat_sale()
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
              <td>${data.create_date}</td>
              <td>${data.fullname}</td>
              <td></td>
              <td>${data.type_name}</td>
              <td>${data.sum_price}</td>
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
    "invoice_sell_per_gram" : document.querySelector('#invoice_sell_per_gram'),
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
  if(document.querySelector('#sell_per_gram')){
    data.invoice_sell_per_gram.value = document.querySelector('#sell_per_gram').value
  }

  document.getElementById('invoice-form').submit();

  // window.open("https://thavorn-jewelry.com/stock-gold/barcode/invoice.php",'_blank');
}