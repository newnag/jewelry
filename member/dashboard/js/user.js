function get(){
  $.ajax({
    method: "POST",
    url: "functions/get-user.php",
    dataType: 'json',
    success:function(result){
      // console.log(result)
      const table = document.querySelector('#table-user tbody')

      for(i=0;i<result.length;i++){
        let tem = `
        <tr>
          <td class="no">${result[i].id_customer}</td>
          <td class="name">${result[i].fullname}</td>
          <td class="total">${result[i].phone}</td>
          <td class="total">${result[i].id_no}</td>
          <td class="max">${result[i].line_id}</td>
          <td>
            <div class="col-12">
              <div class="row">
                <div class="col-xl-6 col-md-12"><button type="button" class="btn-pri btn btn-block bg-gradient-warning btn-cus-w" onclick="edit(${result[i].id})">ดู/แก้ไข</button></div>
                <div class="col-xl-6 col-md-12"><button type="button" class="btn btn-block bg-gradient-danger btn-cus-w" onclick="item_delete(${result[i].id})">ลบ</button></div>
              </div>
            </div>
          </td>
        </tr>
        `
        table.insertAdjacentHTML('beforeend',tem)
        let content_height = document.querySelector('.content-wrapper .content').offsetHeight
        console.log(content_height)
        document.querySelector('.main-sidebar').style.height = content_height+"px"
      }
      
    },
    error:function(textStatus){
      const table = document.querySelector('#table-user tbody')
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

function add(){
  let data = new FormData()
  data.append('fullname',document.querySelector('#fullname').value)
  data.append('sex',document.querySelector('#sex').value)
  data.append('dob',document.querySelector('#dob').value)
  data.append('phone',document.querySelector('#phone').value)
  data.append('address',document.querySelector('#address').value)
  data.append('id_no',document.querySelector('#id_no').value)
  data.append('line_id',document.querySelector('#line_id').value)
  data.append('id_file',document.querySelector('#id_file').files[0])
  data.append('bookbank',document.querySelector('#bookbank').files[0])
  
  $.ajax({
    method: "POST",
    url: "functions/add-user.php",
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
          location.reload()
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

function edit(id){
  location.href = `https://thavorn-jewelry.com/member/edit/?id=${id}`
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
        url: "functions/delete-user.php",
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
          else{
            console.error(result)
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: 'ไม่สามารถลบข้อมูลได้',
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
  get()
}