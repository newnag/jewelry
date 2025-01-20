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
      $('#modal-add').modal('hide')
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

// ปุ่มกลับไปหน้าแรก
function goback(){
  location.href = "https://thavorn-jewelry.com/member/dashboard"
}


document.querySelector('#dob').addEventListener('change',()=>{
  console.log(document.querySelector('#dob').value)
})