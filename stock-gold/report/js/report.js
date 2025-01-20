function search(){
  let data = {
    "date" : document.querySelector('#reservation').value.replace(/\s/g,''),
    "type_report" : document.querySelector('#type_report').value
  }
  $.ajax({
    method: "POST",
    url: "functions/report.php",
    data: data,
    dataType: 'json',
    success:function(result){ 
      $('#card').empty()
      $('#table-report').empty()

      const card_ele = document.querySelector('#card')
      const table = document.querySelector('#table-report')

      let currency = Intl.NumberFormat('en-US')

      if(data.type_report == 1){
        let tem_card = `
          <div class="col-xl-3 col-lg-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>${result.sum.total_list}</h3>
  
                <p>รายการขาย</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
  
          <div class="col-xl-3 col-lg-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>${currency.format(result.price.total_sale)}</h3>
  
                <p>ยอดขายทั้งหมด</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
            </div>
          </div>
        `
  
        card_ele.insertAdjacentHTML('afterbegin',tem_card)
        ///////////////////////////////////////////////////
  
        tem_table = `
          <thead>
            <tr>
              <th>รหัสสินค้า</th>
              <th>น้ำหนัก</th>
              <th>วันที่ขาย</th>
              <th>ราคาขาย</th>
              <th>ลูกค้า</th>
              <th width="100"></th>
            </tr>
          </thead>
  
          <tbody>
        `
        for(i=0;i<result.item.length;i++){
          tem_table += `
            <tr>
              <td>${result.item[i].product_no}</td>
              <td>${result.item[i].weight} กรัม</td>
              <td>${result.item[i].sale_date}</td>
              <td>${result.item[i].sum_price}</td>
              <td>${result.item[i].fullname}</td>
              <td class="bgetsale" data-item-id="${result.item[i].id}"><a href="https://thavorn-jewelry.com/stock-gold/barcode/get-sale.php?id=${result.item[i].id}" target="_blank"><div class="col-auto"><button type="button" class="btn btn-sm btn-block bg-gradient-warning btn-cus-w" >ดูข้อมูล</button></div></a></td>
            </tr>         
          `
        }
  
        tem_table += `</tbody>`
        
        table.insertAdjacentHTML('afterbegin',tem_table)

        $("#table-report").DataTable({
          "responsive": true,
          "autoWidth": false,
          "paging": true,
          "pageLength": 10,
          "searching": true,
          "ordering":  false,
          "lengthChange": false,
          "bDestroy": true
        });

      }
      else if(data.type_report == 2){
        let type_id = 0
        const table = document.querySelector('#table-report')

        tem_table = `
          <thead>
            <tr>
              <th>ประเภท</th>
              <th>หมวดหมู่</th>
              <th>คงเหลือ</th>
            </tr>
          </thead>
  
          <tbody>
        `

        for(i=0;i<result.item.length;i++){
          if(type_id == result.item[i].type_id){
            tem_table += `
              <tr>
                <td></td>
                <td>${result.item[i].cate_name}</td>
                <td>${result.item[i].amount}</td>
              </tr>         
            `
          }
          else{
            type_id = result.item[i].type_id
            tem_table += `
              <tr class="highlight-table">
                <td></td>
                <td></td>
                <td></td>
              </tr>         
            `
            tem_table += `
              <tr>
                <td>${result.item[i].type_name}</td>
                <td>${result.item[i].cate_name}</td>
                <td>${result.item[i].amount}</td>
              </tr>         
            `
          }
        }

        tem_table += `</tbody>`

        table.insertAdjacentHTML('beforeend',tem_table)

        $("#table-report").DataTable({
          "responsive": true,
          "autoWidth": false,
          "paging": true,
          "pageLength": 50,
          "searching": false,
          "ordering":  false,
          "lengthChange": false,
          "bDestroy": true
        });
      }
      else if(data.type_report == 3){
        let type_id = 0
        const table = document.querySelector('#table-report')

        tem_table = `
          <thead>
            <tr>
              <th>ประเภท</th>
              <th>หมวดหมู่</th>
              <th>คงเหลือ</th>
            </tr>
          </thead>
  
          <tbody>
        `

        for(i=0;i<result.item.length;i++){
          if(type_id == result.item[i].type_id){
            tem_table += `
              <tr>
                <td></td>
                <td>${result.item[i].cate_name}</td>
                <td>${result.item[i].amount}</td>
              </tr>         
            `
          }
          else{
            type_id = result.item[i].type_id
            tem_table += `
              <tr class="highlight-table">
                <td></td>
                <td></td>
                <td></td>
              </tr>         
            `
            tem_table += `
              <tr>
                <td>${result.item[i].type_name}</td>
                <td>${result.item[i].cate_name}</td>
                <td>${result.item[i].amount}</td>
              </tr>         
            `
          }
        }

        tem_table += `</tbody>`

        table.insertAdjacentHTML('beforeend',tem_table)

        $("#table-report").DataTable({
          "responsive": true,
          "autoWidth": false,
          "paging": true,
          "pageLength": 50,
          "searching": false,
          "ordering":  false,
          "lengthChange": false,
          "bDestroy": true
        });
      }
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่พบข้อมูล เลือกการค้นหาข้อมูลใหม่อีกครั้ง',
      })
    }
  })
}

