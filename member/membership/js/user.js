function get(){
  $.ajax({
    method: "POST",
    url: "functions/get-user.php",
    dataType: 'json',
    success:function(result){
      // console.log(result)
      const table = document.querySelector('#table-user tbody')
      let txt_loca = ""
      for(i=0;i<result.length;i++){
        if(result[i].location_regis == 1){
          txt_loca = "ร้านทอง"
        }
        else if(result[i].location_regis == 2){
          txt_loca = "ร้านเพชร"
        }
        let tem = `
        <tr>
          <td class="no">${result[i].id_customer}</td>
          <td class="name">${result[i].fullname}</td>
          <td class="total">${result[i].phone}</td>
          <td>
            <div class="col-12">
              <div class="row">
                <div class="col-auto"><button type="button" class="btn-pri btn btn-block btn-view-edit" onclick="edit(${result[i].id})">ดู/แก้ไข</button></div>
              </div>
            </div>
          </td>
        </tr>
        `
        table.insertAdjacentHTML('beforeend',tem)
        let content_height = document.querySelector('.content-wrapper .content').offsetHeight
        // console.log(content_height)
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
  location.href = `https://thavorn-jewelry.com/member/membership/edit.php?id=${id}`
}

function update(){
  const date_dob = convert_date_forDB(document.querySelector('#dob').value)

  let data = new FormData()
  data.append('fullname',document.querySelector('#fullname').value)
  data.append('sex',document.querySelector('#sex').value)
  data.append('dob',date_dob)
  data.append('phone',document.querySelector('#phone').value)
  data.append('address',document.querySelector('#address').value)
  data.append('id_no',document.querySelector('#id_no').value)
  data.append('line_id',document.querySelector('#line_id').value)
  data.append('point',document.querySelector('#point').value)
  data.append('id',document.querySelector('#user_id').value)

  $.ajax({
    method: "POST",
    url: "functions/update-user.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){
      if(result == "success"){
        Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'บันทึกข้อมูลสำเร็จ',
        }).then(()=>{
          location.reload();
        })
      }
      else{
        console.error(result)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด',
          text: 'ไม่สามารถแก้ไขวิชาได้',
        })
        $('#modal-edit').modal('hide')
      }
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

/**
 * @param {string} rawDate convert date from datepicker to formate for DB
 */
function convert_date_forDB(rawDate){
  const con_date = rawDate.split("/")
  let year_con = parseInt(con_date[2])-543
  let date = `${year_con}-${con_date[1]}-${con_date[0]}`
  return date
}

function upload_file(type_file){
  let data = new FormData()
  data.append('id',document.querySelector('#user_id').value)

  if(type_file === 'id'){
    data.append('id_file',document.querySelector('#id_file').files[0])
    data.append('bookbank',"")
  }
  else if(type_file === 'bank'){
    data.append('bookbank',document.querySelector('#bookbank').files[0])
    data.append('id_file',"")
  }

  $.ajax({
    method: "POST",
    url: "functions/upload-file.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){ 
      Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'อัพโหลดสำเร็จ',
      }).then(()=>{
          location.reload()
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถอัพโหลดได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
      })
    }
  })
}

function select_pic(type){
  let pic = ""
  if(type === '1'){
    pic = "id_file"
  }
  else if(type === '2'){
    pic = "bookbank"
  }

  document.querySelector(`#${pic}`).click()
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

// ปุ่มกลับไปหน้าแรก
function goback(){
  location.href = "https://thavorn-jewelry.com/member/membership"
}

// ส่งออกข้อมูล
function export_user(){
  $.ajax({
    method: "GET",
    url: "functions/export-user.php",
    dataType: "json",
    success:function(result){ 
      let conv_result = []
      let date_con
      let year_con
      result.forEach(element => {
        if(element.DOB != "0000-00-00"){
          date_con = element.DOB.split("-")
          year_con = parseInt(date_con[0])+543
          element.DOB = `${year_con}-${date_con[1]}-${date_con[2]}`
        }

        conv_result.push(element);
      });
      // console.log(conv_result)

      const worksheet = XLSX.utils.json_to_sheet(conv_result);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Dates");
      XLSX.writeFile(workbook, "User-Export.xlsx", { compression: true });
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถเรียกข้อมูลได้',
      })
    }
  })
}

window.onload = ()=>{
  get()
}