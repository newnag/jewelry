function search(){
  let data = {
    "date" : document.querySelector('#reservation').value.replace(/\s/g,'')
  }
  
  $.ajax({
    method: "POST",
    url: "functions/report.php",
    data: data,
    dataType: 'json',
    success:function(result){ 
      console.log(result)
      $('#table-report').empty()

      const table = document.querySelector('#table-report')

      // let currency = Intl.NumberFormat('en-US')

      ///////////////////////////////////////////////////

      tem_table = `
        <thead class="head-table">
          <tr>
            <th>รหัส</th>
            <th>รูป</th>
            <th>ชื่อสินค้า</th>
            <th>ชื่อผู้ซื้อ</th>
            <th>ราคาขาย</th>
            <th>วันที่ซื้อขาย</th>
            <th>สถานะ</th>
          </tr>
        </thead>

        <tbody>
      `
      for(i=0;i<result.length;i++){
        let status_txt
        if(result[i].status == 1){
          status_txt = "เรียบร้อย"
        }
        else if(result[i].status == 2){
          status_txt = "ยกเลิก"
        }

        tem_table += `
          <tr>
            <td>${result[i].product_no}</td>
            <td><img style="width:200px;height:200px" src="https://thavorn-jewelry.com/uploads/stock-jewelry/${result[i].path_1}"></td>
            <td>${result[i].product_name}</td>
            <td>${result[i].fullname}</td>
            <td>${result[i].sale_price}</td>
            <td>${result[i].create_date}</td>
            <td>${status_txt}</td>
          </tr>         
        `
      }

      tem_table += `</tbody>`
      
      table.insertAdjacentHTML('afterbegin',tem_table)
      

      $("#table-report").DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "searching": true,
        "lengthChange": false,
        "bDestroy": true
      });
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