document.querySelector('#type_report').addEventListener('change',()=>{
  const select = document.querySelector('#type_report')
  document.querySelector('#card').innerHTML = ""
  document.querySelector('#table-report').innerHTML = ""


  if(select.value == 2 || select.value == 3 || select.value == 4){
    document.querySelector('#block-date').style.display = "none"
    document.querySelector('#search_btn').style.display = "block"
    document.querySelector('#block-month').style.display = "none"
  }
  else{
    document.querySelector('#block-date').style.display = "block"
    document.querySelector('#search_btn').style.display = "block"
    document.querySelector('#block-month').style.display = "none"
  }

  if(select.value == 4){
    document.querySelector('#search_btn').style.display = "none"
    document.querySelector('#block-month').style.display = "block"
    const card_ele = document.querySelector('#card')

    ele_card = `
    <div class="row">
      <div class="col-2">
        <button button="" type="button" class="btn btn-block btn-primary" style="width:150px" onclick="print_sale_report()">พิมพ์รายงานประจำเดือน</button>
      </div>
    </div>
    `

    card_ele.insertAdjacentHTML('afterbegin',ele_card)
  }
  else if (select.value == 5){
    document.querySelector('#block-date').style.display = "block"
    document.querySelector('#search_btn').style.display = "none"
    const card_ele = document.querySelector('#card')

    ele_card = `
    <div class="row">
      <div class="col-6">
        <button button="" type="button" class="btn btn-block btn-primary" style="width:200px" onclick="print_buy_report()">พิมพ์รายงานภาษีซื้อ</button>
      </div>
    </div>
    `
    card_ele.insertAdjacentHTML('afterbegin',ele_card)
  }
})

function print_sale_report(){
  // let item = document.querySelectorAll('.bgetsale')
  // let item_arr = []
  // item.forEach(element => {
  //   item_arr.push(element.getAttribute('data-item-id'))
  // });
  // document.querySelector('#report_item_id').value = JSON.stringify(item_arr)

  // document.querySelector('#report-form').submit();

  let month = document.querySelector('#select_month').value

  window.open("https://thavorn-jewelry.com/stock-gold/report/report-sale.php?month="+month,"_blank")
}

function print_buy_report(){
  let data = {
    "date" : document.querySelector('#reservation').value.replace(/\s/g,''),
    "type_report" : document.querySelector('#type_report').value
  }
  $.ajax({
    method: "POST",
    url: "functions/report.php",
    data: data,
    dataType: 'json',
    success: function(result) {
      // window.open("http://127.0.0.1/gold/stock-gold/report/report-trans.php?result=" + encodeURIComponent(JSON.stringify(result)) + "&show_swal=true","_blank");
      window.open("https://thavorn-jewelry.com/stock-gold/report/report-trans.php?result=" + encodeURIComponent(JSON.stringify(result)) + "&show_swal=true","_blank");
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่พบข้อมูล เลือกการค้นหาข้อมูลใหม่อีกครั้ง',
      })
    }
  })
}
